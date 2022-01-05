<?php

namespace App\Logic;

use App\Client\Response\TodoOnProjectResponse;
use App\Client\Response\TodoOnResponsibleResponse;
use App\Http\Data\TodoData;
use App\Http\Data\TodoDataNode;
use App\Http\Data\TodoInDayData;
use App\Http\Data\TodoInMonthData;
use App\Utility\DateUtility;
use App\Utility\SortUtility;
use DateTime;

/**
 * 「やること」に関する小部品
 */
class TodoLogic{

    /**
    * コンストラクタ（staticオンリー）
    */
    private function __construct(){}

    /**
     * TodoInDayDataを作成する
     *
     * @param array $todoDataArray
     * @param DateTime $nowDate 現在の日時
     * @return TodoInDayData
     */
    static public function createTodoInDayData(array $todoDataArray, DateTime $nowDate): TodoInDayData
    {
        $sortedTodoDataArray = SortUtility::heapAscSort($todoDataArray,
            function(TodoData $data): int
            {
                return $data->getFinishDate()->getTimestamp();
            }
        );

        $expiredDate = clone $nowDate;
        $approaching = DateUtility::addDate($nowDate, [DateUtility::HOUR => 5]);
        $todayDate = DateUtility::getNextDaysTopDateTime($nowDate);

        $expiredTodoDataArray = [];
        $approachTodoDataArray = [];
        $todayTodoDataArray = [];
        $otherTodoDataArray = [];

        foreach ($sortedTodoDataArray as $todoData) {
            if($todoData->getFinishDate()->getTimestamp() <= $expiredDate->getTimestamp())
                $expiredTodoDataArray[] = $todoData;
            else if($todoData->getFinishDate()->getTimestamp() <= $approaching->getTimestamp())
                $approachTodoDataArray[] = $todoData;
            else if($todoData->getFinishDate()->getTimestamp() <= $todayDate->getTimestamp())
                $todayTodoDataArray[] = $todoData;
            else
                $otherTodoDataArray[] = $todoData;
        }

        $todoInDay = new TodoInDayData();
        $todoInDay->setExpiredTodoList($expiredTodoDataArray);
        $todoInDay->setApproachingTodoList($approachTodoDataArray);
        $todoInDay->setTodaysTodoList($todayTodoDataArray);
        $todoInDay->setOtherTodoList($otherTodoDataArray);
        
        return $todoInDay;
    }

    /**
     * TodoDataの作成
     *
     * @param TodoOnProjectResponse|TodoOnResponsibleResponse $todoResponse
     * @return TodoData
     */
    static public function createTodoData(TodoOnProjectResponse|TodoOnResponsibleResponse $todoResponse): TodoData
    {
        $todoData = new TodoData();
        
        $todoData->setFinishDate($todoResponse->getFinishDate());
        $todoData->setStartDate($todoResponse->getStartDate());
        $todoData->setIsCompleted($todoResponse->getIsCompleted());
        $todoData->setName($todoResponse->getTodoName());

        if($todoResponse instanceof TodoOnProjectResponse){
            $todoData->setIsOnProject(true);
            $todoData->setId($todoResponse->getTodoOnProjectId());
        }else {
            $todoData->setIsOnProject(false);
            $todoData->setId($todoResponse->getTodoOnResponsibleId());
        }

        return $todoData;
    }

    /**
     * TodoDataNodeの作成
     *
     * @param TodoOnProjectResponse|TodoOnResponsibleResponse $todoResponse
     * @return TodoDataNode
     */
    static public function createTodoDataNode(TodoOnProjectResponse|TodoOnResponsibleResponse $todoResponse, int $year, int $month, int $lastDay): TodoDataNode
    {
        $startDay = 1;
        $startDateArray = DateUtility::getDateAssociativeArrayByDateTime($todoResponse->getStartDate());
        if($startDateArray[DateUtility::YEAR] === $year && $startDateArray[DateUtility::MONTH] === $month)
            $startDay = $startDateArray[DateUtility::DAY];

        $dayLength = 0;
        $finishDateArray = DateUtility::getDateAssociativeArrayByDateTime($todoResponse->getFinishDate());
        if($finishDateArray[DateUtility::YEAR] === $year && $finishDateArray[DateUtility::MONTH] === $month)
            $dayLength = $finishDateArray[DateUtility::DAY] - $startDay + 1;
        else 
            $dayLength = $lastDay - $startDay + 1;

        $todoData = new TodoDataNode();
        $todoData->setStartDay($startDay);
        $todoData->setDayLength($dayLength);
        $todoData->setIsCompleted($todoResponse->getIsCompleted());
        $todoData->setName($todoResponse->getTodoName());
        $todoData->setIsEmpty(false);

        if($todoResponse instanceof TodoOnProjectResponse){
            $todoData->setIsOnProject(true);
            $todoData->setId($todoResponse->getTodoOnProjectId());
        }else {
            $todoData->setIsOnProject(false);
            $todoData->setId($todoResponse->getTodoOnResponsibleId());
        }

        return $todoData;
    }

    static public function createTodoInMonth(array $todoOnProjectArray, array $todoOnResponsibleArray, DateTime $finishDate): TodoInMonthData
    {
        //日付関連のデータ取得
        $finishDateArray = DateUtility::getDateAssociativeArrayByDateTime($finishDate);
        $year = $finishDateArray[DateUtility::YEAR];
        $month = $finishDateArray[DateUtility::MONTH];
        $dayLengthInMonth = $finishDateArray[DateUtility::DAY];
        $farstWeek = DateUtility::createDate($year, $month, 1, 0, 0)->format('w');

        //Todoのレスポンス系のオブジェクトからTodoDataNodeを生成
        $todoNodeArray = [];
        foreach ($todoOnProjectArray as $todoResponse)
            $todoNodeArray[] = self::createTodoDataNode($todoResponse, $year, $month, $dayLengthInMonth);
        foreach ($todoOnResponsibleArray as $todoResponse)
            $todoNodeArray[] = self::createTodoDataNode($todoResponse, $year, $month, $dayLengthInMonth);

        //期間が長い順にTodoDataNodeをソート
        $todoNodeSortedArray = SortUtility::heapDescSort($todoNodeArray, function(TodoDataNode $node){
            return $node->getDayLength();
        });

        //TodoDataNodeをつなげていく
        $todoNodeForTodoInMonth = [];
        foreach ($todoNodeSortedArray as $node) {
            $isSetted = false;

            foreach ($todoNodeForTodoInMonth as $nodeInMonth) {
                $nowNode = $nodeInMonth;

                while (!$isSetted && $nowNode !== null) {
                    if($nowNode->getStartDay() <= $node->getStartDay()){
                        if($nowNode->getIsEmpty() && $nowNode->getDayLength() >= $node->getDayLength()){
                            $isSetted = true;
                            self::insertTodoDataNode($nowNode, $node);
                        }else {
                            $nowNode = $nowNode->getNextNode();
                        }
                    }else {
                        break;
                    }
                }

                if($isSetted)
                    break;
            }

            if(!$isSetted){
                $newNode = new TodoDataNode(1, $dayLengthInMonth);
                self::insertTodoDataNode($newNode, $node);
                $todoNodeForTodoInMonth[] = $newNode;
            }
        }

        //TodoInMonthData生成
        $todoInMonthData = new TodoInMonthData();
        $todoInMonthData->setYear($year);
        $todoInMonthData->setMonth($month);
        $todoInMonthData->setFinishDay($dayLengthInMonth);
        $todoInMonthData->setStartWeek($farstWeek);
        $todoInMonthData->setTodoDataNodeArray($todoNodeForTodoInMonth);

        return $todoInMonthData;
    }

    /**
     * TodoDataNodeについて、$emptyNodeの中に$nodeを次のノードとして挿入する。
     * $emptyNodeに既に他のものがセットされている場合はきちんと$nodeの次のノードにセットされる。
     *
     * @param TodoDataNode $emptyNode
     * @param TodoDataNode $node
     * @return void
     */
    static private function insertTodoDataNode(TodoDataNode $emptyNode, TodoDataNode $node)
    {
        $emptyNodeLastDay = $emptyNode->getStartDay() + $emptyNode->getDayLength() - 1;
        $nodeLastDay = $node->getStartDay() + $node->getDayLength() - 1;

        if($emptyNodeLastDay > $nodeLastDay){
            $startDay = $nodeLastDay + 1;
            $dayLength = $emptyNodeLastDay - $nodeLastDay;

            $newNode = new TodoDataNode($startDay, $dayLength);
            $newNode->setNextNode($emptyNode->getNextNode());    
            $node->setNextNode($newNode);
            $newNode->setBackNode($node);
        }

        if($node->getStartDay() - $emptyNode->getStartDay() !== 0 || $emptyNode->getBackNode() === null){
            $emptyNode->setDayLength($node->getStartDay() - $emptyNode->getStartDay());
            $emptyNode->setNextNode($node);
            $node->setBackNode($emptyNode);
        }else{
            $emptyNode->getBackNode()->setNextNode($node);
            $node->setBackNode($emptyNode->getBackNode());
        }    
    }
}
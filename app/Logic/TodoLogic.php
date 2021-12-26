<?php

namespace App\Logic;

use App\Client\Response\TodoOnProjectResponse;
use App\Client\Response\TodoOnResponsibleResponse;
use App\Http\Data\TodoData;
use App\Http\Data\TodoInDayData;
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
}
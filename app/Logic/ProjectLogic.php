<?php

namespace App\Logic;

use App\Client\Response\PrivateProjectResponse;
use App\Client\Response\PublicProjectResponse;
use App\Http\Data\ProjectData;
use App\Http\Data\ProjectDataNode;
use App\Http\Data\ProjectInMonthData;
use App\Http\Data\ProjectListData;
use App\Utility\DateUtility;
use App\Utility\SortUtility;
use DateTime;

class ProjectLogic
{
    /**
    * コンストラクタ
    */
    private function __construct(){}

    static public function createProjectData(PublicProjectResponse|PrivateProjectResponse $response): ProjectData
    {
        $data = new ProjectData();
        $data->setName($response->getProjectName());

        if($response instanceof PublicProjectResponse){
            $data->setId($response->getPublicProjectId());
            $data->setIsPrivate(false);
            $data->setIsCompleted($response->getIsCompleted());
            $data->setStartDateString(DateUtility::dateToString($response->getStartDate()));
            $data->setFinishDateString(DateUtility::dateToString($response->getFinishDate()));
        }else{
            $data->setId($response->getProjectId());
            $data->setIsPrivate(true);
        }

        return $data;
    }

    static public function createProjectListData(array $projectResponseArray, array $privateResponseArray, DateTime $nowDate, bool $isIncludeCompleted): ProjectListData
    {
        $privateProjectDataArray = [];
        foreach ($privateResponseArray as $response) 
            $privateProjectDataArray[] = self::createProjectData($response);

        $sortedProjectResponseArray = SortUtility::heapAscSort($projectResponseArray, function(PublicProjectResponse $response){
            return $response->getFinishDate()->getTimestamp();
        });

        $approachingDate = DateUtility::addDate($nowDate, [DateUtility::HOUR => 5]);
        $expiredProjectList = [];
        $approachingProjectList = [];
        $otherProjectList = [];
        foreach ($sortedProjectResponseArray as $response) {
            if($response->getIsCompleted()){
                if($isIncludeCompleted)
                    $otherProjectList[] = self::createProjectData($response);
            }
            else{
                if($response->getFinishdate()->getTimestamp() < $nowDate->getTimestamp())
                    $expiredProjectList[] = self::createProjectData($response);
                else if($response->getFinishdate()->getTimestamp() <= $approachingDate->getTimestamp())
                    $approachingProjectList[] = self::createProjectData($response);
                else
                    $otherProjectList[] = self::createProjectData($response);
            }
        }

        $projectListData = new ProjectListData();
        $projectListData->setExpiredProjectList($expiredProjectList);
        $projectListData->setApproachingProjectList($approachingProjectList);
        $projectListData->setPrivateProjectList($privateProjectDataArray);
        $projectListData->setOtherProjectList($otherProjectList);

        return $projectListData;
    }

    static public function createProjectInMonthData(array $projectResponseArray, int $year, int $month, bool $isIncludeCompleted): ProjectInMonthData
    {
        //日付関連のデータ取得
        $startDate = DateUtility::createDate($year, $month, 1, 0, 0);
        $finishDate = DateUtility::addDate(
            DateUtility::addDate($startDate, [DateUtility::MONTH => 1]),
            [DateUtility::MINUTE => -1]
        );
        $finishDateArray = DateUtility::getDateAssociativeArrayByDateTime($finishDate);
        $year = $finishDateArray[DateUtility::YEAR];
        $month = $finishDateArray[DateUtility::MONTH];
        $dayLengthInMonth = $finishDateArray[DateUtility::DAY];
        $farstWeek = DateUtility::createDate($year, $month, 1, 0, 0)->format('w');

        //ProjectDataNode生成・加工
        $projectNodeArray = [];
        foreach ($projectResponseArray as $response) {
            if($response->getIsCompleted() && !$isIncludeCompleted ||
                $response->getStartDate()->getTimestamp() < $startDate->getTimestamp() ||
                $response->getFinishDate()->getTimestamp() > $finishDate->getTimestamp())
            {
                break;
            }
            
            $projectNodeArray[] = self::createProjectDataNode($response, $year, $month, $dayLengthInMonth);
        }
        $projectNodeArray = SortUtility::heapDescSort($projectNodeArray, function(ProjectDataNode $node){
            return $node->getDayLength();
        });

        //ProjectDataNodeをつなげる
        $projectNodeArrayForProjectInMonth = [];
        foreach ($projectNodeArray as $node) {
            $isSetted = false;

            foreach ($projectNodeArray as $nodeInMonth) {
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
                $newNode = new ProjectDataNode(1, $dayLengthInMonth);
                self::insertTodoDataNode($newNode, $node);
                $todoNodeForTodoInMonth[] = $newNode;
            }
        }

        //ProjectInMonthData生成
        $projectInMonthData = new ProjectInMonthData();
        $projectInMonthData->setYear($year);
        $projectInMonthData->setMonth($month);
        $projectInMonthData->setFinishDay($dayLengthInMonth);
        $projectInMonthData->setStartWeek($farstWeek);
        $projectInMonthData->setProjectDataNodeArray($projectNodeArrayForProjectInMonth);

        return $projectInMonthData;
    }

    static public function createProjectDataNode(PublicProjectResponse $response, int $year, int $month, int $lastDay): ProjectDataNode
    {
        $startDay = 1;
        $startDateArray = DateUtility::getDateAssociativeArrayByDateTime($response->getStartDate());
        if($startDateArray[DateUtility::YEAR] === $year && $startDateArray[DateUtility::MONTH] === $month)
            $startDay = $startDateArray[DateUtility::DAY];

        $dayLength = 0;
        $finishDateArray = DateUtility::getDateAssociativeArrayByDateTime($response->getFinishDate());
        if($finishDateArray[DateUtility::YEAR] === $year && $finishDateArray[DateUtility::MONTH] === $month)
            $dayLength = $finishDateArray[DateUtility::DAY] - $startDay + 1;
        else 
            $dayLength = $lastDay - $startDay + 1;

        $node = new ProjectDataNode();
        $node->setStartDay($startDay);
        $node->setDayLength($dayLength);
        $node->setId($response->getPublicProjectId());
        $node->setName($response->getProjectName());
        $node->setIsEmpty(false);

        return $node;
    }

    /**
     * ProjectDataNodeについて、$emptyNodeの中に$nodeを次のノードとして挿入する。
     * $emptyNodeに既に他のものがセットされている場合はきちんと$nodeの次のノードにセットされる。
     *
     * @param ProjectDataNode $emptyNode
     * @param ProjectDataNode $node
     * @return void
     */
    static private function insertTodoDataNode(ProjectDataNode $emptyNode, ProjectDataNode $node)
    {
        $emptyNodeLastDay = $emptyNode->getStartDay() + $emptyNode->getDayLength() - 1;
        $nodeLastDay = $node->getStartDay() + $node->getDayLength() - 1;

        if($emptyNodeLastDay > $nodeLastDay){
            $startDay = $nodeLastDay + 1;
            $dayLength = $emptyNodeLastDay - $nodeLastDay;

            $newNode = new ProjectDataNode($startDay, $dayLength);
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
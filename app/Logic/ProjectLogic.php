<?php

namespace App\Logic;

use App\Client\Response\PrivateProjectResponse;
use App\Client\Response\PublicProjectResponse;
use App\Http\Data\ProjectData;
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
}
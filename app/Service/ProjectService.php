<?php

namespace App\Service;

use App\Client\Api\Api;
use App\Http\Data\ProjectData;
use App\Http\Data\ProjectInMonthData;
use App\Http\Data\ProjectListData;
use App\Logic\ProjectLogic;
use DateTime;

class ProjectService
{
    private static ProjectService $instance;

    /**
     * コンストラクタ シングルトン設計のためプライベート
     */
    private function __construct(){}

    /**
     * インスタンスを取得する
     *
     * @return ProjectServiceのインスタンス
     */
    public static function getInstance(): ProjectService
    {
        self::$instance ??= new ProjectService();
        return self::$instance;
    }

    public function getProjectListData(string $oauthToken, DateTime $nowDate, bool $isIncludePrivate = true, bool $isIncludeCompleted = false): ProjectListData
    {
        $projectResponseArray = Api::last()->publicProject()->getListByExample($oauthToken);
        $privateProjectResponseArray = [];
        if($isIncludePrivate)
            $privateProjectResponseArray = Api::last()->privateProject()->getList($oauthToken);

        return ProjectLogic::createProjectListData($projectResponseArray, $privateProjectResponseArray, $nowDate, $isIncludeCompleted);
    }

    public function getProjectInMonthData(string $oauthToken, int $year, int $month, bool $isIncludeCompleted = false): ProjectInMonthData
    {
        $projectResponseArray = Api::last()->publicProject()->getListByExample($oauthToken);

        return ProjectLogic::createProjectInMonthData($projectResponseArray, $year, $month, $isIncludeCompleted);
    }

    public function insertPrivateProject(string $oauthToken, string $projectName)
    {
        Api::last()->privateProject()->post($oauthToken, $projectName);
    }

    public function insertPublicProject(string $oauthToken, string $projectName, DateTime $startDate, DateTime $finishDate): int
    {
        return Api::last()->publicProject()->post($oauthToken, $projectName, $startDate, $finishDate);
    }

    public function getProjectDataByPrivateProject(string $oauthToken, int $projectId): ProjectData
    {
        $response = Api::last()->privateProject()->get($oauthToken, $projectId);
        return ProjectLogic::createProjectData($response);
    }

    public function updatePrivateProject(string $oauthToken, int $projectId, string $projectName)
    {
        Api::last()->privateProject()->put($oauthToken, $projectId, $projectName);
    }

    public function deletePrivateProject(string $oauthToken, int $projectId)
    {
        Api::last()->privateProject()->delete($oauthToken, $projectId);
    }

    public function getProjectDataByPublicProject(string $oauthToken, int $projectId): ProjectData
    {
        $response = Api::last()->publicProject()->get($oauthToken, $projectId);
        return ProjectLogic::createProjectData($response);
    }

    public function updatePublicProject(string $oauthToken, int $projectId, string $projectName,
            DateTime $startDate, DateTime $finishDate)
    {
        Api::last()->publicProject()->put($oauthToken, $projectId, $projectName, $startDate, $finishDate);
    }

    public function setIsCompletedToPublicProject(string $oauthToken, int $projectId, bool $isCompleted)
    {
        Api::last()->publicProject()->postIsCompleted($oauthToken, $projectId, $isCompleted);
    }

    public function deletePublicProject(string $oauthToken, int $projectId)
    {
        Api::last()->publicProject()->delete($oauthToken, $projectId);
    }

    public function getInvitationProjectDataArray(string $oauthToken): array
    {
        $responseArray = Api::last()->publicProject()->getSolicited($oauthToken);
        $dataArray = [];

        foreach ($responseArray as $response)
            $dataArray[] = ProjectLogic::createProjectData($response);
        
        return $dataArray;
    }
}

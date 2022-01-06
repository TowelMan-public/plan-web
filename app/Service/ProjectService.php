<?php

namespace App\Service;

use App\Client\Api\Api;
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
}

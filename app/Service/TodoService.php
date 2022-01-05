<?php

namespace App\Service;

use App\Client\Api\Api;
use App\Http\Data\TodoInDayData;
use App\Http\Data\TodoInMonthData;
use App\Logic\TodoLogic;
use App\Utility\DateUtility;
use ContentLogic;
use DateTime;

class TodoService 
{
    private static TodoService $instance;

    /**
     * コンストラクタ シングルトン設計のためプライベート
     */
    private function __construct() {}

    /**
     * インスタンスを取得する
     *
     * @return TodoServiceのインスタンス
     */
    public static function getInstance(): TodoService
    {
        self::$instance ??= new TodoService();
        return self::$instance;
    }
    
    public function getMyTodoInDayData(string $oauthToken, DateTime $nowDate, DateTime $finishDate, bool $isIncludeCompleted = false): TodoInDayData
    {
        $todoOnProjectArray = Api::last()->todo()->getListByExample($oauthToken, null, null, $finishDate, true, $isIncludeCompleted);
        $todoOnResponsibleArray = Api::last()->todoOnResoinsible()->getListByExample($oauthToken, null, null, $finishDate, $isIncludeCompleted);
        $todoDataArray = [];

        foreach($todoOnProjectArray AS $response){
            $todoData = TodoLogic::createTodoData($response);
            $todoData->setContentList(
                ContentLogic::createContentdataArray(
                    Api::last()->content()->getList($oauthToken, $response->getTodoOnProjectId())));
            $todoDataArray[] = $todoData;
        }

        foreach($todoOnResponsibleArray AS $response){
            $todoData = TodoLogic::createTodoData($response);
            $todoData->setContentList(
                ContentLogic::createContentdataArray(
                    Api::last()->content()->getList($oauthToken, $response->getTodoOnResponsibleId())));
            $todoDataArray[] = $todoData;
        }

        return TodoLogic::createTodoInDayData($todoDataArray, $nowDate);
    }

    
    static public function getMyTodoInMonth(string $oauthToken, int $year, int $month, bool $isIncludeCompleted = false): TodoInMonthData
    {
        $startDate = DateUtility::createDateByDateAssociativeArray([
            DateUtility::YEAR => $year,
            DateUtility::MONTH => $month,
            DateUtility::DAY => 1,
            DateUtility::HOUR => 0,
            DateUtility::MINUTE => 0
        ]);
        $finishDate = DateUtility::addDate(
            DateUtility::addDate($startDate, [DateUtility::MONTH => 1]),
            [DateUtility::MINUTE => -1]
        );
        
        $todoOnProjectArray = Api::last()->todo()->getListByExample($oauthToken, null, $startDate, $finishDate, true, $isIncludeCompleted);
        $todoOnResponsibleArray = Api::last()->todoOnResoinsible()->getListByExample($oauthToken, null, $startDate, $finishDate, $isIncludeCompleted);

        return TodoLogic::createTodoInMonth($todoOnProjectArray, $todoOnResponsibleArray, $finishDate);
    }
}
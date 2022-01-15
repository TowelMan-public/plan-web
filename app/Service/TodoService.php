<?php

namespace App\Service;

use App\Client\Api\Api;
use App\Http\Data\TodoData;
use App\Http\Data\TodoInDayData;
use App\Http\Data\TodoInMonthData;
use App\Logic\ContentLogic;
use App\Logic\TodoLogic;
use App\Utility\DateUtility;
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
        $startDate = DateUtility::addDate($finishDate, [
            DateUtility::HOUR => -23,
            DateUtility::MINUTE => -59
        ]);
        $todoOnProjectArray = Api::last()->todo()->getListByExample($oauthToken, null, $startDate, $finishDate, false, $isIncludeCompleted);
        $todoOnResponsibleArray = Api::last()->todoOnResoinsible()->getListByExample($oauthToken, null, null, $finishDate, $isIncludeCompleted);
        $todoDataArray = [];

        foreach($todoOnProjectArray AS $response){
            $todoData = TodoLogic::createTodoData($response);
            $todoData->setContentList(
                ContentLogic::createContentdataArray(
                    Api::last()->content()->getList($oauthToken, $response->getTodoOnProjectId()), $isIncludeCompleted));
            $todoDataArray[] = $todoData;
        }

        foreach($todoOnResponsibleArray AS $response){
            $todoData = TodoLogic::createTodoData($response);
            $todoData->setContentList(
                ContentLogic::createContentdataArray(
                    Api::last()->content()->getList($oauthToken, $response->getTodoOnResponsibleId()), $isIncludeCompleted));
            $todoDataArray[] = $todoData;
        }

        return TodoLogic::createTodoInDayData($todoDataArray, $nowDate);
    }

    
    public function getMyTodoInMonth(string $oauthToken, int $year, int $month, bool $isIncludeCompleted = false): TodoInMonthData
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

    public function getTodoInProjectInDayData(string $oauthToken, int $projectId, DateTime $nowDate, DateTime $finishDate, bool $isIncludeCompleted): TodoInDayData
    {
        $startDate = DateUtility::addDate($finishDate, [
            DateUtility::HOUR => -23,
            DateUtility::MINUTE => -59
        ]);
        $todoOnProjectArray = Api::last()->todo()->getListByExample($oauthToken, $projectId, $startDate, $finishDate, true, $isIncludeCompleted);
        $todoDataArray = [];

        foreach($todoOnProjectArray AS $response){
            $todoData = TodoLogic::createTodoData($response);
            $todoData->setContentList(
                ContentLogic::createContentdataArray(
                    Api::last()->content()->getList($oauthToken, $response->getTodoOnProjectId()), $isIncludeCompleted));
            $todoDataArray[] = $todoData;
        }

        return TodoLogic::createTodoInDayData($todoDataArray, $nowDate);
    }

    public function getTodoInProjectInMonthData(string $oauthToken, int $projectId, int $year, int $month, bool $isIncludeCompleted): TodoInMonthData
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

        $todoOnProjectArray = Api::last()->todo()->getListByExample($oauthToken, $projectId, $startDate, $finishDate, true, $isIncludeCompleted);

        return TodoLogic::createTodoInMonth($todoOnProjectArray, [], $finishDate);
    }

    public function getResponsibleTodoInProjectInDayData(string $oauthToken, int $projectId, DateTime $nowDate, DateTime $finishDate, bool $isIncludeCompleted): TodoInDayData
    {
        $todoOnResponsibleArray = Api::last()->todoOnResoinsible()->getListByExample($oauthToken, $projectId, null, $finishDate, true, $isIncludeCompleted);
        $todoDataArray = [];

        foreach($todoOnResponsibleArray AS $response){
            $todoData = TodoLogic::createTodoData($response);
            $todoData->setContentList(
                ContentLogic::createContentdataArray(
                    Api::last()->content()->getList($oauthToken, $response->getTodoOnProjectId()), $isIncludeCompleted));
            $todoDataArray[] = $todoData;
        }

        return TodoLogic::createTodoInDayData($todoDataArray, $nowDate);
    }

    public function getResponsibleTodoInProjectInMonthData(string $oauthToken, int $projectId, int $year, int $month, bool $isIncludeCompleted): TodoInMonthData
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

        $todoOnResponsibleArray = Api::last()->todoOnResoinsible()->getListByExample($oauthToken, $projectId, $startDate, $finishDate, true, $isIncludeCompleted);

        return TodoLogic::createTodoInMonth([], $todoOnResponsibleArray, $finishDate);
    }

    public function insertTodoOnProject(string $oauthToken, int $projectId, string $todoName, DateTime $startDate, DateTime $finishDate, bool $isCopyToResponsible): int
    {
        return Api::last()->todo()->post($oauthToken, $projectId, $todoName, $startDate, $finishDate, $isCopyToResponsible);
    }

    public function getTodoOnProject(string $oauthToken, int $todoId): TodoData
    {
        $todoData = TodoLogic::createTodoData(
            Api::last()->todo()->get($oauthToken, $todoId)
        );
        $todoData->setContentList(
            ContentLogic::createContentdataArray(
                Api::last()->content()->getList($oauthToken, $todoId),
                true
            )
        );

        return $todoData;
    }

    public function getTodoOnResponsible(string $oauthToken, int $todoId): TodoData
    {
        $todoData = TodoLogic::createTodoData(
            Api::last()->todoOnResoinsible()->get($oauthToken, $todoId)
        );
        $todoData->setContentList(
            ContentLogic::createContentdataArray(
                Api::last()->content()->getList($oauthToken, $todoId),
                true
            )
        );

        return $todoData;
    }

    public function updateTodoOnProject(string $oauthToken, int $todoId, string $todoName, DateTime $startDate, DateTime $finishDate, bool $isCopyToResponsible)
    {
        Api::last()->todo()->put($oauthToken, $todoId, $todoName, $startDate, $finishDate, $isCopyToResponsible);
    }

    public function deleteTodoOnProject(string $oauthToken, int $todoId)
    {
        Api::last()->todo()->delete($oauthToken, $todoId);
    }

    public function setIsCompletedToTodoOnProject(string $oauthToken, int $todoId, bool $isCompleted)
    {
        Api::last()->todo()->putIsCompleted($oauthToken, $todoId, $isCompleted);
    }

    public function setIsCompletedToTodoOnResponsible(string $oauthToken, int $todoId, bool $isCompleted)
    {
        Api::last()->todoOnResoinsible()->putIsCompleted($oauthToken, $todoId, $isCompleted);
    }

    public function deleteTodoOnResponsible(string $oauthToken, int $todoId, string $userName)
    {
        Api::last()->todoOnResoinsible()->delete($oauthToken, $todoId, $userName);
    }

    public function exitTodoOnResponsible(string $oauthToken, int $todoId)
    {
        Api::last()->todoOnResoinsible()->postExit($oauthToken, $todoId);
    }
}
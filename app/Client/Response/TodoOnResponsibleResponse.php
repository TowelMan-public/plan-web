<?php

class TodoOnResponsibleResponse
{

    private int $todoOnProjectId;
    private string $todoName;
    private int $todoOnResponsibleId;
    private int $projectId;
    private bool $isCompleted;
    private DateTime $startDate;
    private DateTime $finishDate;

    /**
     * TodoOnResponsibleResponse単体を生成する
     * 
     * @param array $arrayData UserResponseの連想配列の配列もしくは連想配列
     * @param boolean $isSingle $arrayDataが連想配列であればtrue、そうでなければfalse。通常はtrue。
     * @return TodoOnResponsibleResponse
     */
    public static function parseTodoOnResponsibleResponse(array $arrayData, bool $isSingle = false): TodoOnResponsibleResponse
    {
        $singleArrayDate = null;
        if ($isSingle)
            $singleArrayDate = $arrayData;
        else
            $singleArrayDate = $arrayData[0];

        $entity = new TodoOnResponsibleResponse();
        $entity->setTodoOnProjectId($singleArrayDate['todoOnProjectId']);
        $entity->setTodoName($singleArrayDate['todoName']);
        $entity->setTodoOnResponsibleId($singleArrayDate['todoOnResponsibleId']);
        $entity->setProjectId($singleArrayDate['projectId']);
        $entity->setIsCompleted($singleArrayDate['isCompleted']);
        $entity->setStartDate($singleArrayDate['startDate']);
        $entity->setFinishDate($singleArrayDate['finishDate']);

        return $entity;
    }

    /**
     * TodoOnResponsibleResponseの配列を生成する
     * 
     * @param array $arrayData UserResponseの連想配列の配列
     * @return array ${1:ClassName}の配列
     */
    public static function parseTodoOnResponsibleResponseArray(array $arrayData): array
    {
        $entityArray = array();
        foreach ($arrayData as $valueArray)
            $entityArray[] = self::parseTodoOnResponsibleResponse($valueArray);

        return $entityArray;
    }

    /**
     * finishDateのセット
     *
     * @param string $finishDateString
     * @return void
     */
    public function setFinishDate(string $finishDateString)
    {
        $this->finishDate = DateUtility::stringToDate($finishDateString);
    }

    /**
     * finishDateの取得
     *
     * @return DateTime
     */
    public function getFinishDate(): DateTime
    {
        return $this->finishDate;
    }

    /**
     * startDateのセット
     *
     * @param string $startDateString
     * @return void
     */
    public function setStartDate(string $startDateString)
    {
        $this->startDate = DateUtility::stringToDate($startDateString);
    }

    /**
     * startDateの取得
     *
     * @return DateTime
     */
    public function getStartDate(): DateTime
    {
        return $this->startDate;
    }

    /**
     * isCompletedのセット
     *
     * @param bool $isCompleted
     * @return void
     */
    public function setIsCompleted(bool $isCompleted)
    {
        $this->isCompleted = $isCompleted;
    }

    /**
     * isCompletedの取得
     *
     * @return bool
     */
    public function getIsCompleted(): bool
    {
        return $this->isCompleted;
    }

    /**
     * projectIdのセット
     *
     * @param int $projectId
     * @return void
     */
    public function setProjectId(int $projectId)
    {
        $this->projectId = $projectId;
    }

    /**
     * projectIdの取得
     *
     * @return int
     */
    public function getProjectId(): int
    {
        return $this->projectId;
    }

    /**
     * todoOnResponsibleIdのセット
     *
     * @param int $todoOnResponsibleId
     * @return void
     */
    public function setTodoOnResponsibleId(int $todoOnResponsibleId)
    {
        $this->todoOnResponsibleId = $todoOnResponsibleId;
    }

    /**
     * todoOnResponsibleIdの取得
     *
     * @return int
     */
    public function getTodoOnResponsibleId(): int
    {
        return $this->todoOnResponsibleId;
    }

    /**
     * todoNameのセット
     *
     * @param string $todoName
     * @return void
     */
    public function setTodoName(string $todoName)
    {
        $this->todoName = $todoName;
    }

    /**
     * todoNameの取得
     *
     * @return string
     */
    public function getTodoName(): string
    {
        return $this->todoName;
    }

    /**
     * todoOnProjectIdのセット
     *
     * @param int $todoOnProjectId
     * @return void
     */
    public function setTodoOnProjectId(int $todoOnProjectId)
    {
        $this->todoOnProjectId = $todoOnProjectId;
    }

    /**
     * todoOnProjectIdの取得
     *
     * @return int
     */
    public function getTodoOnProjectId(): int
    {
        return $this->todoOnProjectId;
    }
}

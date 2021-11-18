<?php

class TodoOnProjectResponse
{

    private int $todoOnProjectId;
    private int $projectId;
    private string $todoName;
    private DateTime $startDate;
    private DateTime $finishDate;
    private bool $isCopyContentsToUsers;
    private bool $isCompleted;

    /**
     * TodoOnProjectResponse単体を生成する
     * 
     * @param array $arrayData UserResponseの連想配列の配列もしくは連想配列
     * @param boolean $isSingle $arrayDataが連想配列であればtrue、そうでなければfalse。通常はtrue。
     * @return TodoOnProjectResponse
     */
    public static function parseTodoOnProjectResponse(array $arrayData, bool $isSingle = false): TodoOnProjectResponse
    {
        $singleArrayDate = null;
        if ($isSingle)
            $singleArrayDate = $arrayData;
        else
            $singleArrayDate = $arrayData[0];

        $entity = new TodoOnProjectResponse();
        $entity->setTodoOnProjectId($singleArrayDate['todoOnProjectId']);
        $entity->setProjectId($singleArrayDate['projectId']);
        $entity->setTodoName($singleArrayDate['todoName']);
        $entity->setStartDate($singleArrayDate['startDate']);
        $entity->setFinishDate($singleArrayDate['finishDate']);
        $entity->setIsCopyContentsToUsers($singleArrayDate['isCopyContentsToUsers']);
        $entity->setIsCompleted($singleArrayDate['isCompleted']);

        return $entity;
    }

    /**
     * TodoOnProjectResponseの配列を生成する
     * 
     * @param array $arrayData UserResponseの連想配列の配列
     * @return array ${1:ClassName}の配列
     */
    public static function parseTodoOnProjectResponseArray(array $arrayData): array
    {
        $entityArray = array();
        foreach ($arrayData as $valueArray)
            $entityArray[] = self::parseTodoOnProjectResponse($valueArray);

        return $entityArray;
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
     * isCopyContentsToUsersのセット
     *
     * @param bool $isCopyContentsToUsers
     * @return void
     */
    public function setIsCopyContentsToUsers(bool $isCopyContentsToUsers)
    {
        $this->isCopyContentsToUsers = $isCopyContentsToUsers;
    }

    /**
     * isCopyContentsToUsersの取得
     *
     * @return bool
     */
    public function getIsCopyContentsToUsers(): bool
    {
        return $this->isCopyContentsToUsers;
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

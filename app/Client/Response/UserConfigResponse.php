<?php

class UserConfigResponse
{

    private int $beforeDeadlineForTodoNotice;
    private int $beforeDeadlineForProjectNotice;
    private bool $isPushInsertedTodoNotice;
    private bool $isPushInsertedStartedTodoNotice;

    /**
     * UserConfigResponse単体を生成する
     * 
     * @param array $arrayData UserResponseの連想配列の配列もしくは連想配列
     * @param boolean $isSingle $arrayDataが連想配列であればtrue、そうでなければfalse。通常はtrue。
     * @return UserConfigResponse
     */
    public static function parseUserConfigResponse(array $arrayData, bool $isSingle = false): UserConfigResponse
    {
        $singleArrayDate = null;
        if ($isSingle)
            $singleArrayDate = $arrayData;
        else
            $singleArrayDate = $arrayData[0];

        $entity = new UserConfigResponse();
        $entity->setBeforeDeadlineForTodoNotice($singleArrayDate['beforeDeadlineForTodoNotice']);
        $entity->setBeforeDeadlineForProjectNotice($singleArrayDate['beforeDeadlineForProjectNotice']);
        $entity->setIsPushInsertedTodoNotice($singleArrayDate['isPushInsertedTodoNotice']);
        $entity->setIsPushInsertedStartedTodoNotice($singleArrayDate['isPushInsertedStartedTodoNotice']);

        return $entity;
    }

    /**
     * UserConfigResponseの配列を生成する
     * 
     * @param array $arrayData UserResponseの連想配列の配列
     * @return array ${1:ClassName}の配列
     */
    public static function parseUserConfigResponseArray(array $arrayData): array
    {
        $entityArray = array();
        foreach ($arrayData as $valueArray)
            $entityArray[] = self::parseUserConfigResponse($valueArray);

        return $entityArray;
    }

    /**
     * isPushInsertedStartedTodoNoticeのセット
     *
     * @param bool $isPushInsertedStartedTodoNotice
     * @return void
     */
    public function setIsPushInsertedStartedTodoNotice(bool $isPushInsertedStartedTodoNotice)
    {
        $this->isPushInsertedStartedTodoNotice = $isPushInsertedStartedTodoNotice;
    }

    /**
     * isPushInsertedStartedTodoNoticeの取得
     *
     * @return bool
     */
    public function getIsPushInsertedStartedTodoNotice(): bool
    {
        return $this->isPushInsertedStartedTodoNotice;
    }

    /**
     * isPushInsertedTodoNoticeのセット
     *
     * @param bool $isPushInsertedTodoNotice
     * @return void
     */
    public function setIsPushInsertedTodoNotice(bool $isPushInsertedTodoNotice)
    {
        $this->isPushInsertedTodoNotice = $isPushInsertedTodoNotice;
    }

    /**
     * isPushInsertedTodoNoticeの取得
     *
     * @return bool
     */
    public function getIsPushInsertedTodoNotice(): bool
    {
        return $this->isPushInsertedTodoNotice;
    }

    /**
     * beforeDeadlineForProjectNoticeのセット
     *
     * @param int $beforeDeadlineForProjectNotice
     * @return void
     */
    public function setBeforeDeadlineForProjectNotice(int $beforeDeadlineForProjectNotice)
    {
        $this->beforeDeadlineForProjectNotice = $beforeDeadlineForProjectNotice;
    }

    /**
     * beforeDeadlineForProjectNoticeの取得
     *
     * @return int
     */
    public function getBeforeDeadlineForProjectNotice(): int
    {
        return $this->beforeDeadlineForProjectNotice;
    }

    /**
     * beforeDeadlineForTodoNoticeのセット
     *
     * @param int $beforeDeadlineForTodoNotice
     * @return void
     */
    public function setBeforeDeadlineForTodoNotice(int $beforeDeadlineForTodoNotice)
    {
        $this->beforeDeadlineForTodoNotice = $beforeDeadlineForTodoNotice;
    }

    /**
     * beforeDeadlineForTodoNoticeの取得
     *
     * @return int
     */
    public function getBeforeDeadlineForTodoNotice(): int
    {
        return $this->beforeDeadlineForTodoNotice;
    }
}

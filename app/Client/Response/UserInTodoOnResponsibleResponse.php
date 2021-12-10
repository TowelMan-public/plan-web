<?php

namespace App\Client\Response;

class UserInTodoOnResponsibleResponse
{

    private int $todoOnProjectId;
    private bool $isCompleted;
    private string $userName;

    /**
     * UserInTodoOnResponsibleResponse単体を生成する
     * 
     * @param array $arrayData UserResponseの連想配列の配列もしくは連想配列
     * @return UserInTodoOnResponsibleResponse
     */
    public static function parseUserInTodoOnResponsibleResponse(array $arrayData): UserInTodoOnResponsibleResponse
    {
        $singleArrayDate = $arrayData;

        $entity = new UserInTodoOnResponsibleResponse();
        $entity->setTodoOnProjectId($singleArrayDate['todoOnProjectId']);
        $entity->setIsCompleted($singleArrayDate['isCompleted']);
        $entity->setUserName($singleArrayDate['userName']);

        return $entity;
    }

    /**
     * UserInTodoOnResponsibleResponseの配列を生成する
     * 
     * @param array $arrayData UserResponseの連想配列の配列
     * @return array ${1:ClassName}の配列
     */
    public static function parseUserInTodoOnResponsibleResponseArray(array $arrayData): array
    {
        $entityArray = array();
        foreach ($arrayData as $valueArray)
            $entityArray[] = self::parseUserInTodoOnResponsibleResponse($valueArray);

        return $entityArray;
    }

    /**
     * userNameのセット
     *
     * @param string $userName
     * @return void
     */
    public function setUserName(string $userName)
    {
        $this->userName = $userName;
    }

    /**
     * userNameの取得
     *
     * @return string
     */
    public function getUserName(): string
    {
        return $this->userName;
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

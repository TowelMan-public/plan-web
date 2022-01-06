<?php

namespace App\Client\Response;

class UserResponse
{

    private string $userName;
    private string $userNickName;

    /**
     * UserResponse単体を生成する
     * 
     * @param array $arrayData UserResponseの連想配列の配列もしくは連想配列
     * @return UserResponse
     */
    public static function parseUserResponse(array $arrayData): UserResponse
    {
        $singleArrayDate = $arrayData;

        $entity = new UserResponse();
        $entity->setUserName($singleArrayDate['userName']);
        $entity->setUserNickName($singleArrayDate['userNickname']);

        return $entity;
    }

    /**
     * UserResponseの配列を生成する
     * 
     * @param array $arrayData UserResponseの連想配列の配列
     * @return array ${1:ClassName}の配列
     */
    public static function parseUserResponseArray(array $arrayData): array
    {
        $entityArray = array();
        foreach ($arrayData as $valueArray)
            $entityArray[] = self::parseUserResponse($valueArray);

        return $entityArray;
    }

    /**
     * userNickNameのセット
     *
     * @param string $userNickName
     * @return void
     */
    public function setUserNickName(string $userNickName)
    {
        $this->userNickName = $userNickName;
    }

    /**
     * userNickNameの取得
     *
     * @return string
     */
    public function getUserNickName(): string
    {
        return $this->userNickName;
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
}

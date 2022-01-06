<?php

namespace App\Http\Data;

class UserData
{
    private string $userName;

    private string $userNickName;

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

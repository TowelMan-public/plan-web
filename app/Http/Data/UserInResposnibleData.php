<?php

namespace App\Http\Data;

class UserInResposnibleData
{
    private bool $isCompleted;

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
}

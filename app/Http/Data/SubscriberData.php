<?php

namespace App\Http\Data;

use App\Config\AuthorityInPublicProject;

class SubscriberData
{
    private string $userName;

    private int $authorityId;

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

    public function hasSuperAuthority()
    {
        return $this->authorityId === AuthorityInPublicProject::SUPER;
    }

    public function hasTentativeAuthority()
    {
        return $this->authorityId === AuthorityInPublicProject::TENTATIVE;
    }

    /**
     * authorityIdのセット
     * 
     * @param int $authorityId
     * @return void
     */
    public function setAuthorityId(int $authorityId)
    {
        $this->authorityId = $authorityId;
    }

    /**
     * authorityIdの取得
     * 
     * @return int
     */
    public function getAuthorityId(): int
    {
        return $this->authorityId;
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

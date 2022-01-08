<?php

namespace App\Client\Response;

class SubscriberInPublicProjectResponse
{

    private int $publicProjectId;
    private string $userName;
    private int $projectAuthority;

    /**
     * SubscriberInPublicProjectResponse単体を生成する
     * 
     * @param array $arrayData UserResponseの連想配列の配列もしくは連想配列
     * @return SubscriberInPublicProjectResponse
     */
    public static function parseSubscriberInPublicProjectResponse(array $arrayData): SubscriberInPublicProjectResponse
    {
        $singleArrayDate = $arrayData;

        $entity = new SubscriberInPublicProjectResponse();
        $entity->setPublicProjectId($singleArrayDate['publicProjectId']);
        $entity->setUserName($singleArrayDate['userName']);
        $entity->setProjectAuthority($singleArrayDate['authorityId']);

        return $entity;
    }

    /**
     * SubscriberInPublicProjectResponseの配列を生成する
     * 
     * @param array $arrayData UserResponseの連想配列の配列
     * @return array ${1:ClassName}の配列
     */
    public static function parseSubscriberInPublicProjectResponseArray(array $arrayData): array
    {
        $entityArray = array();
        foreach ($arrayData as $valueArray)
            $entityArray[] = self::parseSubscriberInPublicProjectResponse($valueArray);

        return $entityArray;
    }

    /**
     * projectAuthorityのセット
     *
     * @param string $projectAuthority
     * @return void
     */
    public function setProjectAuthority(int $projectAuthority)
    {
        $this->projectAuthority = $projectAuthority;
    }

    /**
     * projectAuthorityの取得
     *
     * @return int
     */
    public function getProjectAuthority(): int
    {
        return $this->projectAuthority;
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
     * publicProjectIdのセット
     *
     * @param int $publicProjectId
     * @return void
     */
    public function setPublicProjectId(int $publicProjectId)
    {
        $this->publicProjectId = $publicProjectId;
    }

    /**
     * publicProjectIdの取得
     *
     * @return int
     */
    public function getPublicProjectId(): int
    {
        return $this->publicProjectId;
    }
}

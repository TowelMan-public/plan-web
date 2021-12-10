<?php

namespace App\Client\Response;

class PrivateProjectResponse
{

    private int $projectId;
    private string $projectName;

    /**
     * PrivateProjectResponse単体を生成する
     * 
     * @param array $arrayData UserResponseの連想配列の配列もしくは連想配列
     * @return PrivateProjectResponse
     */
    public static function parsePrivateProjectResponse(array $arrayData): PrivateProjectResponse
    {
        $singleArrayDate = $arrayData;

        $entity = new PrivateProjectResponse();
        $entity->setProjectId($singleArrayDate['projectId']);
        $entity->setProjectName($singleArrayDate['projectName']);

        return $entity;
    }

    /**
     * PrivateProjectResponseの配列を生成する
     * 
     * @param array $arrayData UserResponseの連想配列の配列
     * @return array ${1:ClassName}の配列
     */
    public static function parsePrivateProjectResponseArray(array $arrayData): array
    {
        $entityArray = array();
        foreach ($arrayData as $valueArray)
            $entityArray[] = self::parsePrivateProjectResponse($valueArray);

        return $entityArray;
    }

    /**
     * projectNameのセット
     *
     * @param string $projectName
     * @return void
     */
    public function setProjectName(string $projectName)
    {
        $this->projectName = $projectName;
    }

    /**
     * projectNameの取得
     *
     * @return string
     */
    public function getProjectName(): string
    {
        return $this->projectName;
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
}

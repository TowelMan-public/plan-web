<?php

class PublicProjectResponse
{

    private int $publicProjectId;
    private string $projectName;
    private DateTime $startDate;
    private DateTime $finishDate;
    private bool $isCompleted;
    private string $projectAuthority;

    /**
     * PublicProjectResponse単体を生成する
     * 
     * @param array $arrayData UserResponseの連想配列の配列もしくは連想配列
     * @param boolean $isSingle $arrayDataが連想配列であればtrue、そうでなければfalse。通常はtrue。
     * @return PublicProjectResponse
     */
    public static function parsePublicProjectResponse(array $arrayData, bool $isSingle = false): PublicProjectResponse
    {
        $singleArrayDate = null;
        if ($isSingle)
            $singleArrayDate = $arrayData;
        else
            $singleArrayDate = $arrayData[0];

        $entity = new PublicProjectResponse();
        $entity->setPublicProjectId($singleArrayDate['publicProjectId']);
        $entity->setProjectName($singleArrayDate['projectName']);
        $entity->setStartDate($singleArrayDate['startDate']);
        $entity->setFinishDate($singleArrayDate['finishDate']);
        $entity->setIsCompleted($singleArrayDate['isCompleted']);
        $entity->setProjectAuthority($singleArrayDate['projectAuthority']);

        return $entity;
    }

    /**
     * PublicProjectResponseの配列を生成する
     * 
     * @param array $arrayData UserResponseの連想配列の配列
     * @return array ${1:ClassName}の配列
     */
    public static function parsePublicProjectResponseArray(array $arrayData): array
    {
        $entityArray = array();
        foreach ($arrayData as $valueArray)
            $entityArray[] = self::parsePublicProjectResponse($valueArray);

        return $entityArray;
    }

    /**
     * projectAuthorityのセット
     *
     * @param string $projectAuthority
     * @return void
     */
    public function setProjectAuthority(string $projectAuthority)
    {
        $this->projectAuthority = $projectAuthority;
    }

    /**
     * projectAuthorityの取得
     *
     * @return string
     */
    public function getProjectAuthority(): string
    {
        return $this->projectAuthority;
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

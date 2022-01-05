<?php

namespace App\Http\Data;

class ProjectListData
{
    private array $expiredProjectList;

    private array $approachingProjectList;

    private array $privateProjectList;

    private array $otherProjectList;

    /**
     * otherProjectListのセット
     * 
     * @param array $otherProjectList
     * @return void
     */
    public function setOtherProjectList(array $otherProjectList)
    {
        $this->otherProjectList = $otherProjectList;
    }

    /**
     * otherProjectListの取得
     * 
     * @return array
     */
    public function getOtherProjectList(): array
    {
        return $this->otherProjectList;
    }

    /**
     * privateProjectListのセット
     * 
     * @param array $privateProjectList
     * @return void
     */
    public function setPrivateProjectList(array $privateProjectList)
    {
        $this->privateProjectList = $privateProjectList;
    }

    /**
     * privateProjectListの取得
     * 
     * @return array
     */
    public function getPrivateProjectList(): array
    {
        return $this->privateProjectList;
    }

    /**
     * approachingProjectListのセット
     * 
     * @param array $approachingProjectList
     * @return void
     */
    public function setApproachingProjectList(array $approachingProjectList)
    {
        $this->approachingProjectList = $approachingProjectList;
    }

    /**
     * approachingProjectListの取得
     * 
     * @return array
     */
    public function getApproachingProjectList(): array
    {
        return $this->approachingProjectList;
    }

    /**
     * expiredProjectListのセット
     * 
     * @param array $expiredProjectList
     * @return void
     */
    public function setExpiredProjectList(array $expiredProjectList)
    {
        $this->expiredProjectList = $expiredProjectList;
    }

    /**
     * expiredProjectListの取得
     * 
     * @return array
     */
    public function getExpiredProjectList(): array
    {
        return $this->expiredProjectList;
    }
}

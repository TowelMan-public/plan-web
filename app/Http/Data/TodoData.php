<?php

namespace App\Http\Data;

use App\Utility\DateUtility;
use DateTime;

/**
 * 「やること」のデータ
 */
class TodoData
{
    private string $name;

    private int $id;

    private bool $isCompleted;

    private array $contentList;

    private DateTime $finishDate;

    private DateTime $startDate;

    private bool $isOnProject;

    private bool $isCopyToResponsible;

    private int $projectId;

    private int $todoOnResponsibleId;


    /**
     * todoOnResponsibleIdのセット
     * 
     * @param int $todoOnResponsibleId
     * @return void
     */
    public function setTodoOnResponsibleId(int $todoOnResponsibleId)
    {
        $this->todoOnResponsibleId = $todoOnResponsibleId;
    }

    /**
     * todoOnResponsibleIdの取得
     * 
     * @return int
     */
    public function getTodoOnResponsibleId(): int
    {
        return $this->todoOnResponsibleId;
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

    /**
     * コンストラクタ
     */
    public function __construct()
    {
        $this->isCopyToResponsible = true;
        $this->projectId = 0;
    }

    /**
     * isCopyToResponsibleのセット
     * 
     * @param bool $isCopyToResponsible
     * @return void
     */
    public function setIsCopyToResponsible(bool $isCopyToResponsible)
    {
        $this->isCopyToResponsible = $isCopyToResponsible;
    }

    /**
     * isCopyToResponsibleの取得
     * 
     * @return bool
     */
    public function getIsCopyToResponsible(): bool
    {
        return $this->isCopyToResponsible;
    }

    public function getStartDateAssociativeArray(): array
    {
        return DateUtility::getDateAssociativeArrayByDateTime($this->startDate);
    }

    public function getFinishDateAssociativeArray(): array
    {
        return DateUtility::getDateAssociativeArrayByDateTime($this->finishDate);
    }

    /**
     * isOnProjectのセット
     * 
     * @param bool $isOnProject
     * @return void
     */
    public function setIsOnProject(bool $isOnProject)
    {
        $this->isOnProject = $isOnProject;
    }

    /**
     * isOnProjectの取得
     * 
     * @return bool
     */
    public function getIsOnProject(): bool
    {
        return $this->isOnProject;
    }

    /**
     * startDateのセット
     * 
     * @param DateTime $startDate
     * @return void
     */
    public function setStartDate(DateTime $startDate)
    {
        $this->startDate = $startDate;
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
     * finishDateのセット
     * 
     * @param DateTime $finishDate
     * @return void
     */
    public function setFinishDate(DateTime $finishDate)
    {
        $this->finishDate = $finishDate;
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
     * contentListのセット
     * 
     * @param array $contentList
     * @return void
     */
    public function setContentList(array $contentList)
    {
        $this->contentList = $contentList;
    }

    /**
     * contentListの取得
     * 
     * @return array
     */
    public function getContentList(): array
    {
        return $this->contentList;
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
     * idのセット
     * 
     * @param int $id
     * @return void
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * idの取得
     * 
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * nameのセット
     * 
     * @param string $name
     * @return void
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * nameの取得
     * 
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}

<?php

namespace App\Http\Data;

class TodoDataNode
{
    private string $name;

    private int $id;

    private bool $isCompleted;

    private bool $isOnProject;

    private bool $isEmpty;

    private int $startDay;

    private int $dayLength;

    private TodoDataNode|null $backNode;

    private TodoDataNode|null $nextNode;

    /**
     * コンストラクタ
     *
     * @param integer|null $startDay
     * @param integer|null $dayLength
     */
    public function __construct(int $startDay = null, int $dayLength = null)
    {
        $this->isEmpty = true;
        if($startDay !== null)
            $this->startDay = $startDay;
        if($dayLength !== null)
            $this->dayLength = $dayLength;

        $this->backNode = null;
        $this->nextNode = null;
    }

    /**
     * nextNodeのセット
     * 
     * @param TodoDataNode|null $nextNode
     * @return void
     */
    public function setNextNode(TodoDataNode|null $nextNode)
    {
        $this->nextNode = $nextNode;
    }

    /**
     * nextNodeの取得
     * 
     * @return TodoDataNode|null
     */
    public function getNextNode(): TodoDataNode|null
    {
        return $this->nextNode;
    }

    /**
     * backNodeのセット
     * 
     * @param TodoDataNode|null $backNode
     * @return void
     */
    public function setBackNode(TodoDataNode|null $backNode)
    {
        $this->backNode = $backNode;
    }

    /**
     * backNodeの取得
     * 
     * @return TodoDataNode|null
     */
    public function getBackNode(): TodoDataNode|null
    {
        return $this->backNode;
    }

    /**
     * dayLengthのセット
     * 
     * @param int $dayLength
     * @return void
     */
    public function setDayLength(int $dayLength)
    {
        $this->dayLength = $dayLength;
    }

    /**
     * dayLengthの取得
     * 
     * @return int
     */
    public function getDayLength(): int
    {
        return $this->dayLength;
    }

    /**
     * startDayのセット
     * 
     * @param int $startDay
     * @return void
     */
    public function setStartDay(int $startDay)
    {
        $this->startDay = $startDay;
    }

    /**
     * startDayの取得
     * 
     * @return int
     */
    public function getStartDay(): int
    {
        return $this->startDay;
    }

    /**
     * isEmptyのセット
     * 
     * @param bool $isEmpty
     * @return void
     */
    public function setIsEmpty(bool $isEmpty)
    {
        $this->isEmpty = $isEmpty;
    }

    /**
     * isEmptyの取得
     * 
     * @return bool
     */
    public function getIsEmpty(): bool
    {
        return $this->isEmpty;
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

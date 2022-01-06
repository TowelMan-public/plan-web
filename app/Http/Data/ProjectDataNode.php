<?php

namespace App\Http\Data;

class ProjectDataNode
{
    private string $name;

    private int $id;

    private bool $isEmpty;

    private int $startDay;

    private int $dayLength;

    private ProjectDataNode|null $backNode;

    private ProjectDataNode|null $nextNode;

    /**
     * コンストラクタ
     *
     * @param integer|null $startDay
     * @param integer|null $dayLength
     */
    public function __construct(int $startDay = null, int $dayLength = null)
    {
        $this->isEmpty = true;
        if ($startDay !== null)
            $this->startDay = $startDay;
        if ($dayLength !== null)
            $this->dayLength = $dayLength;

        $this->backNode = null;
        $this->nextNode = null;
    }

    /**
     * nextNodeのセット
     * 
     * @param ProjectDataNode|null $nextNode
     * @return void
     */
    public function setNextNode(ProjectDataNode|null $nextNode)
    {
        $this->nextNode = $nextNode;
    }

    /**
     * nextNodeの取得
     * 
     * @return ProjectDataNode|null
     */
    public function getNextNode(): ProjectDataNode|null
    {
        return $this->nextNode;
    }

    /**
     * backNodeのセット
     * 
     * @param ProjectDataNode|null $backNode
     * @return void
     */
    public function setBackNode(ProjectDataNode|null $backNode)
    {
        $this->backNode = $backNode;
    }

    /**
     * backNodeの取得
     * 
     * @return ProjectDataNode|null
     */
    public function getBackNode(): ProjectDataNode|null
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

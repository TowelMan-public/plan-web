<?php

namespace App\Http\Data;

use App\Exception\LllegalException;

class ProjectData
{
    private int $id;

    private string $name;

    private bool $isPrivate;

    private string $startDateString;

    private string $finishDateString;

    private bool $isCompleted;

    /**
    * コンストラクタ
    */
    public function __construct()
    {
        $this->isPrivate = true;
    }

    /**
     * isCompletedのセット
     * 
     * @param bool $isCompleted
     * @return void
     */
    public function setIsCompleted(bool $isCompleted)
    {
        if($this->isPrivate)
            throw new LllegalException("This is PrivateProject.\n so, this method can not be used.");
        else
            $this->isCompleted = $isCompleted;
    }

    /**
     * isCompletedの取得
     * 
     * @return bool
     */
    public function getIsCompleted(): bool
    {
        if($this->isPrivate)
            throw new LllegalException("This is PrivateProject.\n so, this method can not be used.");
        else
            return $this->isCompleted;
    }

    /**
     * finishDateStringのセット
     * 
     * @param string $finishDateString
     * @return void
     */
    public function setFinishDateString(string $finishDateString)
    {
        if($this->isPrivate)
            throw new LllegalException("This is PrivateProject.\n so, this method can not be used.");
        else
            $this->finishDateString = $finishDateString;
    }

    /**
     * finishDateStringの取得
     * 
     * @return string
     */
    public function getFinishDateString(): string
    {
        if($this->isPrivate)
            throw new LllegalException("This is PrivateProject.\n so, this method can not be used.");
        else
            return $this->finishDateString;
    }

    /**
     * startDateStringのセット
     * 
     * @param string $startDateString
     * @return void
     */
    public function setStartDateString(string $startDateString)
    {
        if($this->isPrivate)
            throw new LllegalException("This is PrivateProject.\n so, this method can not be used.");
        else
            $this->startDateString = $startDateString;
    }

    /**
     * startDateStringの取得
     * 
     * @return string
     */
    public function getStartDateString(): string
    {
        if($this->isPrivate)
            throw new LllegalException("This is PrivateProject.\n so, this method can not be used.");
        else
            return $this->startDateString;
    }

    /**
     * isPrivateのセット
     * 
     * @param bool $isPrivate
     * @return void
     */
    public function setIsPrivate(bool $isPrivate)
    {
        $this->isPrivate = $isPrivate;
    }

    /**
     * isPrivateの取得
     * 
     * @return bool
     */
    public function getIsPrivate(): bool
    {
        return $this->isPrivate;
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
}
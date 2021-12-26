<?php

namespace App\Http\Data;

/**
 * 「やること」の内容のデータ
 */
class ContentData
{
    private int $id;

    private string $title;

    private bool $isCompleted;

    private string $explanation;


    /**
     * explanationのセット
     * 
     * @param string $explanation
     * @return void
     */
    public function setExplanation(string $explanation)
    {
        $this->explanation = $explanation;
    }

    /**
     * explanationの取得
     * 
     * @return string
     */
    public function getExplanation(): string
    {
        return $this->explanation;
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
     * titleのセット
     * 
     * @param string $title
     * @return void
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * titleの取得
     * 
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
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

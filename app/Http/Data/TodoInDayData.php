<?php

namespace App\Http\Data;

/**
 * 一日の中の「やること」のデータ
 */
class TodoInDayData
{
    private array $expiredTodoList;

    private array $approachingTodoList;

    private array $todaysTodoList;

    private array $otherTodoList;

    /**
     * otherTodoListのセット
     * 
     * @param array $otherTodoList
     * @return void
     */
    public function setOtherTodoList(array $otherTodoList)
    {
        $this->otherTodoList = $otherTodoList;
    }

    /**
     * otherTodoListの取得
     * 
     * @return array
     */
    public function getOtherTodoList(): array
    {
        return $this->otherTodoList;
    }

    /**
     * todaysTodoListのセット
     * 
     * @param array $todaysTodoList
     * @return void
     */
    public function setTodaysTodoList(array $todaysTodoList)
    {
        $this->todaysTodoList = $todaysTodoList;
    }

    /**
     * todaysTodoListの取得
     * 
     * @return array
     */
    public function getTodaysTodoList(): array
    {
        return $this->todaysTodoList;
    }

    /**
     * approachingTodoListのセット
     * 
     * @param array $approachingTodoList
     * @return void
     */
    public function setApproachingTodoList(array $approachingTodoList)
    {
        $this->approachingTodoList = $approachingTodoList;
    }

    /**
     * approachingTodoListの取得
     * 
     * @return array
     */
    public function getApproachingTodoList(): array
    {
        return $this->approachingTodoList;
    }

    /**
     * expiredTodoListのセット
     * 
     * @param array $expiredTodoList
     * @return void
     */
    public function setExpiredTodoList(array $expiredTodoList)
    {
        $this->expiredTodoList = $expiredTodoList;
    }

    /**
     * expiredTodoListの取得
     * 
     * @return array
     */
    public function getExpiredTodoList(): array
    {
        return $this->expiredTodoList;
    }
}

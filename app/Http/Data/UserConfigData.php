<?php

namespace App\Http\Data;

class UserConfigData
{
    private int $beforeDeadlineForProjectNoticeDay;

    private int $beforeDeadlineForProjectNoticeHour;

    private int $beforeDeadlineForProjectNoticeMinute;

    private int $beforeDeadlineForTodoNoticeDay;

    private int $beforeDeadlineForTodoNoticeHour;

    private int $beforeDeadlineForTodoNoticeMinute;

    private bool $isPushInsertedTodoNotice;

    private bool $isPushStartedTodoNotice;

    /**
     * isPushStartedTodoNoticeのセット
     * 
     * @param bool $isPushStartedTodoNotice
     * @return void
     */
    public function setIsPushStartedTodoNotice(bool $isPushStartedTodoNotice)
    {
        $this->isPushStartedTodoNotice = $isPushStartedTodoNotice;
    }

    /**
     * isPushStartedTodoNoticeの取得
     * 
     * @return bool
     */
    public function getIsPushStartedTodoNotice(): bool
    {
        return $this->isPushStartedTodoNotice;
    }

    /**
     * isPushInsertedTodoNoticeのセット
     * 
     * @param bool $isPushInsertedTodoNotice
     * @return void
     */
    public function setIsPushInsertedTodoNotice(bool $isPushInsertedTodoNotice)
    {
        $this->isPushInsertedTodoNotice = $isPushInsertedTodoNotice;
    }

    /**
     * isPushInsertedTodoNoticeの取得
     * 
     * @return bool
     */
    public function getIsPushInsertedTodoNotice(): bool
    {
        return $this->isPushInsertedTodoNotice;
    }

    /**
     * beforeDeadlineForTodoNoticeMinuteのセット
     * 
     * @param int $beforeDeadlineForTodoNoticeMinute
     * @return void
     */
    public function setBeforeDeadlineForTodoNoticeMinute(int $beforeDeadlineForTodoNoticeMinute)
    {
        $this->beforeDeadlineForTodoNoticeMinute = $beforeDeadlineForTodoNoticeMinute;
    }

    /**
     * beforeDeadlineForTodoNoticeMinuteの取得
     * 
     * @return int
     */
    public function getBeforeDeadlineForTodoNoticeMinute(): int
    {
        return $this->beforeDeadlineForTodoNoticeMinute;
    }

    /**
     * beforeDeadlineForTodoNoticeHourのセット
     * 
     * @param int $beforeDeadlineForTodoNoticeHour
     * @return void
     */
    public function setBeforeDeadlineForTodoNoticeHour(int $beforeDeadlineForTodoNoticeHour)
    {
        $this->beforeDeadlineForTodoNoticeHour = $beforeDeadlineForTodoNoticeHour;
    }

    /**
     * beforeDeadlineForTodoNoticeHourの取得
     * 
     * @return int
     */
    public function getBeforeDeadlineForTodoNoticeHour(): int
    {
        return $this->beforeDeadlineForTodoNoticeHour;
    }

    /**
     * beforeDeadlineForTodoNoticeDayのセット
     * 
     * @param int $beforeDeadlineForTodoNoticeDay
     * @return void
     */
    public function setBeforeDeadlineForTodoNoticeDay(int $beforeDeadlineForTodoNoticeDay)
    {
        $this->beforeDeadlineForTodoNoticeDay = $beforeDeadlineForTodoNoticeDay;
    }

    /**
     * beforeDeadlineForTodoNoticeDayの取得
     * 
     * @return int
     */
    public function getBeforeDeadlineForTodoNoticeDay(): int
    {
        return $this->beforeDeadlineForTodoNoticeDay;
    }

    /**
     * beforeDeadlineForProjectNoticeMinuteのセット
     * 
     * @param int $beforeDeadlineForProjectNoticeMinute
     * @return void
     */
    public function setBeforeDeadlineForProjectNoticeMinute(int $beforeDeadlineForProjectNoticeMinute)
    {
        $this->beforeDeadlineForProjectNoticeMinute = $beforeDeadlineForProjectNoticeMinute;
    }

    /**
     * beforeDeadlineForProjectNoticeMinuteの取得
     * 
     * @return int
     */
    public function getBeforeDeadlineForProjectNoticeMinute(): int
    {
        return $this->beforeDeadlineForProjectNoticeMinute;
    }

    /**
     * beforeDeadlineForProjectNoticeHourのセット
     * 
     * @param int $beforeDeadlineForProjectNoticeHour
     * @return void
     */
    public function setBeforeDeadlineForProjectNoticeHour(int $beforeDeadlineForProjectNoticeHour)
    {
        $this->beforeDeadlineForProjectNoticeHour = $beforeDeadlineForProjectNoticeHour;
    }

    /**
     * beforeDeadlineForProjectNoticeHourの取得
     * 
     * @return int
     */
    public function getBeforeDeadlineForProjectNoticeHour(): int
    {
        return $this->beforeDeadlineForProjectNoticeHour;
    }

    /**
     * beforeDeadlineForProjectNoticeDayのセット
     * 
     * @param int $beforeDeadlineForProjectNoticeDay
     * @return void
     */
    public function setBeforeDeadlineForProjectNoticeDay(int $beforeDeadlineForProjectNoticeDay)
    {
        $this->beforeDeadlineForProjectNoticeDay = $beforeDeadlineForProjectNoticeDay;
    }

    /**
     * beforeDeadlineForProjectNoticeDayの取得
     * 
     * @return int
     */
    public function getBeforeDeadlineForProjectNoticeDay(): int
    {
        return $this->beforeDeadlineForProjectNoticeDay;
    }
}

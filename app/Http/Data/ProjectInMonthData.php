<?php

namespace App\Http\Data;

class ProjectInMonthData{
    private int $year;

    private int $month;

    private int $finishDay;

    private array $projectDataNodeArray;

    private int $startWeek;

    private array $colorArray = [];

    /**
    * コンストラクタ
    */
    public function __construct()
    {
        $this->colorArray[] = "#90d2f0";
        $this->colorArray[] = "#55beee";
        $this->colorArray[] = "#00aeff";
        $this->colorArray[] = "#01ff9e";
        $this->colorArray[] = "#00ff37";
        $this->colorArray[] = "#58f87b";
        $this->colorArray[] = "#77d83e";
        $this->colorArray[] = "#c6fd00";
        $this->colorArray[] = "#f9fd00";
        $this->colorArray[] = "#ffbb00";
    }

    public function getBackGroundCollor(int $arrayIndex): string
    {
        return $this->colorArray[$arrayIndex % count($this->colorArray)];
    }

    /**
     * startWeekのセット
     * 
     * @param int $startWeek
     * @return void
     */
    public function setStartWeek(int $startWeek)
    {
        $this->startWeek = $startWeek;
    }

    /**
     * startWeekの取得
     * 
     * @return int
     */
    public function getStartWeek(): int
    {
        return $this->startWeek;
    }

    /**
     * projectDataNodeArrayのセット
     * 
     * @param array $projectDataNodeArray
     * @return void
     */
    public function setProjectDataNodeArray(array $projectDataNodeArray)
    {
        $this->projectDataNodeArray = $projectDataNodeArray;
    }

    /**
     * projectDataNodeArrayの取得
     * 
     * @return array
     */
    public function getProjectDataNodeArray(): array
    {
        return $this->projectDataNodeArray;
    }

    /**
     * finishDayのセット
     * 
     * @param int $finishDay
     * @return void
     */
    public function setFinishDay(int $finishDay)
    {
        $this->finishDay = $finishDay;
    }

    /**
     * finishDayの取得
     * 
     * @return int
     */
    public function getFinishDay(): int
    {
        return $this->finishDay;
    }

    /**
     * monthのセット
     * 
     * @param int $month
     * @return void
     */
    public function setMonth(int $month)
    {
        $this->month = $month;
    }

    /**
     * monthの取得
     * 
     * @return int
     */
    public function getMonth(): int
    {
        return $this->month;
    }

    /**
     * yearのセット
     * 
     * @param int $year
     * @return void
     */
    public function setYear(int $year)
    {
        $this->year = $year;
    }

    /**
     * yearの取得
     * 
     * @return int
     */
    public function getYear(): int
    {
        return $this->year;
    }
}
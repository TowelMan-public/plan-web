<?php

/**
 * 日付に関するフォーマットクラス
 */
class DateUtility 
{

    /**
     * コンストラクタ シングルトン設計のためプライベート
     */
    private function __construct(){}
    
    /**
     * 設定されている日付フォーマット、タイムゾーンを使って文字列から日付に変換する
     *
     * @param string $dateSring
     * @return DateTime
     * @throws DateException $dateSringが不正だと投げられる
     */
    static function stringToDate(string $dateSring): DateTime
    {
        $timeZoon = new DateTimeZone(Config::TIME_ZONE);
        $dateOrBool = DateTime::createFromFormat(Config::DATE_FORMAT, $dateSring, $timeZoon);

        if($dateOrBool === false)
            throw new DateException("\$dateString is Illegal. \$dateString is not Date.");
        else
            return $dateOrBool;
    }

    /**
     * 年、月、日、時、分により日付を作成する
     *
     * @param integer $year
     * @param integer $month
     * @param integer $day
     * @param integer $hour
     * @param integer $minute
     * @return DateTime
     * @throws DateException 日付の作成に失敗すると投げられる
     */
    static public function createDate(int $year, int $month, int $day, int $hour, int $minute): DateTime
    {
        $dateString = "$year-$month-$day $hour:$minute";
        return self::stringToDate($dateString);
    }

    /**
     * 年、月、日、時、分により日付の文字列を作成する
     *
     * @param integer $year
     * @param integer $month
     * @param integer $day
     * @param integer $hour
     * @param integer $minute
     * @return string
     */
    static public function createDateString(int $year, int $month, int $day, int $hour, int $minute): string
    {
        return "$year-$month-$day $hour:$minute";
    }

    /**
     * 日付を文字列に変換する
     *
     * @param DateTime $date
     * @return string
     */
    static public function dateToString(DateTime $date): string
    {
        return $date->format(Config::DATE_FORMAT);
    }
}
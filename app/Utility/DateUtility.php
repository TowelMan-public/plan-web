<?php

namespace App\Utility;

use App\Config\Config;
use App\Exception\DateException;
use DateTime;
use DateTimeZone;

/**
 * 日付に関するクラス
 */
class DateUtility 
{
    /**
     * このクラスの関数で日付に関する連想配列を扱うやつについて、
     * その返されたint連想配列の、「年」のデータが入っているキー
     */
    const YEAR = 'year';

    /**
     * このクラスの関数で日付に関する連想配列を扱うやつについて、
     * その返されたint連想配列の、「月」のデータが入っているキー
     */
    const MONTH = 'month';

    /**
     * このクラスの関数で日付に関する連想配列を扱うやつについて、
     * その返されたint連想配列の、「日」のデータが入っているキー
     */
    const DAY = 'day';

    /**
     * このクラスの関数で日付に関する連想配列を扱うやつについて、
     * その返されたint連想配列の、「時」のデータが入っているキー
     */
    const HOUR = 'hour';

    /**
     * このクラスの関数で日付に関する連想配列を扱うやつについて、
     * その返されたint連想配列の、「分」のデータが入っているキー
     */
    const MINUTE = 'minute';

    /**
     * self::timeZoon()以外で使わない
     *
     * @var DateTimeZone
     * @see self::timeZoon()
     */
    static private DateTimeZone $_timeZoon;

    /**
     * コンストラクタ staticオンリーのためプライベート
     */
    private function __construct(){}
    
    /**
     * デフォルトのタームゾーンを取得する
     *
     * @return DateTimeZone
     */
    static private function timeZoon(): DateTimeZone
    {
        self::$_timeZoon ??= new DateTimeZone(Config::TIME_ZONE);
        return self::$_timeZoon;
    }

    /**
     * デフォルトのタイムゾーンでDateTimeを取得する
     *
     * @param DateTime $date
     * @return DateTime
     */
    static private function getDateTimeInDefaultTimeZone(DateTime $date): DateTime
    {
        $newDate = clone $date;
        $newDate->setTimezone(self::timeZoon());
        return $newDate;
    }

    /**
     * intを符号付文字列に変換する
     *
     * @param integer $val
     * @return string
     */
    static private function intToSignedString(int $val): string
    {
        if($val > 0)
            return '+'.(string)$val;
        else
            return (string)$val;
    }

    /**
     * 設定されている日付フォーマット、タイムゾーンを使って文字列から日付に変換する
     *
     * @param string $dateString
     * @return DateTime
     * @throws DateException $dateSringが不正だと投げられる
     */
    static function stringToDate(string $dateString): DateTime
    {
        $newDateString = $dateString;
        if (!ctype_digit(substr($newDateString, 0, 1))){
            $newDateString = substr($newDateString, 1);
        }
        if (!ctype_digit(substr($newDateString, strlen($newDateString) - 1, 1))){
            $newDateString = substr($newDateString, 0, strlen($newDateString) - 1);
        }
        if(substr($newDateString, 6, 1) === "-"){
            $newDateString = substr($newDateString, 0, 5)."0".substr($newDateString, 5);
        }
        if(substr($newDateString, 9, 1) === " "){
            $newDateString = substr($newDateString, 0, 8)."0".substr($newDateString, 8);
        }
        if(substr($newDateString, 12, 1) === ":"){
            $newDateString = substr($newDateString, 0, 11)."0".substr($newDateString, 11);
        }
        if(strlen(substr($newDateString, 14)) === 1){
            $newDateString = substr($newDateString, 0, 14)."0".substr($newDateString, 14);
        }

        $dateOrBool = DateTime::createFromFormat(Config::DATE_FORMAT, $newDateString, self::timeZoon());
        if($dateOrBool === false){
            throw new DateException("$dateString is Illegal. \$dateString is not Date.");
        }
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
     * 日付を作成する
     * $dateに指定された日付に、$dateArray（本クラスで使用する日付に関する連想配列。）に指定された通りにDateTimeを作成する。
     * 尚、指定されていない項目があると例外がが投げられ、処理が止まってしまう恐れがあるため注意すること。
     *
     * @param array $dateArray intの日付情報が入った連想配列
     * @return DateTime
     * @throws DateException 日付の作成に失敗すると投げられる
     */
    static public function createDateByDateAssociativeArray(array $dateArray): DateTime
    {
        return self::createDate($dateArray[self::YEAR], $dateArray[self::MONTH], $dateArray[self::DAY],
            $dateArray[self::HOUR], $dateArray[self::MINUTE]);
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
        return self::getDateTimeInDefaultTimeZone($date)->format(Config::DATE_FORMAT);
    }

    /**
     * intの日付情報が入った連想配列を取得する。
     * この連想配列は、本クラスの定数をキーとして使うと使える。
     *
     * @param DateTime $date
     * @return array intの日付情報が入った連想配列
     */
    static function getDateAssociativeArrayByDateTime(DateTime $date): array
    {
        $newDate = self::getDateTimeInDefaultTimeZone($date);
        return [
            self::YEAR => intval($newDate->format('Y')),
            self::MONTH => intval($newDate->format('m')),
            self::DAY => intval($newDate->format('d')),
            self::HOUR => intval($newDate->format('H')),
            self::MINUTE => intval($newDate->format('i')),
        ];
    }

    /**
     * intの日付情報が入った連想配列を取得する。
     * この連想配列は、本クラスの定数をキーとして使うと使える。
     *
     * @param string $dateString
     * @return array intの日付情報が入った連想配列
     * @throws DateException $dateSringが不正だと投げられる
     */
    static function getDateAssociativeArrayByString(string $dateString): array
    {
        return self::getDateAssociativeArrayByDateTime( self::stringToDate($dateString) );
    }

    /**
     * $dateに指定された日付に、$dateArray（本クラスで使用する日付に関する連想配列。）に指定されただけの時間を
     * 足す。尚、指定されていない項目についてはスルーする。
     *
     * @param DateTime $date
     * @param array $dateArray intの日付情報が入った連想配列
     * @return DateTime
     */
    static function addDate(DateTime $date, array $dateArray): DateTime
    {
        $newDate = new DateTime('now', self::timeZoon());
        $newDate->setTimestamp(self::getDateTimeInDefaultTimeZone($date)->getTimestamp());

        if(array_key_exists(self::YEAR, $dateArray))
            $newDate->modify(self::intToSignedString($dateArray[self::YEAR]).' years');

        if(array_key_exists(self::MONTH, $dateArray))
            $newDate->modify(self::intToSignedString($dateArray[self::MONTH]).' months');

        if(array_key_exists(self::DAY, $dateArray))
            $newDate->modify(self::intToSignedString($dateArray[self::DAY]).' day');

        if(array_key_exists(self::HOUR, $dateArray))
            $newDate->modify(self::intToSignedString($dateArray[self::HOUR]).' hour');

        if(array_key_exists(self::MINUTE, $dateArray))
            $newDate->modify(self::intToSignedString($dateArray[self::MINUTE]).' second');

        return $newDate;
    }

    /**
     * 指定されたDateTimeの次の日の0時間0分の時間を返す。
     *
     * @param DateTime $dateTime
     * @return DateTime
     */
    static public function getNextDaysTopDateTime(DateTime $dateTime): DateTime
    {
        $dateAssociativeArray = self::getDateAssociativeArrayByDateTime(
            self::addDate(self::getDateTimeInDefaultTimeZone($dateTime), [self::DAY => 1])
        );
        $dateAssociativeArray[self::HOUR] = 0;
        $dateAssociativeArray[self::MINUTE] = 0;

        return self::createDateByDateAssociativeArray($dateAssociativeArray);
    }
}
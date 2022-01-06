<?php

namespace App\Logic;

use App\Client\Response\UserConfigResponse;
use App\Client\Response\UserResponse;
use App\Http\Data\UserConfigData;
use App\Http\Data\UserData;

class UserLogic{
    /**
    * コンストラクタ
    */
    private function __construct(){}

    private const DAY_IN_SECONDS = 86400;
    private const HOUR_IN_SECONDS = 3600;
    private const MINUTE_IN_SECONDS = 60;

    static public function createUserData(UserResponse $response): UserData
    {
        $data = new UserData();
        $data->setUserName($response->getUserName());
        $data->setUserNickName($response->getUserNickName());

        return $data;
    }

    static public function createUserConfigData(UserConfigResponse $response): UserConfigData
    {
        $data = new UserConfigData();
        $data->setIsPushInsertedTodoNotice($response->getIsPushInsertedTodoNotice());
        $data->setIsPushStartedTodoNotice($response->getIsPushInsertedStartedTodoNotice());

        $tempTimestamp = $response->getBeforeDeadlineForProjectNotice();
        $data->setBeforeDeadlineForProjectNoticeDay($tempTimestamp / self::DAY_IN_SECONDS);
        $tempTimestamp %= self::DAY_IN_SECONDS;
        $data->setBeforeDeadlineForProjectNoticeHour($tempTimestamp / self::HOUR_IN_SECONDS);
        $tempTimestamp %= self::HOUR_IN_SECONDS;
        $data->setBeforeDeadlineForProjectNoticeMinute($tempTimestamp / self::MINUTE_IN_SECONDS);

        $tempTimestamp = $response->getBeforeDeadlineForTodoNotice();
        $data->setBeforeDeadlineForTodoNoticeDay($tempTimestamp / self::DAY_IN_SECONDS);
        $tempTimestamp %= self::DAY_IN_SECONDS;
        $data->setBeforeDeadlineForTodoNoticeHour($tempTimestamp / self::HOUR_IN_SECONDS);
        $tempTimestamp %= self::HOUR_IN_SECONDS;
        $data->setBeforeDeadlineForTodoNoticeMinute($tempTimestamp / self::MINUTE_IN_SECONDS);

        return $data;
    }
}
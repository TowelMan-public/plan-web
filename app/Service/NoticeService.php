<?php

namespace App\Service;

use App\Client\Api\Api;
use App\Logic\NoticeLogic;

class NoticeService
{
    private static NoticeService $instance; 

    /**
     * コンストラクタ シングルトン設計のためプライベート
     */
    private function __construct()
    {
    }

    /**
     * インスタンスを取得する
     *
     * @return NoticeService
     */
    public static function getInstance(): NoticeService
    {
        self::$instance ??= new NoticeService();
        return self::$instance;
    }

    public function getNoticeDataArray(string $oauthToken): array
    {
        $responceArray = Api::last()->notice()->getList($oauthToken);
        $dateArray = [];

        foreach ($responceArray as $responce)
            $dateArray[] = NoticeLogic::createNoticeData($responce);

        return $dateArray;
    }
}

<?php

namespace App\Config;

/**
 * 本アプリの全体的な設定
 */
class Config
{
    /**
     * コンストラクタ
     */
    private function __construct() {}

    public const API_ROOT_URL_V1 = "https://plan.towelman.server-on.net:8080/api/V1/";
    public const DATE_FORMAT = "Y-m-d H:i";
    public const TIME_ZONE = "Asia/Tokyo";
    public const NAME_MAX_SIZE = 100;
    public const CONTENT_TEXT_MAX_SIZE = 100;
    public const MIN_BEFORE_DEADLINE = 86400;
}

<?php

namespace App\Client\Api\V1;

/**
 * V1系のAPI
 */
class V1 
{
    private static V1 $instance;

    /**
     * コンストラクタ シングルトン設計のためプライベート
     */
    private function __construct() {}

    /**
     * インスタンスを取得する
     *
     * @return V1のインスタンス
     */
    public static function getInstance(): V1
    {
        self::$instance ??= new V1();
        return self::$instance;
    }
    
    public function user() :UserApi
    {
        return UserApi::getInstance();
    }

    public function userConfig() :UserConfigApi
    {
        return UserConfigApi::getInstance();
    }

    public function terminal() :TerminalApi
    {
        return TerminalApi::getInstance();
    }

    public function notice() :NoticeApi
    {
        return NoticeApi::getInstance();
    }

    public function privateProject() :PrivateProjectApi
    {
        return PrivateProjectApi::getInstance();
    }

    public function publicProject() :PublicProjectApi
    {
        return PublicProjectApi::getInstance();
    }

    public function subscriber() :SubscriberApi
    {
        return SubscriberApi::getInstance();
    }

    public function todo() :TodoApi
    {
        return TodoApi::getInstance();
    }

    public function todoOnResoinsible() :TodoOnResponsibleApi
    {
        return TodoOnResponsibleApi::getInstance();
    }

    public function content() :ContentApi
    {
        return ContentApi::getInstance();
    }
}
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
    
    public function user() :UserAPI
    {
        return UserAPI::getInstance();
    }

    public function userConfig() :UserConfigAPI
    {
        return UserConfigAPI::getInstance();
    }

    public function terminal() :TerminalAPI
    {
        return TerminalAPI::getInstance();
    }

    public function notice() :NoticeAPI
    {
        return NoticeAPI::getInstance();
    }

    public function privateProject() :PrivateProjectAPI
    {
        return PrivateProjectAPI::getInstance();
    }

    public function publicProject() :PublicprojectAPI
    {
        return PublicprojectAPI::getInstance();
    }

    public function subscriber() :SubscriberAPI
    {
        return SubscriberAPI::getInstance();
    }

    public function todo() :TodoAPI
    {
        return TodoAPI::getInstance();
    }

    public function todoOnResoinsible() :TodoOnResponsibleAPI
    {
        return TodoOnResponsibleAPI::getInstance();
    }

    public function content() :ContentAPI
    {
        return ContentAPI::getInstance();
    }
}
<?php

namespace App\Client\Api\V1;

use App\Client\Dto\DtoParamaters;
use App\Client\Header\OauthHeader;
use App\Client\Response\NoticeResponse;
use App\Client\Rest\RestTemplate;
use App\Config\Config;

/**
* 通知に関するAPI
*/
class NoticeApi
{
    private const ROOT_URL = Config::API_ROOT_URL_V1 . "notice";
    private static NoticeApi $instance;
    private RestTemplate $restTemplate;

    /**
     * コンストラクタ シングルトン設計のためプライベート
     */
    private function __construct()
    {
        $this->restTemplate = RestTemplate::getInstance();
    }

    /**
     * インスタンスを取得する
     *
     * @return NoticeApi NoticeApiのインスタンス
     */
    public static function getInstance(): NoticeApi{
        self::$instance ??= new NoticeApi();
        return self::$instance;
    }
    
    /**
     * 通知リストを取得する
     *
     * @param string $token
     * @return array NoticeResponseの配列
     */
    public function getList(string $token) :array
    {
        $url = self::ROOT_URL;
        
        //リクエストパラメタ
        $dto = new DtoParamaters();

        //ヘッダー
        $header = new OauthHeader($token);
        
        $responseArray = $this->restTemplate->get($url, $dto, $header);
        return NoticeResponse::parseNoticeResponseArray($responseArray);
    }
}
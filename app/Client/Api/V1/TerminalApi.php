<?php

namespace App\Client\Api\V1;

use App\Client\Dto\DtoParamaters;
use App\Client\Header\OauthHeader;
use App\Client\Response\TerminalResponse;
use App\Client\Rest\RestTemplate;
use App\Config\Config;

/**
* 機種に関するAPI
*/
class TerminalAPI
{
    private const ROOT_URL = Config::API_ROOT_URL_V1 . "user/terminal";
    private static TerminalApi $instance;
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
     * @return TerminalApi TerminalApiのインスタンス
     */
    public static function getInstance(): TerminalApi{
        self::$instance ??= new TerminalApi();
        return self::$instance;
    }
    
    /**
     * 機種の新規登録
     *
     * @param string $token
     * @param string $terminalName
     * @return void
     */
    public function post(string $token, string $terminalName)
    {
        $url = self::ROOT_URL . "url";
        
        //リクエストパラメタ
        $dto = new DtoParamaters();
        $dto->setTerminalName($terminalName);
        
        
        //ヘッダー
        $header = new OauthHeader($token);
        
        $responseArray = $this->restTemplate->post($url, $dto, $header);        
    }
    
    /**
     * 機種リストの取得
     *
     * @param string $token
     * @return array TerminalResponseの配列
     */
    public function getList(string $token) :array
    {
        $url = self::ROOT_URL;
        
        //リクエストパラメタ
        $dto = new DtoParamaters();
        
        //ヘッダー
        $header = new OauthHeader($token);
        
        $responseArray = $this->restTemplate->get($url, $dto, $header);
        return TerminalResponse::parseTerminalResponseArray($responseArray);
    }
    
    /**
     * 機種名の更新
     *
     * @param string $token
     * @param string $oldTerminalname
     * @param string $newTerminalName
     * @return void
     */
    public function put(string $token, string $oldTerminalname, string $newTerminalName)
    {
        $url = self::ROOT_URL;
        
        //リクエストパラメタ
        $dto = new DtoParamaters();
        $dto->setOldTerminalName($oldTerminalname);
        $dto->setNewTerminalName($newTerminalName);
        
        //ヘッダー
        $header = new OauthHeader($token);
        
        $responseArray = $this->restTemplate->put($url, $dto, $header);        
    }
    
    /**
     * 機種の削除
     *
     * @param string $token
     * @param string $terminalName
     * @return void
     */
    public function delete(string $token, string $terminalName)
    {
        $url = self::ROOT_URL;
        
        //リクエストパラメタ
        $dto = new DtoParamaters();
        $dto->setTerminalName($terminalName);
        
        //ヘッダー
        $header = new OauthHeader($token);
        
        $this->restTemplate->delete($url, $dto, $header);
    }
}
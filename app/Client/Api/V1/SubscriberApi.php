<?php

namespace App\Client\Api\V1;

use App\Client\Dto\DtoParamaters;
use App\Client\Header\OauthHeader;
use App\Client\Response\SubscriberInPublicProjectResponse;
use App\Client\Rest\RestTemplate;
use App\Config\Config;

/**
* パブリックプロジェクトの参画者に関するAPI
*/
class SubscriberAPI
{
    private const ROOT_URL = Config::API_ROOT_URL_V1 . "project";
    private static SubscriberApi $instance;
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
     * @return SubscriberAPI SubscriberApiのインスタンス
     */
    public static function getInstance(): SubscriberApi{
        self::$instance ??= new SubscriberApi();
        return self::$instance;
    }
    
    /**
     * 参画者の登録
     *
     * @param string $token
     * @param integer $publicProjectId
     * @param string $userName
     * @return void
     */
    public function post(string $token, int $publicProjectId, string $userName)
    {
        $url = self::ROOT_URL . "/$publicProjectId/subscriber";
        
        //リクエストパラメタ
        $dto = new DtoParamaters();
        $dto->setUserName($userName);
        
        //ヘッダー
        $header = new OauthHeader($token);
        
        $this->restTemplate->post($url, $dto, $header);
    }
    
    /**
     * 参画者リストの取得
     *
     * @param string $token
     * @param integer $publicProjectId
     * @return array SubscriberInPublicProjectResponse
     */
    public function getList(string $token, int $publicProjectId) :array
    {
        $url = self::ROOT_URL . "/$publicProjectId/subscriber";
        
        //リクエストパラメタ
        $dto = new DtoParamaters();        
        
        //ヘッダー
        $header = new OauthHeader($token);
        
        $responseArrayOrContents = $this->restTemplate->get($url, $dto, $header);
        return SubscriberInPublicProjectResponse::parseSubscriberInPublicProjectResponseArray($responseArrayOrContents);
    }
    
    /**
     * 参画者の権限を変更する
     *
     * @param string $token
     * @param integer $publicProjectId
     * @param string $userName
     * @param integer $authorityId
     * @return void
     */
    public function put(string $token, int $publicProjectId, string $userName, int $authorityId)
    {
        $url = self::ROOT_URL . "/$publicProjectId/subscriber";
        
        //リクエストパラメタ
        $dto = new DtoParamaters();
        $dto->setUserName($userName);
        $dto->setAuthorityId($authorityId);
        
        //ヘッダー
        $header = new OauthHeader($token);
        
        $this->restTemplate->put($url, $dto, $header);
    }
    
    /**
     * 参画者を除外する
     *
     * @param string $token
     * @param integer $publicProjectId
     * @param string $userName
     * @return void
     */
    public function delete(string $token, int $publicProjectId, string $userName)
    {
        $url = self::ROOT_URL . "/$publicProjectId/subscriber";
        
        //リクエストパラメタ
        $dto = new DtoParamaters();
        $dto->setUserName($userName);
        
        //ヘッダー
        $header = new OauthHeader($token);
        
        $this->restTemplate->delete($url, $dto, $header);
    }
    
    /**
     * プロジェクトの勧誘を受け入れる
     *
     * @param string $token
     * @param integer $publicProjectId
     * @return void
     */
    public function postAccept(string $token, int $publicProjectId)
    {
        $url = self::ROOT_URL . "/$publicProjectId/subscriber/accept";
        
        //リクエストパラメタ
        $dto = new DtoParamaters();
                
        //ヘッダー
        $header = new OauthHeader($token);
        
        $this->restTemplate->post($url, $dto, $header);
    }
    
    /**
     * プロジェクトの勧誘を断る
     *
     * @param string $token
     * @param integer $publicProjectId
     * @return void
     */
    public function postBlock(string $token, int $publicProjectId)
    {
        $url = self::ROOT_URL . "/$publicProjectId/subscriber/block";
        
        //リクエストパラメタ
        $dto = new DtoParamaters();
                
        //ヘッダー
        $header = new OauthHeader($token);
        
        $this->restTemplate->post($url, $dto, $header);
    }
    
    /**
     * プロジェクトから脱退する
     *
     * @param string $token
     * @param integer $publicProjectId
     * @return void
     */
    public function postExit(string $token, int $publicProjectId)
    {
        $url = self::ROOT_URL . "/$publicProjectId/subscriber/exit";
        
        //リクエストパラメタ
        $dto = new DtoParamaters();
        
        //ヘッダー
        $header = new OauthHeader($token);
        
        $this->restTemplate->post($url, $dto, $header);
    }
}
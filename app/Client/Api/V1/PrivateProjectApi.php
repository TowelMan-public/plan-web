<?php

namespace App\Client\Api\V1;

use App\Client\Dto\DtoParamaters;
use App\Client\Header\OauthHeader;
use App\Client\Response\PrivateProjectResponse;
use App\Client\Rest\RestTemplate;
use App\Config\Config;

/**
* プライベートプロジェクトに関するAPI
*/
class PrivateProjectAPI
{
    private const ROOT_URL = Config::API_ROOT_URL_V1 . "project/private";
    private static PrivateProjectApi $instance;
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
     * @return PrivateProjectApi PrivateProjectApiのインスタンス
     */
    public static function getInstance(): PrivateProjectApi{
        self::$instance ??= new PrivateProjectApi();
        return self::$instance;
    }
    
    /**
     * プライベートプロジェクトの新規作成
     *
     * @param string $token
     * @param string $projectName
     * @return integer 新しいプライベートプロジェクトID
     */
    public function post(string $token, string $projectName) :int
    {
        $url = self::ROOT_URL;
        
        //リクエストパラメタ
        $dto = new DtoParamaters();
        $dto->setProjectName($projectName);
        
        //ヘッダー
        $header = new OauthHeader($token);
        
        $responseArrayOrContents = $this->restTemplate->post($url, $dto, $header, false);
        return (int)$responseArrayOrContents[0];
    }
    
    /**
     * 自分が持っているプライベートプロジェクトリストを取得する
     *
     * @param string $token
     * @return array PrivateProjectResponse
     */
    public function getList(string $token) :array
    {
        $url = self::ROOT_URL;
        
        //リクエストパラメタ
        $dto = new DtoParamaters();        
        
        //ヘッダー
        $header = new OauthHeader($token);
        
        $responseArrayOrContents = $this->restTemplate->get($url, $dto, $header);
        return PrivateProjectResponse::parsePrivateProjectResponseArray($responseArrayOrContents);
    }
    
    /**
     * プライベートプロジェクトを取得する
     *
     * @param string $token
     * @param integer $privateProjectId
     * @return PrivateProjectResponse
     */
    public function get(string $token, int $privateProjectId) :PrivateProjectResponse
    {
        $url = self::ROOT_URL . "/$privateProjectId";
        
        //リクエストパラメタ
        $dto = new DtoParamaters();
        
        //ヘッダー
        $header = new OauthHeader($token);
        
        $responseArrayOrContents = $this->restTemplate->get($url, $dto, $header);
        return PrivateProjectResponse::parsePrivateProjectResponse($responseArrayOrContents);
    }
    
    /**
     * プライベートプロジェクト名を変更する
     *
     * @param string $token
     * @param integer $privateProjectId
     * @param string $projectName
     * @return void
     */
    public function put(string $token, int $privateProjectId, string $projectName)
    {
        $url = self::ROOT_URL . "/$privateProjectId";
        
        //リクエストパラメタ
        $dto = new DtoParamaters();
        $dto->setProjectName($projectName);
        
        //ヘッダー
        $header = new OauthHeader($token);
        
        $this->restTemplate->put($url, $dto, $header);
    }
    
    /**
     * プライベートプロジェクトを削除する
     *
     * @param string $token
     * @param integer $privateProjectId
     * @return void
     */
    public function delete(string $token, int $privateProjectId)
    {
        $url = self::ROOT_URL . "/$privateProjectId";
        
        //リクエストパラメタ
        $dto = new DtoParamaters();
                
        //ヘッダー
        $header = new OauthHeader($token);
        
        $this->restTemplate->delete($url, $dto, $header);
    }

   public function getIsPrivate(string $token, int $privateProjectId) :bool
   {
        $url = self::ROOT_URL . "/$privateProjectId/isPrivate";
        
        //リクエストパラメタ
        $dto = new DtoParamaters();
        
        
        //ヘッダー
        $header = new OauthHeader($token);
        
        $responseArrayOrContents = $this->restTemplate->get($url, $dto, $header, false);
        return ((string)$responseArrayOrContents[0] === 'true');
   }
}
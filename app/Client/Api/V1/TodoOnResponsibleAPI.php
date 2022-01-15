<?php

namespace App\Client\Api\V1;

use App\Client\Dto\DtoParamaters;
use App\Client\Header\OauthHeader;
use App\Client\Response\TodoOnResponsibleResponse;
use App\Client\Response\UserInTodoOnResponsibleResponse;
use App\Client\Rest\RestTemplate;
use App\Config\Config;
use DateTime;

/**
* 担当者向け「やること」に関するAPI
*/
class TodoOnResponsibleAPI
{
    private const ROOT_URL = Config::API_ROOT_URL_V1 . "todo";
    private static TodoOnResponsibleApi $instance;
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
     * @return TodoOnResponsibleApi TodoOnResponsibleApiのインスタンス
     */
    public static function getInstance(): TodoOnResponsibleApi{
        self::$instance ??= new TodoOnResponsibleApi();
        return self::$instance;
    }
    
    /**
     * 「やること」の担当者を追加する
     *
     * @param string $token
     * @param integer $todoOnProjectId
     * @param string $userName
     * @return void
     */
    public function post(string $token, int $todoOnProjectId, string $userName)
    {
        $url = self::ROOT_URL . "/$todoOnProjectId/responsible/$userName";
        
        //リクエストパラメタ
        $dto = new DtoParamaters();
                
        //ヘッダー
        $header = new OauthHeader($token);
        
        $this->restTemplate->post($url, $dto, $header);
    }
    
    /**
     * 「やること」の担当者一覧を取得する
     *
     * @param string $token
     * @param integer $todoOnProjectId
     * @return array UserInTodoOnResponsibleResponse
     */
    public function getListInTodo(string $token, int $todoOnProjectId) :array
    {
        $url = self::ROOT_URL . "/$todoOnProjectId/responsible";
        
        //リクエストパラメタ
        $dto = new DtoParamaters();        
        
        //ヘッダー
        $header = new OauthHeader($token);
        
        $responseArrayOrContents = $this->restTemplate->get($url, $dto, $header);
        return UserInTodoOnResponsibleResponse::parseUserInTodoOnResponsibleResponseArray($responseArrayOrContents);
    }
    
    /**
     * 「やること」の担当者を外す
     *
     * @param string $token
     * @param integer $todoOnProjectId
     * @param string $userName
     * @return void
     */
    public function delete(string $token, int $todoOnProjectId, string $userName)
    {
        $url = self::ROOT_URL . "/$todoOnProjectId/responsible/$userName";
        
        //リクエストパラメタ
        $dto = new DtoParamaters();
        
        //ヘッダー
        $header = new OauthHeader($token);
        
        $this->restTemplate->delete($url, $dto, $header);
    }
    
    /**
     * 「やること」の担当者から辞退する
     *
     * @param string $token
     * @param integer $todoOnProjectId
     * @return void
     */
    public function postExit(string $token, int $todoOnProjectId)
    {
        $url = self::ROOT_URL . "/$todoOnProjectId/responsible";
        
        //リクエストパラメタ
        $dto = new DtoParamaters();
        
        //ヘッダー
        $header = new OauthHeader($token);
        
        $this->restTemplate->post($url, $dto, $header);
    }
    
    /**
     * 検索条件から自分が担当者になっている「やること」を担当者向けで複数取得する
     *
     * @param string $token
     * @param integer|null $publicProjectId
     * @param DateTime|null $startDate
     * @param DateTime|null $finishDate
     * @param boolean|null $isIncludeCompleted
     * @return array TodoOnResponsibleResponse
     */
    public function getListByExample(string $token, int $publicProjectId = null,
         DateTime $startDate = null, DateTime $finishDate = null, bool $isIncludeCompleted = null) :array
    {
        $url = self::ROOT_URL . "/responsible_todo";
        
        //リクエストパラメタ
        $dto = new DtoParamaters();
        $dto->setPublicProjectId($publicProjectId);
        $dto->setStartDate($startDate);
        $dto->setFinishDate($finishDate);
        $dto->setIsInclideCompletedTodo($isIncludeCompleted);
        
        //ヘッダー
        $header = new OauthHeader($token);
        
        $responseArrayOrContents = $this->restTemplate->get($url, $dto, $header);
        return TodoOnResponsibleResponse::parseTodoOnResponsibleResponseArray($responseArrayOrContents);
    }
    
    /**
     * 担当者向け「やること」を取得する
     *
     * @param string $token
     * @param integer $todoOnProjectId
     * @return TodoOnResponsibleResponse
     */
    public function get(string $token, int $todoOnProjectId) :TodoOnResponsibleResponse
    {
        $url = self::ROOT_URL . "/$todoOnProjectId/responsible";
        
        //リクエストパラメタ
        $dto = new DtoParamaters();
        
        //ヘッダー
        $header = new OauthHeader($token);
        
        $responseArrayOrContents = $this->restTemplate->get($url, $dto, $header);
        return TodoOnResponsibleResponse::parseTodoOnResponsibleResponse($responseArrayOrContents);
    }
    
    /**
     * 担当者向け「やること」に完了状況をセットする。$userNameを指定しなかった場合、「やること」の担当者全てにその完了状況がセットされる
     *
     * @param string $token
     * @param integer $todoOnProjectId
     * @param string|null $userName
     * @return void
     */
    public function putIsCompleted(string $token, int $todoOnProjectId, string $userName = null)
    {
        $url = self::ROOT_URL . "/$todoOnProjectId/responsible/is_completed";
        
        //リクエストパラメタ
        $dto = new DtoParamaters();
        
        //$userNameの指定の有無でAPIが変わる
        if(is_null($userName))
            $url .= "/all";
        else
            $dto->setUserName($userName);
        
        //ヘッダー
        $header = new OauthHeader($token);
        
        $this->restTemplate->put($url, $dto, $header);
    }
}
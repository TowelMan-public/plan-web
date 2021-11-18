<?php

/**
* 内容に関するAPI
*/
class ContentAPI
{
    private const ROOT_URL = Config::API_ROOT_URL_V1 + "content";
    private static ContentApi $instance;
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
     * @return ContentApiのインスタンス
     */
    public static function getInstance(): ContentApi{
        self::$instance ??= new ContentApi();
        return self::$instance;
    }
    
    /**
     * 内容の新規作成
     *
     * @param string $token
     * @param integer $todoId
     * @param string $contentTitle
     * @param string $contentExplanation
     * @return integer ID
     */
    public function post(string $token, int $todoId, string $contentTitle, string $contentExplanation) :int
    {
        $url = self::ROOT_URL;
        
        //リクエストパラメタ
        $dto = new DtoParamaters();
        $dto->setTodoId($todoId);
        $dto->setContentTitle($contentTitle);
        $dto->setContentExplanation($contentExplanation);
        
        //ヘッダー
        $header = new OauthHeader($token);
        
        $responseArrayOrContents = $this->restTemplate->post($url, $dto, $header);
        return $responseArrayOrContents;
    }
    
    /**
     * 内容リストの取得
     *
     * @param string $token
     * @param integer $todoId
     * @return array ContentResponse
     */
    public function getList(string $token, int $todoId) :array
    {
        $url = self::ROOT_URL;
        
        //リクエストパラメタ
        $dto = new DtoParamaters();
        $dto->setTodoId($todoId);
        
        //ヘッダー
        $header = new OauthHeader($token);
        
        $responseArrayOrContents = $this->restTemplate->get($url, $dto, $header);
        return ContentResponse::parseContentResponseArray($responseArrayOrContents);
    }
    
    /**
     * 内容の取得
     *
     * @param string $token
     * @param integer $contentId
     * @return ContentResponse
     */
    public function get(string $token, int $contentId) :ContentResponse
    {
        $url = self::ROOT_URL + "/$contentId";
        
        //リクエストパラメタ
        $dto = new DtoParamaters();        
        
        //ヘッダー
        $header = new OauthHeader($token);
        
        $responseArrayOrContents = $this->restTemplate->get($url, $dto, $header);
        return ContentResponse::parseContentResponse($responseArrayOrContents);
    }
    
    /**
     * 内容に変更を加える
     *
     * @param string $token
     * @param integer $contentId
     * @param string|null $contentTitle
     * @param string|null $contentExplanation
     * @return void
     */
    public function put(string $token, int $contentId, string $contentTitle = null, string $contentExplanation = null)
    {
        $url = self::ROOT_URL + "/$contentId";
        
        //リクエストパラメタ
        $dto = new DtoParamaters();
        $dto->setContentTitle($contentTitle);
        $dto->setContentExplanation($contentExplanation);
        
        
        //ヘッダー
        $header = new OauthHeader($token);
        
        $this->restTemplate->put($url, $dto, $header);        
    }
    
    /**
     * 内容を削除する
     *
     * @param string $token
     * @param integer $contentId
     * @return void
     */
    public function delete(string $token, int $contentId)
    {
        $url = self::ROOT_URL + "/$contentId";
        
        //リクエストパラメタ
        $dto = new DtoParamaters();

        
        //ヘッダー
        $header = new OauthHeader($token);
        
        $this->restTemplate->delete($url, $dto, $header);
    }
    
    /**
     * 内容に完了状況をセットする
     *
     * @param string $token
     * @param integer $contentId
     * @param boolean $isCompleted
     * @return void
     */
    public function putIsCompleted(string $token, int $contentId, bool $isCompleted)
    {
        $url = self::ROOT_URL + "/$contentId/isCompleted";
        
        //リクエストパラメタ
        $dto = new DtoParamaters();
        $dto->setIsCompleted($isCompleted);
        
        //ヘッダー
        $header = new OauthHeader($token);
        
        $this->restTemplate->put($url, $dto, $header);
    }
}
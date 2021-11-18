<?php

/**
* パブリックプロジェクトに関するAPI
*/
class PublicprojectAPI
{
    private const ROOT_URL = Config::API_ROOT_URL_V1 + "project";
    private static PublicprojectApi $instance;
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
     * @return PublicprojectApiのインスタンス
     */
    public static function getInstance(): PublicprojectApi{
        self::$instance ??= new PublicprojectApi();
        return self::$instance;
    }
    
    /**
     * パブリックプロジェクトの新規作成
     *
     * @param string $token
     * @param string $projectName
     * @param DateTime $startDate
     * @param DateTime $finishDate
     * @return integer 新しいID
     */
    public function post(string $token, string $projectName, DateTime $startDate, DateTime $finishDate) :int
    {
        $url = self::ROOT_URL;
        
        //リクエストパラメタ
        $dto = new DtoParamaters();
        $dto->setProjectName($projectName);
        $dto->setStartDate($startDate);
        $dto->setFinishDate($finishDate);
        
        //ヘッダー
        $header = new OauthHeader($token);
        
        $responseArrayOrContents = $this->restTemplate->post($url, $dto, $header);
        return $responseArrayOrContents;
    }

    /**
     * パブリックプロジェクトを取得する
     *
     * @param string $token
     * @param integer $publicProjectId
     * @return PublicProjectResponse
     */
    public function get(string $token, int $publicProjectId) :PublicProjectResponse
    {
        $url = self::ROOT_URL + "/$publicProjectId";
        
        //リクエストパラメタ
        $dto = new DtoParamaters(); 
        
        //ヘッダー
        $header = new OauthHeader($token);
        
        $responseArrayOrContents = $this->restTemplate->get($url, $dto, $header);
        return PublicProjectResponse::parsePublicProjectResponse($responseArrayOrContents);
    }

    /**
     * 自分の持ているパブリックプロジェクトリストを取得する
     *
     * @param string $token
     * @param DateTime|null $startDate
     * @param DateTime $finishDate
     * @return array　PublicProjectResponse
     */
    public function getListByExample(string $token) :array
    {
        $url = self::ROOT_URL;
        
        //リクエストパラメタ
        $dto = new DtoParamaters();
                
        //ヘッダー
        $header = new OauthHeader($token);
        
        $responseArrayOrContents = $this->restTemplate->get($url, $dto, $header);
        return PublicProjectResponse::parsePublicProjectResponseArray($responseArrayOrContents);
    }
    
    /**
     * パブリックプロジェクトに変更を加える
     *
     * @param string $token
     * @param integer $publicProjectId
     * @param string|null $projectName
     * @param DateTime $startDate
     * @param DateTime $finishDate
     * @return void
     */
    public function put(string $token, int $publicProjectId, string $projectName = null, DateTime $startDate, DateTime $finishDate)
    {
        $url = self::ROOT_URL + "/$publicProjectId";
        
        //リクエストパラメタ
        $dto = new DtoParamaters();
        $dto->setProjectName($projectName);
        $dto->setStartDate($startDate);
        $dto->setFinishDate($finishDate);
        
        //ヘッダー
        $header = new OauthHeader($token);
        
        $this->restTemplate->put($url, $dto, $header);
    }
    
    /**
     * パブリックプロジェクトを削除する
     *
     * @param string $token
     * @param integer $publicProjectId
     * @return void
     */
    public function delete(string $token, int $publicProjectId)
    {
        $url = self::ROOT_URL + "/$publicProjectId";
        
        //リクエストパラメタ
        $dto = new DtoParamaters();
                
        //ヘッダー
        $header = new OauthHeader($token);
        
        $this->restTemplate->delete($url, $dto, $header);
    }
    
    /**
     * 勧誘されているパブリックプロジェクトリストを取得する
     *
     * @param string $token
     * @return array PublicProjectResponse
     */
    public function getSolicited(string $token) :array
    {
        $url = self::ROOT_URL + "/solicited";
        
        //リクエストパラメタ
        $dto = new DtoParamaters();        
        
        //ヘッダー
        $header = new OauthHeader($token);
        
        $responseArrayOrContents = $this->restTemplate->get($url, $dto, $header);
        return PublicProjectResponse::parsePublicProjectResponseArray($responseArrayOrContents);
    }
}
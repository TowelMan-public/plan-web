<?php

/**
* ユーザーに関するAPI
*/
class UserAPI
{
    private const ROOT_URL = Config::API_ROOT_URL_V1 + "user";
    private static UserApi $instance;
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
     * @return UserApiのインスタンス
     */
    public static function getInstance(): UserApi
    {
        self::$instance ??= new UserApi();
        return self::$instance;
    }
    
    /**
     * 認証用トークンを生成する（ログイン処理ともいえる）
     *
     * @param string $userName
     * @param string $passwrod
     * @return TokenResponse
     */
    public function postToken(string $userName, string $passwrod): TokenResponse
    {
        $url = self::ROOT_URL + "/token";

        //dto
        $dto = new DtoParamaters();
        $dto->setUserName($userName);
        $dto->setPassword($passwrod);

        //header
        $header = new BaseHeader();

        $responseArray = $this->restTemplate->post($url, $dto, $header);
        return TokenResponse::parseTokenResponse($responseArray);
    }

    /**
     * 認証用トークンを生成する（ログイン処理ともいえる）
     *
     * @param string $refreshToken
     * @return TokenResponse
     */
    public function postNewToken(string $refreshToken): TokenResponse
    {
        $url = self::ROOT_URL + "/token";

        //dto
        $dto = new DtoParamaters();
        $dto->setRefreshJwtToken($refreshToken);

        //header
        $header = new BaseHeader();

        $responseArray = $this->restTemplate->post($url, $dto, $header);
        return TokenResponse::parseTokenResponse($responseArray);
    }

    /**
     * ユーザーの新規登録
     *
     * @param string $userName
     * @param string $userNickName
     * @param string $password
     * @return void
     */
    public function post(string $userName, string $userNickName, string $password)
    {
        $url = self::ROOT_URL;
        
        //リクエストパラメタ
        $dto = new DtoParamaters();
        $dto->setUserName($userName);
        $dto->setUserNickName($userNickName);
        $dto->setPassword($password);
        
        //ヘッダー
        $header = new BaseHeader();
        
        $this->restTemplate->post($url, $dto, $header);
    }
    
    /**
     * ユーザーに関する更新をする
     *
     * @param string $token
     * @param string|null $userName
     * @param string|null $userNickName
     * @param string|null $password
     * @return void
     */
    public function put(string $token, string $userName = null, string $userNickName = null, string $password = null)
    {
        $url = self::ROOT_URL;
        
        //リクエストパラメタ
        $dto = new DtoParamaters();
        $dto->setUserName($userName);
        $dto->setUserNickName($userNickName);
        $dto->setPassword($password);
        
        //ヘッダー
        $header = new OauthHeader($token);
        
        $this->restTemplate->put($url, $dto, $header);
    }
    
    /**
     * ユーザーを取得する
     *
     * @param string $token
     * @param string|null $userName　指定しなかった場合は自分自身を取得することになる
     * @return UserResponse
     */
    public function get(string $token, string $userName = null) :UserResponse
    {
        $url = self::ROOT_URL;
        
        //リクエストパラメタ
        $dto = new DtoParamaters();
        $dto->setUserName($userName);
        
        //ヘッダー
        $header = new OauthHeader($token);
        
        $responseArray = $this->restTemplate->get($url, $dto, $header);
        return UserResponse::parseUserResponse($responseArray);
    }
    
    /**
     * ユーザーを削除する
     *
     * @param string $token
     * @return void
     */
    public function delete(string $token)
    {
        $url = self::ROOT_URL;
        
        //リクエストパラメタ
        $dto = new DtoParamaters();        
        
        //ヘッダー
        $header = new OauthHeader($token);
        
        $this->restTemplate->delete($url, $dto, $header);
    }
}

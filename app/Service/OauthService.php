<?php

namespace App\Service;

use App\Client\Api\Api;
use App\Client\Response\TokenResponse;

/**
 * 認証回りのビジネスロジック
 */
class OauthService 
{
    private static OauthService $instance; 

    /**
     * コンストラクタ シングルトン設計のためプライベート
     */
    private function __construct(){}

    /**
     * インスタンスを取得する
     *
     * @return OauthServiceのインスタンス
     */
    public static function getInstance(): OauthService
    {
        self::$instance ??= new OauthService();
        return self::$instance;
    }
    
    /**
     * ログインのビジネスロジック。
     *
     * @param string $userName
     * @param string $password
     * @return TokenResponse
     * @throws InvalidLoginException ログインに失敗。
     */
    public function login(string $userName, string $password): TokenResponse
    {
        return Api::last()->user()->postToken($userName, $password);
    }

    /**
     * トークンの更新
     *
     * @param string $refreshToken
     * @return TokenResponse
     * @throws InvalidLoginException トークンの更新に失敗。
     */
    public function updateToken(string $refreshToken): TokenResponse
    {
        return Api::last()->user()->postNewToken($refreshToken);
    }
}
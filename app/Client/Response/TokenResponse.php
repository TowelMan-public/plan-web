<?php

namespace App\Client\Response;

class TokenResponse
{

    private string $refreshToken;
    private string $authenticationToken;

    /**
     * TokenResponse単体を生成する
     * 
     * @param array $arrayData UserResponseの連想配列の配列もしくは連想配列
     * @return TokenResponse
     */
    public static function parseTokenResponse(array $arrayData): TokenResponse
    {
        $singleArrayDate = $arrayData;

        $entity = new TokenResponse();
        $entity->setRefreshToken($singleArrayDate['refreshToken']);
        $entity->setAuthenticationToken($singleArrayDate['authenticationToken']);

        return $entity;
    }

    /**
     * TokenResponseの配列を生成する
     * 
     * @param array $arrayData UserResponseの連想配列の配列
     * @return array ${1:ClassName}の配列
     */
    public static function parseTokenResponseArray(array $arrayData): array
    {
        $entityArray = array();
        foreach ($arrayData as $valueArray)
            $entityArray[] = self::parseTokenResponse($valueArray);

        return $entityArray;
    }

    /**
     * authenticationTokenのセット
     *
     * @param string $authenticationToken
     * @return void
     */
    public function setAuthenticationToken(string $authenticationToken)
    {
        $this->authenticationToken = $authenticationToken;
    }

    /**
     * authenticationTokenの取得
     *
     * @return string
     */
    public function getAuthenticationToken(): string
    {
        return $this->authenticationToken;
    }

    /**
     * refreshTokenのセット
     *
     * @param string $refreshToken
     * @return void
     */
    public function setRefreshToken(string $refreshToken)
    {
        $this->refreshToken = $refreshToken;
    }

    /**
     * refreshTokenの取得
     *
     * @return string
     */
    public function getRefreshToken(): string
    {
        return $this->refreshToken;
    }
}

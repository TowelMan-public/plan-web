<?php

class TokenResponse
{

    private string $refreshToken;
    private string $autenticationToken;

    /**
     * TokenResponse単体を生成する
     * 
     * @param array $arrayData UserResponseの連想配列の配列もしくは連想配列
     * @param boolean $isSingle $arrayDataが連想配列であればtrue、そうでなければfalse。通常はtrue。
     * @return TokenResponse
     */
    public static function parseTokenResponse(array $arrayData, bool $isSingle = false): TokenResponse
    {
        $singleArrayDate = null;
        if ($isSingle)
            $singleArrayDate = $arrayData;
        else
            $singleArrayDate = $arrayData[0];

        $entity = new TokenResponse();
        $entity->setRefreshToken($singleArrayDate['refreshToken']);
        $entity->setAutenticationToken($singleArrayDate['autenticationToken']);

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
     * autenticationTokenのセット
     *
     * @param string $autenticationToken
     * @return void
     */
    public function setAutenticationToken(string $autenticationToken)
    {
        $this->autenticationToken = $autenticationToken;
    }

    /**
     * autenticationTokenの取得
     *
     * @return string
     */
    public function getAutenticationToken(): string
    {
        return $this->autenticationToken;
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

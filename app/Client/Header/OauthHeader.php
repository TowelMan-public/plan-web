<?php

namespace App\Client\Header;

/**
 * API呼び出すときのヘッダー（Oauth認証付き）
 */
class OauthHeader extends BaseHeader
{
    private array $headerArray = array();

    /**
     * コンストラクタ
     *
     * @param string|null $oauthToken　認証用トークン、nullなら何もしない
     */
    public function __construct(string $oauthToken = null)
    {
        if(!is_null($oauthToken))
            $this->setOauthToken($oauthToken);
    }

    /**
     * 認証用トークンをセットする
     *
     * @param string $oauthToken 認証用トークン
     * @return void
     */
    public function setOauthToken(string $oauthToken)
    {
        $this->headerArray['X-AUTH-TOKEN'] = $oauthToken;
    }

    /**
     * ヘッダーを連想配列として出力する
     *
     * @return array ヘッダーの連想配列
     */
    public function toArray(): array
    {
        return $this->headerArray;
    }
}

?>
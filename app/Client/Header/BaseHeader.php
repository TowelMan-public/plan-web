<?php

namespace App\Client\Header;

/**
 * API呼び出すときのヘッダー
 */
class BaseHeader
{
    /**
     * ヘッダーを連想配列として出力する
     *
     * @return array ヘッダーの連想配列
     */
    public function toArray(): array{
        return array();
    }
}

?>
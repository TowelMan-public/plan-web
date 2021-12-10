<?php

namespace App\Client\Exception;

use RuntimeException;

/**
 * 認証エラー（認証用トークンが不正・再ログインが必要）
 */
class InvalidLoginException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('You have not login or you have to login one more');
    }
}
<?php

namespace App\Client\Exception;

use Exception;

/**
 * 認証エラー（認証用トークンが不正・再ログインが必要）
 */
class InvalidLoginException extends Exception
{
    public function __construct()
    {
        parent::__construct('You have not login or you have to login one more');
    }
}
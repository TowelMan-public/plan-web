<?php

namespace App\Client\Exception;

use Exception;

/**
 * サーバ側でバリデーションチェックに引っかかった。
 */
class ValidateException extends Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
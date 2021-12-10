<?php

namespace App\Client\Exception;

use RuntimeException;

/**
 * サーバ側でバリデーションチェックに引っかかった。
 */
class ValidateException extends RuntimeException
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
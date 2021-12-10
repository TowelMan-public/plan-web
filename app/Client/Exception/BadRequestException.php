<?php

namespace App\Client\Exception;

use Exception;

/**
 * 不正なリクエストが来たときの例外
 */
class BadRequestException extends Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
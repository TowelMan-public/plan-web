<?php

namespace App\Client\Exception;

use RuntimeException;

/**
 * 不正なリクエストが来たときの例外
 */
class BadRequestException extends RuntimeException
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
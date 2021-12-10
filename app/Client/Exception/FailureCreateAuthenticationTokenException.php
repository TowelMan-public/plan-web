<?php

namespace App\Client\Exception;

use RuntimeException;

/**
 * 認証用トークンが不正
 */
class FailureCreateAuthenticationTokenException extends RuntimeException
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
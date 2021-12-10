<?php

namespace App\Client\Exception;

use Exception;

/**
 * 認証用トークンが不正
 */
class FailureCreateAuthenticationTokenException extends Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
<?php

namespace App\Client\Exception;

use RuntimeException;

/**
 * 既に使われているユーザー名が指定されたときの例外
 */
class AlreadyUsedUserNameException extends RuntimeException
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
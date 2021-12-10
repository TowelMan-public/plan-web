<?php

namespace App\Client\Exception;

use Exception;

/**
 * 既に使われているユーザー名が指定されたときの例外
 */
class AlreadyUsedUserNameException extends Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
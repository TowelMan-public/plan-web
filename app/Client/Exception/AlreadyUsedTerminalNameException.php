<?php

namespace App\Client\Exception;

use Exception;

/**
 * 既に使われている機種名が指定されたときの例外
 */
class AlreadyUsedTerminalNameException extends Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
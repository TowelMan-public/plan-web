<?php

namespace App\Client\Exception;

use RuntimeException;

/**
 * 既に使われている機種名が指定されたときの例外
 */
class AlreadyUsedTerminalNameException extends RuntimeException
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
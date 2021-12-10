<?php

namespace App\Exception;

use RuntimeException;

/**
 * 日付関連のエラー
 */
class DateException extends RuntimeException
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
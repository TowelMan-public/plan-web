<?php

/**
 * 日付関連のエラー
 */
class DateException extends Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
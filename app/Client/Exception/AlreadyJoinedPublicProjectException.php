<?php

namespace App\Client\Exception;

use Exception;

/**
 * 既にプロジェクトに加入してるか、勧誘されてるユーザーが指定されたときの例外
 */
class AlreadyJoinedPublicProjectException extends Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
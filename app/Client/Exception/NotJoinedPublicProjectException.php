<?php

namespace App\Client\Exception;

use RuntimeException;

/**
 * 加入していないか、勧誘されてないパブリックプロジェクトが指定されたときの例外
 */
class NotJoinedPublicProjectException extends RuntimeException
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
<?php

namespace App\Client\Exception;

use Exception;

/**
 * 加入していないか、勧誘されてないパブリックプロジェクトが指定されたときの例外
 */
class NotJoinedPublicProjectException extends Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
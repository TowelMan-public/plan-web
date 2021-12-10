<?php

namespace App\Client\Exception;

use Exception;

/**
 * 操作をする権限がないプロジェクトを操作しようとしたときに投げられる例外
 */
class NotHaveAuthorityToOperateProjectException extends Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
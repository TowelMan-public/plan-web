<?php

namespace App\Client\Exception;

use RuntimeException;

/**
 * 既に「やること」の担当者に抜擢されているユーザーが指定されたときの例外
 */
class AlreadySelectedAsTodoResponsibleException extends RuntimeException
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
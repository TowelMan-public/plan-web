<?php

namespace App\Client\Exception;

use RuntimeException;

/**
 * 担当者に抜擢されてない「やること」が指定されたときの例外
 */
class NotSelectedAsTodoResponsibleException extends RuntimeException
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
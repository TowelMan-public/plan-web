<?php

namespace App\Client\Exception;

use Exception;

/**
 * 担当者に抜擢されてない「やること」が指定されたときの例外
 */
class NotSelectedAsTodoResponsibleException extends Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
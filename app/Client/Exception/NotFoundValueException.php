<?php

namespace App\Client\Exception;

use RuntimeException;

/**
 * 存在しない値が指定されたときに投げられる例外<br>
 * そのフィールド名と値をセットして投げる
 */
class NotFoundValueException extends RuntimeException
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }

    //TODO その都度作っていく
}
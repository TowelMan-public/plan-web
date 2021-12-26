<?php

namespace App\Client\Exception;

use RuntimeException;

/**
 * APIの、通信時のエラー
 */
class ApiHttpException extends RuntimeException
{
    private int $statusCode;

    private array $resultArray;

    /**
     * resultArrayの取得
     * 
     * @return array|null
     */
    public function getResultArray(): array|null
    {
        return $this->resultArray;
    }

    /**
     * statusCodeの取得
     * 
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function __construct(int $statusCode, array $resultArray = null)
    {
        $this->statusCode = $statusCode;
        $this->resultArray = $resultArray;
        parent::__construct('API HTTP ERROR!');
    }
}

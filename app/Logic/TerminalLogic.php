<?php

namespace App\Logic;

use App\Client\Response\TerminalResponse;
use App\Http\Data\TerminalData;

class TerminalLogic
{
    /**
    * コンストラクタ
    */
    private function __construct(){}

    static public function createTerminalData(TerminalResponse $response): TerminalData
    {
        $data = new TerminalData();
        $data->setName($response->getTerminaName());
        return $data;
    }
}
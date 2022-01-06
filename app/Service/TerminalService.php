<?php

namespace App\Service;

use App\Client\Api\Api;
use App\Logic\TerminalLogic;

class TerminalService
{
    private static TerminalService $instance;

    /**
     * コンストラクタ シングルトン設計のためプライベート
     */
    private function __construct(){}

    /**
     * インスタンスを取得する
     *
     * @return TerminalServiceのインスタンス
     */
    public static function getInstance(): TerminalService
    {
        self::$instance ??= new TerminalService();
        return self::$instance;
    }

    public function getMyTerminalArray(string $oauthToken): array
    {
        $responseArray = Api::last()->terminal()->getList($oauthToken);
        $dataArray = [];
        foreach ($responseArray as $response) {
            $dataArray[] = TerminalLogic::createTerminalData($response);
        }

        return $dataArray;
    }

    public function deleteTerminal(string $oauthToken, string $terminalName)
    {
        Api::last()->terminal()->delete($oauthToken, $terminalName);
    }
}

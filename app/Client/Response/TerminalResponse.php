<?php

namespace App\Client\Response;

class TerminalResponse
{

    private string $terminaName;

    /**
     * TerminalResponse単体を生成する
     * 
     * @param array $arrayData UserResponseの連想配列の配列もしくは連想配列
     * @return TerminalResponse
     */
    public static function parseTerminalResponse(array $arrayData): TerminalResponse
    {
        $singleArrayDate = $arrayData;

        $entity = new TerminalResponse();
        $entity->setTerminaName($singleArrayDate['terminaName']);

        return $entity;
    }

    /**
     * TerminalResponseの配列を生成する
     * 
     * @param array $arrayData UserResponseの連想配列の配列
     * @return array ${1:ClassName}の配列
     */
    public static function parseTerminalResponseArray(array $arrayData): array
    {
        $entityArray = array();
        foreach ($arrayData as $valueArray)
            $entityArray[] = self::parseTerminalResponse($valueArray);

        return $entityArray;
    }

    /**
     * terminaNameのセット
     *
     * @param string $terminaName
     * @return void
     */
    public function setTerminaName(string $terminaName)
    {
        $this->terminaName = $terminaName;
    }

    /**
     * terminaNameの取得
     *
     * @return string
     */
    public function getTerminaName(): string
    {
        return $this->terminaName;
    }
}

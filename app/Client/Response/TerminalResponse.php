<?php

class TerminalResponse
{

    private string $terminaName;

    /**
     * TerminalResponse単体を生成する
     * 
     * @param array $arrayData UserResponseの連想配列の配列もしくは連想配列
     * @param boolean $isSingle $arrayDataが連想配列であればtrue、そうでなければfalse。通常はtrue。
     * @return TerminalResponse
     */
    public static function parseTerminalResponse(array $arrayData, bool $isSingle = false): TerminalResponse
    {
        $singleArrayDate = null;
        if ($isSingle)
            $singleArrayDate = $arrayData;
        else
            $singleArrayDate = $arrayData[0];

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

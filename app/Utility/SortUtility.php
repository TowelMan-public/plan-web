<?php

namespace App\Utility;

use Closure;

class SortUtility
{
    /**
    * コンストラクタ
    */
    private function __construct(){}

    /**
     * ヒープソートを昇順にする。配列の中身は何でもよいが、$getIntValueに比較するための値をint型で返す関数を指定しなくてはならない
     *
     * @param array $beforeArray ソートしてほしい配列。引数に指定した側の配列に影響は出ないた、注意
     * @param Closure $getIntValue 配列の一要素に対し、比較対象となるint型の値を取得するためのラムダ関数
     * @return array ソートされた配列
     */
    static public function heapAscSort(array $beforeArray, Closure $getIntValue): array
    {
        $resultArray = [];
        $arrayCount = count($beforeArray);

        for($i = 0; $i < $arrayCount; $i++){
            for ($j = $arrayCount - 1 - $i; $j > 0; $j--) {
                $childindex = $j + $i;
                $rootIndex = (int)($j / 2) + $i;

                if($getIntValue($beforeArray[$childindex]) < $getIntValue($beforeArray[$rootIndex])){
                    $tmp = $beforeArray[$childindex];
                    $beforeArray[$childindex] = $beforeArray[$rootIndex];
                    $beforeArray[$rootIndex] = $tmp;
                }
            }

            $resultArray[] = $beforeArray[$i];
        }

        return $resultArray;
    }

    /**
     * ヒープソートを降順にする。配列の中身は何でもよいが、$getIntValueに比較するための値をint型で返す関数を指定しなくてはならない
     *
     * @param array $beforeArray ソートしてほしい配列。引数に指定した側の配列に影響は出ないた、注意
     * @param Closure $getIntValue 配列の一要素に対し、比較対象となるint型の値を取得するためのラムダ関数
     * @return array ソートされた配列
     */
    static public function heapDescSort(array $beforeArray, Closure $getIntValue): array
    {
        $resultArray = [];
        $arrayCount = count($beforeArray);

        for($i = 0; $i < $arrayCount; $i++){
            for ($j = $arrayCount - 1 - $i; $j > 0; $j--) {
                $childindex = $j + $i;
                $rootIndex = (int)($j / 2) + $i;

                if($getIntValue($beforeArray[$childindex]) > $getIntValue($beforeArray[$rootIndex])){
                    $tmp = $beforeArray[$childindex];
                    $beforeArray[$childindex] = $beforeArray[$rootIndex];
                    $beforeArray[$rootIndex] = $tmp;
                }
            }

            $resultArray[] = $beforeArray[$i];
        }

        return $resultArray;
    }
}

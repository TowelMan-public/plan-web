<?php

/**
 * 全てのAPIをまとめているクラス
 */
class Api{
    /**
     * v1系のAPI軍団
     *
     * @return V1
     */
    static public function v1(): V1
    {
        return V1::getInstance();
    }

    /**
     * 最新のAPI軍団
     *
     * @return V1 現在はv1系のAPI軍団
     */
    static public function last(): V1
    {
        return V1::getInstance();
    }
}
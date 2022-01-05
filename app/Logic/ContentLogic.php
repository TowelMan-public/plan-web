<?php

namespace App\Logic;

use App\Client\Response\ContentResponse;
use App\Http\Data\ContentData;

/**
 * 「やること」の内容に関する小部品
 */
class ContentLogic
{
    /**
    * コンストラクタ
    */
    private function __construct(){}

    /**
     * ContentDataの作成
     *
     * @param ContentResponse $response
     * @return ContentData
     */
    static public function createContentData(ContentResponse $response): ContentData
    {
        $data = new ContentData();

        $data->setId($response->getContentId());
        $data->setTitle($response->getContentTitle());
        $data->setExplanation($response->getContentExplanation());
        $data->setIsCompleted($response->getIsCompleted());

        return $data;
    }
    
    /**
     * ContentDataの配列の作成
     *
     * @param array $responseArray ContentResponseの配列
     * @return array ContentDataの配列
     */
    static public function createContentdataArray(array $responseArray): array
    {
        $dataArray = [];

        foreach ($responseArray as $response) 
            $dataArray[] = self::createContentData($response);

        return $dataArray;
    }
}

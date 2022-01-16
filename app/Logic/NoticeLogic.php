<?php

namespace App\Logic;

use App\Client\Response\NoticeResponse;
use App\Http\Data\NoticeData;

/**
 * 「やること」の内容に関する小部品
 */
class NoticeLogic
{
    /**
    * コンストラクタ
    */
    private function __construct(){}

    static public function createNoticeData(NoticeResponse $responce): NoticeData
    {
        $data = new NoticeData();
        $data->setNoticeType($responce->getNoticeType());
        $data->setMessage($responce->getMessage());

        if($data->isProjectNotice()){
            $data->setLink('/project/public/'.$responce->getNoticeId());
        }else{
            $data->setLink('/todo/onProject/'.$responce->getNoticeId());
        }

        return $data;
    }
}
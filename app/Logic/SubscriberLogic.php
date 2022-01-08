<?php

namespace App\Logic;

use App\Client\Response\SubscriberInPublicProjectResponse;
use App\Client\Response\UserResponse;
use App\Http\Data\SubscriberData;

class SubscriberLogic
{
    /**
    * コンストラクタ
    */
    private function __construct(){}

    static public function createSubscriberData(SubscriberInPublicProjectResponse $subscriberResponse, UserResponse $userResponse): SubscriberData
    {
        $data = new SubscriberData();
        $data->setUserName($subscriberResponse->getUserName());
        $data->setAuthorityId($subscriberResponse->getProjectAuthority());
        $data->setUserNickName($userResponse->getUserNickName());

        return $data;
    }
}
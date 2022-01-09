<?php

namespace App\Service;

use App\Client\Api\Api;
use App\Http\Data\SubscriberData;
use App\Logic\SubscriberLogic;

class SubscriberService
{
    private static SubscriberService $instance;

    /**
     * コンストラクタ シングルトン設計のためプライベート
     */
    private function __construct()
    {
    }

    /**
     * インスタンスを取得する
     *
     * @return SubscriberServiceのインスタンス
     */
    public static function getInstance(): SubscriberService
    {
        self::$instance ??= new SubscriberService();
        return self::$instance;
    }

    public function getMySubscriberData(string $oauthToken, int $publicProjectId): SubscriberData
    {
        $subscriberResponseArray = Api::last()->subscriber()->getList($oauthToken, $publicProjectId);
        $userResponse = Api::last()->user()->get($oauthToken);

        foreach ($subscriberResponseArray as $subscriberResponse) {
            if($subscriberResponse->getUserName() === $userResponse->getUserName())
                return SubscriberLogic::createSubscriberData($subscriberResponse, $userResponse);
        }
    }

    public function acceptProject(string $oauthToken, int $publicProjectId)
    {
        Api::last()->subscriber()->postAccept($oauthToken, $publicProjectId);
    }

    public function blockProject(string $oauthToken, int $publicProjectId)
    {
        Api::last()->subscriber()->postBlock($oauthToken, $publicProjectId);
    }

    public function getSubscriberDataArray(string $oauthToken, int $publicProjectId): array
    {
        $subscriberArray = Api::last()->subscriber()->getList($oauthToken, $publicProjectId);
        $dataArray = [];

        foreach ($subscriberArray as $subscriberResponse) {
            $userResponse = Api::last()->user()->get($oauthToken, $subscriberResponse->getUserName());
            $dataArray[] = SubscriberLogic::createSubscriberData($subscriberResponse, $userResponse);
        }

        return $dataArray;
    }

    public function invitationUser(string $oauthToken, int $publicProjectId, string $usreName)
    {
        Api::last()->subscriber()->post($oauthToken, $publicProjectId, $usreName);
    }

    public function updateSubscriber(string $oauthToken, int $publicProjectId, string $usreName, int $authorityId)
    {
        Api::last()->subscriber()->put($oauthToken, $publicProjectId, $usreName, $authorityId);
    }

    public function deleteSubscriber(string $oauthToken, int $publicProjectId, string $usreName)
    {
        Api::last()->subscriber()->delete($oauthToken, $publicProjectId, $usreName);
    }

    public function exitProject(string $oauthToken, int $publicProjectId)
    {
        Api::last()->subscriber()->postExit($oauthToken, $publicProjectId);
    }
}

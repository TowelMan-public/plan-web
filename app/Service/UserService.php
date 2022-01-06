<?php

namespace App\Service;

use App\Client\Api\Api;
use App\Http\Data\UserConfigData;
use App\Http\Data\UserData;
use App\Logic\UserLogic;

/**
 * ユーザーに関するビジネスロジック
 */
class UserService 
{
    private static UserService $instance;

    /**
     * コンストラクタ シングルトン設計のためプライベート
     */
    private function __construct() {}

    /**
     * インスタンスを取得する
     *
     * @return UserServiceのインスタンス
     */
    public static function getInstance(): UserService
    {
        self::$instance ??= new UserService();
        return self::$instance;
    }
    
    /**
     * ユーザーの新規登録
     *
     * @param string $userName
     * @param string $userNickName
     * @param string $password
     * @return void
     */
    public function insertUser(string $userName, string $userNickName, string $password)
    {
        Api::last()->user()->post($userName, $userNickName, $password);
    }

    public function getUserData(string $oauthToken): UserData
    {
        $userResponse = Api::last()->user()->get($oauthToken);
        return UserLogic::createUserData($userResponse);
    }

    public function getUserConfig(string $oauthToken): UserConfigData
    {
        $response = Api::last()->userConfig()->get($oauthToken);
        return UserLogic::createUserConfigData($response);
    }

    public function updateUser(string $oauthToken, string $userName, string $userNickName, string|null $password)
    {
        $beforeUserName = Api::last()->user()->get($oauthToken)->getUserName();

        if($beforeUserName === $userName)
            Api::last()->user()->put($oauthToken, null, $userNickName, $password);
        else
            Api::last()->user()->put($oauthToken, $userName, $userNickName, $password);
    }

    public function updateUserConfig(string $oauthToken, bool $isPushStartedTodoNotice, bool $isPushInsertedTodoNotice,
            int $beforeDeadlineForProjectNotice, int $beforeDeadlineForTodoNotice)
    {
        Api::last()->userConfig()->put($oauthToken, $beforeDeadlineForTodoNotice, $beforeDeadlineForProjectNotice,
            $isPushInsertedTodoNotice, $isPushStartedTodoNotice);
    }
}
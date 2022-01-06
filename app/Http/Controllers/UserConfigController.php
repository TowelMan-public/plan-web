<?php

namespace App\Http\Controllers;

use App\Client\Exception\AlreadyUsedUserNameException;
use App\Http\Requests\UpdateUserConfigRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Service\UserService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

class UserConfigController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private UserService $userService;

    private const DAY_IN_SECONDS = 86400;
    private const HOUR_IN_SECONDS = 3600;
    private const MINUTE_IN_SECONDS = 60;
    private const DEFAULT_REDIRECT = [UserConfigController::class, 'show'];

    /**
     * コンストラクタ
     */
    public function __construct()
    {
        $this->userService = UserService::getInstance();
    }

    public function show()
    {
        $userData = $this->userService->getUserData($this->getOauthToken());
        $userConfigData = $this->userService->getUserConfig($this->getOauthToken());

        return View('user_config_layout')
            ->with('user', $userData)
            ->with('userConfig', $userConfigData);
    }

    public function updateUser(UpdateUserRequest $request)
    {
        try{
            $this->userService->updateUser($this->getOauthToken(), $request->userName, $request->userNickName, $request->password);
            return redirect()->action(self::DEFAULT_REDIRECT);
        }
        catch(AlreadyUsedUserNameException $e){
            session()->put('_old_input', $request->all());
            $userConfigData = $this->userService->getUserConfig($this->getOauthToken());

            return View('user_config_layout')
                ->with('userCoreConfigErrorString', 'あなたが指定したユーザー名は既に指定されています。')
                ->with('userConfig', $userConfigData);
        }
    }

    public function updateUserConfig(UpdateUserConfigRequest $request)
    {
        $this->userService->updateUserConfig($this->getOauthToken(), $request->isPushStartedTodoNotice !== null, $request->isPushInsertedTodoNotice !== null,
            $request->beforeDeadlineForProjectNoticeDay*self::DAY_IN_SECONDS + $request->beforeDeadlineForProjectNoticeHour*self::HOUR_IN_SECONDS + $request->beforeDeadlineForProjectNoticeMinute*self::MINUTE_IN_SECONDS,
            $request->beforeDeadlineForTodoNoticeDay*self::DAY_IN_SECONDS + $request->beforeDeadlineForTodoNoticeHour*self::HOUR_IN_SECONDS + $request->beforeDeadlineForTodoNoticeMinute*self::MINUTE_IN_SECONDS);

        return redirect()->action(self::DEFAULT_REDIRECT);
    }
}

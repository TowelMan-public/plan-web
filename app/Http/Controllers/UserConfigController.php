<?php

namespace App\Http\Controllers;

use App\Service\UserService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

class UserConfigController extends Controller
{
     use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
     
     private UserService $userService;

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
}
<?php

namespace App\Http\Controllers;

use AlreadyUsedUserNameException;
use App\Http\Requests\SignUpRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use UserService;

class SignUpController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, Request;

    private UserService $userService;

    /**
    * コンストラクタ
    */
    public function __construct()
    {
        $userService = UserService::getInstance();
    }

    public function show(Request $request)
    {
        return View('sign_up');
    }

    public function signUp(SignUpRequest $request)
    {
        try{
            $this->userService->insertUser($request->userName, $request->userNickName, $request->password);
            return redirect()->action('LoginController@show');
        }catch(AlreadyUsedUserNameException $e){
            return View('sign_up')->with('formError', 'あなたが指定したユーザー名は既に指定されています。');
        }
    }
}
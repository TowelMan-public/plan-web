<?php

namespace App\Http\Controllers;

use App\Client\Exception\AlreadyUsedUserNameException;
use App\Http\Requests\SignUpRequest;
use App\Service\UserService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;

class SignUpController extends Controller
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

    public function show(Request $request)
    {
        return View('sign_up');
    }

    public function signUp(SignUpRequest $request)
    {
        try{
            $this->userService->insertUser($request->userName, $request->userNickName, $request->password);
            return redirect()->action([LoginController::class, 'show']);
        }catch(AlreadyUsedUserNameException $e){
            session()->put('_old_input', $request->all());
            return View('sign_up')->with('formError', 'あなたが指定したユーザー名は既に指定されています。');
        }
    }
}
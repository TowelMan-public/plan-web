<?php

namespace App\Http\Controllers;

use App\Client\Exception\FailureCreateAuthenticationTokenException;
use App\Http\Requests\LoginRequest;
use App\Service\OauthService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    private const HOME_PAGE_CONTROLLER = [Controller::class, 'show'];//TODO ホームController
    private OauthService $oauthService;

    /**
    * コンストラクタ
    */
    public function __construct()
    {
        $this->oauthService = OauthService::getInstance();
    }

    public function show(Request $request)
    {
        return View('sign_in');
    }

    public function login(LoginRequest $request)
    {
        try{
            $tokenResponse = $this->oauthService->login($request->userName, $request->password);
            session(['oauthToken' => $tokenResponse->getAuthenticationToken()]);
            session(['oauthTokenExpiration' => time() + 25 * 60]);
            session(['refreshToken' => $tokenResponse->getRefreshToken()]);
            session()->save();

            return View('test');
        }
        catch(FailureCreateAuthenticationTokenException $e){            
            session()->put('_old_input', $request->all());
            return View('sign_in')->with('formError', 'ログインに失敗しました。ユーザー名とパスワードをご確認ください。');
        }
    }

    public function logout(Request $request)
    {
        session()->flush();
        return redirect()->action([LoginController::class, 'show']);
    }
}

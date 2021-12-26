<?php

namespace App\Http\Middleware;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\TodoInDayController;
use App\Service\OauthService;
use Closure;
use Illuminate\Http\Request;

/**
 * ログインされているかどうかを判別し、それに応じて適切な処理を施す
 */
class SesstionOauth
{
    private OauthService $oauthService;

    private const HOME_PAGE_CONTROLLER = [TodoInDayController::class, 'showDefault'];

    /**
    * コンストラクタ
    */
    public function __construct()
    {
        $this->oauthService = OauthService::getInstance();
    }

    /**
     * ログイン判定をする。
     * 尚、必要に応じて認証用トークンの更新をする。
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $path = $request->path();

        if(session()->has('oauthToken')){

            //tokenの再生成
            if(session('oauthTokenExpiration') < time()){
                $tokenResponse = $this->oauthService->updateToken(session('refreshToken'));
                session(['oauthToken' => $tokenResponse->getAuthenticationToken()]);
                session(['oauthTokenExpiration' => time() + 25 * 60]);
                session(['refreshToken' => $tokenResponse->getRefreshToken()]);
                session()->save();
            }

            if($path === 'sign_in' || $path === 'sign_up')
                return redirect()->action(self::HOME_PAGE_CONTROLLER);
            else
                return $next($request);
        }
        else{
            if($path === 'sign_in' || $path === 'sign_up')
                return $next($request);
            else
                return redirect()->action([LoginController::class, 'show']);
        }
    }
}
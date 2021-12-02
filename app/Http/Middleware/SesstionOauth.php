<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use OauthService;

/**
 * ログインされているかどうかを判別し、それに応じて適切な処理を施す
 */
class SesstionOauth
{
    private OauthService $oauthService;

    /**
    * コンストラクタ
    */
    public function __construct()
    {
        $oauthService = OauthService::getInstance();
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
        if(session()->has('oauthToken')){

            //tokenの再生成
            if(session('oauthTokenExpiration') < time()){
                $tokenResponse = $this->oauthService->updateToken(session('refreshTooken'));
                session(['oauthToken' => $tokenResponse->getAutenticationToken()]);
                session(['oauthTokenExpiration' => time() + 25 * 60]);
                session(['refreshToken' => $tokenResponse->getRefreshToken()]);
            }

            return $next($request);
        }
        else{
            $path = $request->path();

            if($path === 'sign_in' || $path === 'sign_up')
                return $next($request);
            else
                return redirect()->action('LoginController@show');
        }
    }
}

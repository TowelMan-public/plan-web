<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

class FallbackController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private const HOME_PAGE_CONTROLLER = [TodoInDayController::class, 'showDefault'];

    public function handl()
    {
        if(session()->has('oauthToken'))
            return redirect()->action(self::HOME_PAGE_CONTROLLER);
        else
            return redirect()->action([LoginController::class, 'show']);
    }
}
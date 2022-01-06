<?php

namespace App\Http\Controllers;

use App\Service\UserService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

class WithdrawalController extends Controller
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
        return View('withdrawal');
   }

   public function withdrawal()
   {
       $this->userService->deleteUser($this->getOauthToken());
       session()->flush();
       
       return redirect()->action([LoginController::class, 'show']);
   }
}
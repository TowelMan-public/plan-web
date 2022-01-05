<?php

namespace App\Http\Controllers;

use App\Service\TodoService;
use App\Utility\DateUtility;
use DateTime;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

class TodoInMonthController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
     
    private TodoService $todoService;

    /**
    * コンストラクタ
    */
    public function __construct()
    {
        $this->todoService = TodoService::getInstance();
    }

   public function showDefault()
   {
        $nowDate = new DateTime();
        $nowDateArray = DateUtility::getDateAssociativeArrayByDateTime($nowDate);

        $todoInMonth = $this->todoService->getMyTodoInMonth($this->getOauthToken(), $nowDateArray[DateUtility::YEAR], $nowDateArray[DateUtility::MONTH]);

        return View('todo_in_month_layout')
            ->with('todoInMonth', $todoInMonth)
            ->with('dateAssociativeArray', $nowDateArray);
   }
}
<?php

namespace App\Http\Controllers;

use App\Client\Api\Api;
use App\Service\TodoService;
use App\Utility\DateUtility;
use DateTime;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

class TodoInDayController extends Controller
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
        $finishDate = DateUtility::getNextDaysTopDateTime($nowDate);
        $after5HourDate = DateUtility::addDate($nowDate, [
            DateUtility::HOUR => 5
        ]);

        if($finishDate->getTimestamp() < $after5HourDate->getTimestamp())
            $finishDate = $after5HourDate;
        
        $todoInDay = $this->todoService->getMyTodoInDayData($this->getOauthToken(), $nowDate, $finishDate);
        
        return View('todo_in_day_layout')
            ->with('todoInDay', $todoInDay)
            ->with('dateAssociativeArray', $nowDateArray);
    }
}
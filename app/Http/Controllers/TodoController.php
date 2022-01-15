<?php

namespace App\Http\Controllers;

use App\Service\TodoService;
use App\Utility\DateUtility;
use DateTime;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;

class TodoController extends Controller
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

    public function showDefaultInDay(Request $request)
    {
        $nowDateArray = DateUtility::getDateAssociativeArrayByDateTime(new DateTime());

        return redirect(route('TodoController@showInDay', $request->all() + [
            'year' => $nowDateArray[DateUtility::YEAR],
            'month' => $nowDateArray[DateUtility::MONTH],
            'day' => $nowDateArray[DateUtility::DAY],
        ]));
    }

    public function showInDay(Request $request, int $year, int $month, int $day)
    {
        $isToday = false;
        $date = DateUtility::createDate($year, $month, $day, 0, 0);
        $nowDate = new DateTime();
        $nowDateArray = DateUtility::getDateAssociativeArrayByDateTime($nowDate);
        $dateArray = DateUtility::getDateAssociativeArrayByDateTime($date);
        $finishDate = DateUtility::getNextDaysTopDateTime($date);

        if($dateArray[DateUtility::YEAR] === $nowDateArray[DateUtility::YEAR] &&
            $dateArray[DateUtility::MONTH] === $nowDateArray[DateUtility::MONTH] &&
            $dateArray[DateUtility::DAY] === $nowDateArray[DateUtility::DAY])
        {
            $isToday = true;
            $date = $nowDate;

            $after5HourDate = DateUtility::addDate($nowDate, [
                DateUtility::HOUR => 5
            ]);

            if (DateUtility::getNextDaysTopDateTime($date)->getTimestamp() < $after5HourDate->getTimestamp())
                $finishDate = $after5HourDate;
        }

        $todoInDay = $this->todoService->getMyTodoInDayData($this->getOauthToken(), $nowDate, $finishDate, $request->includeCompleted !== null);
        if(!$isToday)
            $todoInDay->setExpiredTodoList([]);

        return View('todo_in_day_layout')
            ->with('todoInDay', $todoInDay)
            ->with('includeCompleted', $request->includeCompleted)
            ->with('projectData', null)
            ->with('mySubscriberData', null)
            ->with('dateAssociativeArray', $dateArray);
    }

    public function showNextInDay(Request $request, int $year, int $month, int $day)
    {
        $dateArray = DateUtility::getDateAssociativeArrayByDateTime(
            DateUtility::addDate(
                DateUtility::createDate($year, $month, $day, 0, 0),
                [DateUtility::DAY => 1]
            )
        );

        return redirect(route('TodoController@showInDay', $request->all() + [
            'year' => $dateArray[DateUtility::YEAR],
            'month' => $dateArray[DateUtility::MONTH],
            'day' => $dateArray[DateUtility::DAY],
        ]));
    }

    public function showBackInDay(Request $request, int $year, int $month, int $day)
    {
        $dateArray = DateUtility::getDateAssociativeArrayByDateTime(
            DateUtility::addDate(
                DateUtility::createDate($year, $month, $day, 0, 0),
                [DateUtility::DAY => -1]
            )
        );

        return redirect(route('TodoController@showInDay', $request->all() + [
            'year' => $dateArray[DateUtility::YEAR],
            'month' => $dateArray[DateUtility::MONTH],
            'day' => $dateArray[DateUtility::DAY],
        ]));
    }

    public function showDefaultInMonth(Request $request)
    {
        $nowDateArray = DateUtility::getDateAssociativeArrayByDateTime(new DateTime());

        return redirect(route('TodoController@showInMonth', $request->all() + [
            'year' => $nowDateArray[DateUtility::YEAR],
            'month' => $nowDateArray[DateUtility::MONTH],
        ]));
    }

    public function showInMonth(Request $request, int $year, int $month)
    {
        $todoInMonth = $this->todoService->getMyTodoInMonth($this->getOauthToken(), $year, $month, $request->includeCompleted !== null);
        return View('todo_in_month_layout')
            ->with('todoInMonth', $todoInMonth)
            ->with('includeCompleted', $request->includeCompleted)
            ->with('projectData', null)
            ->with('mySubscriberData', null)
            ->with(
                'dateAssociativeArray',
                DateUtility::getDateAssociativeArrayByDateTime(
                    DateUtility::createDate($year, $month, 1, 1, 1)
                )
            );
    }

    public function showNextInMonth(Request $request, int $year, int $month)
    {
        $dateArray = DateUtility::getDateAssociativeArrayByDateTime(
            DateUtility::addDate(
                DateUtility::createDate($year, $month, 1, 0, 0),
                [DateUtility::MONTH => 1]
            )
        );

        return redirect(route('TodoController@showInMonth', $request->all() + [
            'year' => $dateArray[DateUtility::YEAR],
            'month' => $dateArray[DateUtility::MONTH],
        ]));
    }

    public function showBackInMonth(Request $request, int $year, int $month)
    {
        $dateArray = DateUtility::getDateAssociativeArrayByDateTime(
            DateUtility::addDate(
                DateUtility::createDate($year, $month, 1, 0, 0),
                [DateUtility::MONTH => -1]
            )
        );

        return redirect(route('TodoController@showInMonth', $request->all() + [
            'year' => $dateArray[DateUtility::YEAR],
            'month' => $dateArray[DateUtility::MONTH],
        ]));
    }
}

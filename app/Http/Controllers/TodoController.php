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
        $nowDate = new DateTime();
        $nowDateArray = DateUtility::getDateAssociativeArrayByDateTime($nowDate);
        $finishDate = DateUtility::getNextDaysTopDateTime($nowDate);
        $after5HourDate = DateUtility::addDate($nowDate, [
            DateUtility::HOUR => 5
        ]);

        if ($finishDate->getTimestamp() < $after5HourDate->getTimestamp())
            $finishDate = $after5HourDate;

        $todoInDay = $this->todoService->getMyTodoInDayData($this->getOauthToken(), $nowDate, $finishDate, $request->includeCompleted !== null);

        return View('todo_in_day_layout')
            ->with('todoInDay', $todoInDay)
            ->with('includeCompleted', $request->includeCompleted)
            ->with('projectData', null)
            ->with('mySubscriberData', null)
            ->with('dateAssociativeArray', $nowDateArray);
    }

    public function showInDay(Request $request, int $year, int $month, int $day)
    {
        $nowDate = DateUtility::createDate($year, $month, $day, 0, 0);
        $nowDateArray = DateUtility::getDateAssociativeArrayByDateTime($nowDate);
        $finishDate = DateUtility::getNextDaysTopDateTime($nowDate);

        $todoInDay = $this->todoService->getMyTodoInDayData($this->getOauthToken(), $nowDate, $finishDate, $request->includeCompleted !== null);
        $todoInDay->setExpiredTodoList([]);

        return View('todo_in_day_layout')
            ->with('todoInDay', $todoInDay)
            ->with('includeCompleted', $request->includeCompleted)
            ->with('projectData', null)
            ->with('mySubscriberData', null)
            ->with('dateAssociativeArray', $nowDateArray);
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
        dd(
            DateUtility::dateToString(new DateTime())
        );
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

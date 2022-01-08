<?php

namespace App\Http\Controllers;

use App\Exception\DateException;
use App\Service\ProjectService;
use App\Utility\DateUtility;
use DateTime;
use Facade\FlareClient\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;

class ProjectController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    private ProjectService $projectService;

    /**
     * コンストラクタ
     */
    public function __construct()
    {
        $this->projectService = ProjectService::getInstance();
    }

    public function showDefaultList(Request $request)
    {
        $isIncludePrivate = isset($request->includePrivate);

        $projectListData = $this->projectService->getProjectListData($this->getOauthToken(), new DateTime(), $request->unIncludePrivate === null, $request->includeCompleted != null);

        return View('project_list_layout')
            ->with('projectListData', $projectListData)
            ->with('unIncludePrivate', $request->unIncludePrivate??null)
            ->with('includeCompleted', $request->includeCompleted??null);
    }

    public function showDefaultListInMonth(Request $request)
    {
        $nowDateArray = DateUtility::getDateAssociativeArrayByDateTime(new DateTime());

        return redirect(route("ProjectController@showListInMonth",$request->all() + [
                'year' => $nowDateArray[DateUtility::YEAR],
                'month' => $nowDateArray[DateUtility::MONTH],
            ]));
    }

    public function showListInMonth(Request $request, int $year, int $month)
    {
        try{       
            $nowDateArray = DateUtility::getDateAssociativeArrayByDateTime(
                DateUtility::createDate($year, $month, 1, 0, 0)
            );
            $projectInMonth = $this->projectService->getProjectInMonthData($this->getOauthToken(), $nowDateArray[DateUtility::YEAR], $nowDateArray[DateUtility::MONTH], $request->includeCompleted != null);

            return View('project_in_month_layout')
                ->with('projectInMonth', $projectInMonth)
                ->with('dateAssociativeArray', $nowDateArray)
                ->with('includeCompleted', $request->includeCompleted??null);
        }
        catch(DateException){
            return redirect()->action([ProjecController::class, 'showDefaultListInMonth'], $request->all());
        }
    }

    public function nextMonthForListInMonth(Request $request, int $year, int $month)
    {
        try{       
            $nextDateArray = DateUtility::getDateAssociativeArrayByDateTime(
                DateUtility::addDate((DateUtility::createDate($year, $month, 1, 0, 0)), [DateUtility::MONTH => 1])
            );

            return redirect(route("ProjectController@showListInMonth",$request->all() + [
                'year' => $nextDateArray[DateUtility::YEAR],
                'month' => $nextDateArray[DateUtility::MONTH],
            ]));
        }
        catch(DateException){
            return redirect()->action([ProjecController::class, 'showDefaultListInMonth'], $request->all());
        }
    }

    public function backMonthForListInMonth(Request $request, int $year, int $month)
    {
        try{       
            $backDateArray = DateUtility::getDateAssociativeArrayByDateTime(
                DateUtility::addDate((DateUtility::createDate($year, $month, 1, 0, 0)), [DateUtility::MONTH => -1])
            );

            return redirect(route("ProjectController@showListInMonth",$request->all() + [
                'year' => $backDateArray[DateUtility::YEAR],
                'month' => $backDateArray[DateUtility::MONTH],
            ]));
        }
        catch(DateException){
            return redirect()->action([ProjectController::class, 'showDefaultListInMonth'], $request->all());
        }
    }

    public function showInsertPage(Request $request)
    {
        return View('insert_project_layout')
            ->with('dateTimeError', $request->old('dateTime'));
    }
}

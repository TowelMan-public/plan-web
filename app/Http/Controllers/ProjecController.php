<?php

namespace App\Http\Controllers;

use App\Service\ProjectService;
use App\Utility\DateUtility;
use DateTime;
use Facade\FlareClient\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;

class ProjecController extends Controller
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

    public function showDefaultList()
    {
        $projectListData = $this->projectService->getProjectListData($this->getOauthToken(), new DateTime());

        return View('project_list_layout')
            ->with('projectListData', $projectListData);
    }

    public function showDefaultListInMonth()
    {
        $nowDateArray = DateUtility::getDateAssociativeArrayByDateTime(new DateTime());
        $projectInMonth = $this->projectService->getProjectInMonthData($this->getOauthToken(), $nowDateArray[DateUtility::YEAR], $nowDateArray[DateUtility::MONTH]);

        return View('project_in_month_layout')
            ->with('projectInMonth', $projectInMonth)
            ->with('dateAssociativeArray', $nowDateArray);
    }

    public function showInsertPage()
    {
        return View('insert_project_layout');
    }
}

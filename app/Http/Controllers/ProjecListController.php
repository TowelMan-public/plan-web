<?php

namespace App\Http\Controllers;

use App\Service\ProjectService;
use DateTime;
use Facade\FlareClient\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

class ProjecListController extends Controller
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
}

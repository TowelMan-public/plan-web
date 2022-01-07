<?php

namespace App\Http\Controllers;

use App\Http\Requests\InsertProjectRequest;
use App\Service\ProjectService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

class PublicProjectController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private ProjectService $projectServer;

    /**
     * コンストラクタ
     */
    public function __construct()
    {
        $this->projectServer = ProjectService::getInstance();
    }

    public function insert(InsertProjectRequest $request)
    {
        $this->projectServer->insertPublicProject($this->getOauthToken(), $request->name, $request->startDate, $request->finishData);
        return redirect()->action([TodoInMonthController::class, 'showDefault']);
    }
}

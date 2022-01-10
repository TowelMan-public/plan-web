<?php

namespace App\Http\Controllers;

use App\Http\Requests\InsertProjectRequest;
use App\Http\Requests\UpdatePrivateProjectRequest;
use App\Service\ProjectService;
use Facade\FlareClient\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

class PrivateProjectController extends Controller
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
        $this->projectServer->insertPrivateProject($this->getOauthToken(), $request->name);
        return redirect()->action([TodoController::class, 'showDefaultInDay']);
    }

    public function show(int $projectId)
    {
        $projectData = $this->projectServer->getProjectDataByPrivateProject($this->getOauthToken(), $projectId);

        return View('private_project_layout')
            ->with('projectName', $projectData->getName())
            ->with('projectId', $projectId);
    }

    public function update(UpdatePrivateProjectRequest $request, int $projectId)
    {
        $this->projectServer->updatePrivateProject($this->getOauthToken(), $projectId, $request->projectName);

        return redirect(route('PrivateProjectController@show', $request->all() + [
            'projectId' => $projectId
        ]));
    }

    public function delete(int $projectId)
    {
        $this->projectServer->deletePrivateProject($this->getOauthToken(), $projectId);

        return redirect()->action([ProjectController::class, 'showDefaultList']);
    }
}

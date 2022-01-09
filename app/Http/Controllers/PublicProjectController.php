<?php

namespace App\Http\Controllers;

use App\Client\Exception\BadRequestException;
use App\Client\Exception\NotHaveAuthorityToOperateProjectException;
use App\Http\Requests\InsertProjectRequest;
use App\Http\Requests\SetIsCompletedRequest;
use App\Http\Requests\UpdatePublicProjectRequest;
use App\Service\ProjectService;
use App\Service\SubscriberService;
use Facade\FlareClient\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;

class PublicProjectController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private ProjectService $projectServer;
    private SubscriberService $subscriberService;

    /**
     * コンストラクタ
     */
    public function __construct()
    {
        $this->projectServer = ProjectService::getInstance();
        $this->subscriberService = SubscriberService::getInstance();
    }

    public function insert(InsertProjectRequest $request)
    {
        $this->projectServer->insertPublicProject($this->getOauthToken(), $request->name, $request->startDate, $request->finishData);
        return redirect()->action([PublicProjectController::class, 'show']);
    }

    public function show(Request $request, int $projectId)
    {
        $projectData = $this->projectServer->getProjectDataByPublicProject($this->getOauthToken(), $projectId);
        $mySubscriberData = $this->subscriberService->getMySubscriberData($this->getOauthToken(), $projectId);

        session()->put('_old_input', $request->old());

        return View('public_project_layout')
            ->with('projectData', $projectData)
            ->with('mySubscriberData', $mySubscriberData);
    }

    public function update(UpdatePublicProjectRequest $request, int $projectId)
    {
        try{
            $this->projectServer->updatePublicProject($this->getOauthToken(), $projectId, $request->projectName,
                $request->startDate, $request->finishData);
            
            return redirect(route('PublicProjectController@show', [
                'projectId' => $projectId,
            ]));
        }catch(NotHaveAuthorityToOperateProjectException){
            //TODO
            return redirect(route('PublicProjectController@show', [
                'projectId' => $projectId,
            ]));
        }
    }

    public function delete(int $projectId)
    {
        try{
            $this->projectServer->deletePublicProject($this->getOauthToken(), $projectId);
            
            return redirect()->action([ProjectController::class, 'showDefaultList']);
        }catch(NotHaveAuthorityToOperateProjectException){
            return redirect(route('PublicProjectController@show', [
                'projectId' => $projectId,
            ]));
        }
    }

    public function setIsCompleted(SetIsCompletedRequest $request, int $projectId)
    {
        $this->projectServer->setIsCompletedToPublicProject($this->getOauthToken(), $projectId, $request->isCompleted);
    }

    public function accept(int $projectId)
    {
        try{
            $this->subscriberService->acceptProject($this->getOauthToken(), $projectId);
            
            return redirect(route('PublicProjectController@show', [
                'projectId' => $projectId,
            ]));
        }catch(BadRequestException){
            //TODO
        }
    }

    public function block(int $projectId)
    {
        try{
            $this->subscriberService->blockProject($this->getOauthToken(), $projectId);
            
            return redirect()->action([ProjectController::class, 'invitation']);
        }catch(BadRequestException){
            //TODO
        }
    }
}

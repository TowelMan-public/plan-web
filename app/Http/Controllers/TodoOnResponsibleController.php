<?php

namespace App\Http\Controllers;

use App\Client\Exception\NotSelectedAsTodoResponsibleException;
use App\Http\Requests\SetIsCompletedRequest;
use App\Service\ProjectService;
use App\Service\TodoService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;

class TodoOnResponsibleController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private ProjectService $projectServer;
    private TodoService $todoService;

    /**
     * コンストラクタ
     */
    public function __construct()
    {
        $this->projectServer = ProjectService::getInstance();
        $this->todoService = TodoService::getInstance();
    }


    public function show(Request $request, int $todoId)
    {
        try{
            $todoData = $this->todoService->getTodoOnResponsible($this->getOauthToken(), $todoId);
            $projectData = $this->projectServer->getProjectDataByPublicProject($this->getOauthToken(), $todoData->getProjectId());
            $operatable = true;

            session()->put('_old_input', $request->old());
            return View('todo_layout')
                ->with('formError', $request->formError)
                ->with('errorForAll', $request->errorForAll)
                ->with('todoData', $todoData)
                ->with('projectData', $projectData)
                ->with('operatable', $operatable);
        }catch(NotSelectedAsTodoResponsibleException){
            return redirect(route('TodoOnProjectController@show',[
                'todoId' => $todoId,
                'formError' => 'あなたはこのやることの担当者に抜擢されてません。',
            ]));
        }
    }

    public function exit(int $todoId)
    {
        $todoData = $this->todoService->getTodoOnResponsible($this->getOauthToken(), $todoId);
        $projectData = $this->projectServer->getProjectDataByPublicProject($this->getOauthToken(), $todoData->getProjectId());

        $this->todoService->exitTodoOnResponsible($this->getOauthToken(), $todoId);

        return redirect(route('PublicProjectController@show',[
            'projectId' => $projectData->getId(),
        ]));
    }

    public function setIsCompleted(SetIsCompletedRequest $request, int $todoId)
    {
        $this->todoService->setIsCompletedToTodoOnResponsible($this->getOauthToken(), $todoId, $request->isCompleted);
    }
}

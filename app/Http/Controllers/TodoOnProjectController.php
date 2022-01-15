<?php

namespace App\Http\Controllers;

use App\Client\Exception\BadRequestException;
use App\Client\Exception\NotHaveAuthorityToOperateProjectException;
use App\Http\Requests\SetIsCompletedRequest;
use App\Http\Requests\UpdateTodoRequest;
use App\Service\ProjectService;
use App\Service\SubscriberService;
use App\Service\TodoService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;

class TodoOnProjectController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private ProjectService $projectServer;
    private SubscriberService $subscriberService;
    private TodoService $todoService;

    /**
     * コンストラクタ
     */
    public function __construct()
    {
        $this->projectServer = ProjectService::getInstance();
        $this->subscriberService = SubscriberService::getInstance();
        $this->todoService = TodoService::getInstance();
    }

    public function show(Request $request, int $todoId)
    {
        $todoData = $this->todoService->getTodoOnProject($this->getOauthToken(), $todoId);
        $projectData = $this->projectServer->getProjectData($this->getOauthToken(), $todoData->getProjectId());
        $operatable = true;
        if(!$projectData->getIsPrivate()){
            $mySubscriberData = $this->subscriberService->getMySubscriberData($this->getOauthToken(), $projectData->getId());
            $operatable = $mySubscriberData->hasSuperAuthority();
        }

        session()->put('_old_input', $request->old());
        return View('todo_layout')
            ->with('formError', $request->formError)
            ->with('errorForAll', $request->errorForAll)
            ->with('todoData', $todoData)
            ->with('projectData', $projectData)
            ->with('operatable', $operatable);
    }

    public function update(UpdateTodoRequest $request, int $todoId)
    {
        try{
            $this->todoService->updateTodoOnProject($this->getOauthToken(), $todoId, $request->todoName, $request->startDate, $request->finishData, $request->isCopyToResponsible !== null);

            return redirect(route('TodoOnProjectController@show',[
                'todoId' => $todoId,
            ]));
        }catch(NotHaveAuthorityToOperateProjectException){
            return redirect(route('TodoOnProjectController@show',[
                'todoId' => $todoId,
                'errorForAll' => 'あなたには変更操作の権限が無いと思われます。',
            ]));
        }catch(BadRequestException){
            return redirect(route('TodoOnProjectController@show',[
                'todoId' => $todoId,
                'formError' => '指定されている開始日時と終了日時が不正だと思われます。プロジェクトの期間をご確認のうえ、期間内に設定してください。',
            ]));
        }
    }

    public function delete(int $todoId)
    {
        try{
            $todoData = $this->todoService->getTodoOnProject($this->getOauthToken(), $todoId);
            $projectData = $this->projectServer->getProjectData($this->getOauthToken(), $todoData->getProjectId());
            $this->todoService->deleteTodoOnProject($this->getOauthToken(), $todoId);

            if($projectData->getIsPrivate()){
                return redirect(route('PrivateProjectController@show',[
                    'projectId' => $projectData->getId(),
                ]));
            }else {
                return redirect(route('PublicProjectController@show',[
                    'projectId' => $projectData->getId(),
                ]));
            }
            
        }catch(NotHaveAuthorityToOperateProjectException){
            return redirect(route('TodoOnProjectController@show',[
                'todoId' => $todoId,
                'errorForAll' => '削除に失敗しました。あなたには削除操作の権限が無いと思われます。',
            ]));
        }
    }

    public function setIsCompleted(SetIsCompletedRequest $request, int $todoId)
    {
        $this->todoService->setIsCompletedToTodoOnProject($this->getOauthToken(), $todoId, $request->isCompleted);
    }
}

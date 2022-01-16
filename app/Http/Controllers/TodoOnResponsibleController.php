<?php

namespace App\Http\Controllers;

use App\Client\Exception\AlreadySelectedAsTodoResponsibleException;
use App\Client\Exception\NotFoundValueException;
use App\Client\Exception\NotHaveAuthorityToOperateProjectException;
use App\Client\Exception\NotJoinedPublicProjectException;
use App\Client\Exception\NotSelectedAsTodoResponsibleException;
use App\Http\Requests\DeleteTodoOnResponsibleRequest;
use App\Http\Requests\InsertTodoOnREsponsibleRequest;
use App\Http\Requests\SetIsCompletedRequest;
use App\Service\ProjectService;
use App\Service\SubscriberService;
use App\Service\TodoService;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;

class TodoOnResponsibleController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private ProjectService $projectServer;
    private TodoService $todoService;
    private SubscriberService $subscriberServer;

    /**
     * コンストラクタ
     */
    public function __construct()
    {
        $this->projectServer = ProjectService::getInstance();
        $this->todoService = TodoService::getInstance();
        $this->subscriberServer = SubscriberService::getInstance();
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

    public function setIsCompletedAll(SetIsCompletedRequest $request, int $todoId)
    {
        $this->todoService->setIsCompletedToTodoOnResponsibleAll($this->getOauthToken(), $todoId, $request->isCompleted);
        return redirect(route('TodoOnResponsibleController@showResponsibleList', [
            'todoId' => $todoId,
        ]));
    }

    public function delete(DeleteTodoOnResponsibleRequest $request, int $todoId)
    {
        $this->todoService->deleteTodoOnResponsible($this->getOauthToken(), $todoId, $request->userName);
    }

    public function showResponsibleList(Request $request, int $todoId)
    {
        $todoData = $this->todoService->getTodoOnProject($this->getOauthToken(), $todoId);
        $mySubscriberData = $this->subscriberServer->getMySubscriberData($this->getOauthToken(), $todoData->getProjectId());
        $operatable = $mySubscriberData->hasSuperAuthority();
        $userInResponsibleDataArray = $this->todoService->getUserInResponsibleDataArray($this->getOauthToken(), $todoId);
        
        return View('responsible_list_layout')
            ->with('formError', $request->formError)
            ->with('errorForAll', $request->errorForAll)
            ->with('todoData', $todoData)
            ->with('userInResponsibleDataArray', $userInResponsibleDataArray)
            ->with('operatable', $operatable);
    }


    public function insertResponsible(InsertTodoOnREsponsibleRequest $request, int $todoId)
    {
        try{
            $this->todoService->insertResponsible($this->getOauthToken(), $todoId, $request->userName);
            return redirect(route('TodoOnResponsibleController@showResponsibleList', [
                'todoId' => $todoId,
            ]));
        }catch(NotHaveAuthorityToOperateProjectException){
            return redirect(route('TodoOnResponsibleController@showResponsibleList', [
                'todoId' => $todoId,
                'errorForAll' => 'あなたにその操作の権限はないです。',
            ]));
        }catch(NotJoinedPublicProjectException){
            return redirect(route('TodoOnResponsibleController@showResponsibleList', [
                'todoId' => $todoId,
                'formError' => 'あなたが指定したユーザーはまだこのプロジェクトに加入していないです。',
            ]));
        }catch(NotFoundValueException){
            return redirect(route('TodoOnResponsibleController@showResponsibleList', [
                'todoId' => $todoId,
                'formError' => 'あなたが指定したユーザーは存在しません。',
            ]));
        }catch(AlreadySelectedAsTodoResponsibleException){
            return redirect(route('TodoOnResponsibleController@showResponsibleList', [
                'todoId' => $todoId,
                'formError' => 'あなたが指定したユーザーは既に担当に抜擢されています。',
            ]));
        }
    }
}

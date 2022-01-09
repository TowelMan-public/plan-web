<?php

namespace App\Http\Controllers;

use App\Client\Exception\AlreadyJoinedPublicProjectException;
use App\Client\Exception\BadRequestException;
use App\Client\Exception\NotFoundValueException;
use App\Http\Requests\DeleteSubscriberRequest;
use App\Http\Requests\InvitationRequest;
use App\Http\Requests\UpdateSubscriberRequest;
use App\Service\ProjectService;
use App\Service\SubscriberService;
use Facade\FlareClient\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private SubscriberService $subscriberService;
    private ProjectService $projectServer;

    /**
     * コンストラクタ
     */
    public function __construct()
    {
        $this->projectServer = ProjectService::getInstance();
        $this->subscriberService = SubscriberService::getInstance();
    }

    public function show(Request $request, int $projectId)
    {
        $mySubscriberData = $this->subscriberService->getMySubscriberData($this->getOauthToken(), $projectId);
        $subscriberDataArray = $this->subscriberService->getSubscriberDataArray($this->getOauthToken(), $projectId);
        $projectData = $this->projectServer->getProjectDataByPublicProject($this->getOauthToken(), $projectId);

        session()->put('_old_input', $request->old());

        return View('subscriber_layout')
            ->with('mySubscriberData', $mySubscriberData)
            ->with('subscriberDataArray', $subscriberDataArray)
            ->with('projectData', $projectData)
            ->with('exitError', $request->exitError)
            ->with('invitationFormError', $request->invitationFormError);
    }

    public function invitation(InvitationRequest $request, int $projectId)
    {
        try{
            $this->subscriberService->invitationUser($this->getOauthToken(), $projectId, $request->userName);
            return redirect(route('SubscriberController@show', [
                'projectId' => $projectId,
            ]));
        }
        catch(AlreadyJoinedPublicProjectException){
            session()->put('_old_input', $request->all());
            return redirect(route('SubscriberController@show', [
                'invitationFormError' => 'あなたが選んだユーザーは既に勧誘されてるか加入しています。',
                'projectId' => $projectId,
            ]));
        }
        catch(NotFoundValueException){
            session()->put('_old_input', $request->all());
            return redirect(route('SubscriberController@show', [
                'invitationFormError' => 'あなたが選んだユーザーは存在しません。',
                'projectId' => $projectId,
            ]));
        }
    }

    public function update(UpdateSubscriberRequest $request, int $projectId)
    {
        $this->subscriberService->updateSubscriber($this->getOauthToken(), $projectId, $request->userName, $request->authorityId);
        return;
    }

    public function delete(DeleteSubscriberRequest $request, int $projectId)
    {
        $this->subscriberService->deleteSubscriber($this->getOauthToken(), $projectId, $request->userName);
        return;
    }

    public function exit(int $projectId)
    {
        try{
            $this->subscriberService->exitProject($this->getOauthToken(), $projectId);
            return redirect()->action([ProjectController::class, 'showDefaultList']);
        }
        catch(BadRequestException){
            return redirect(route('SubscriberController@show', [
                'exitError' => 1,
                'projectId' => $projectId,
            ]));
        }
    }
}

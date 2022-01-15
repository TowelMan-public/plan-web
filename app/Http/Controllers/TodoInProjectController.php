<?php

namespace App\Http\Controllers;

use App\Client\Exception\BadRequestException;
use App\Client\Exception\NotHaveAuthorityToOperateProjectException;
use App\Http\Requests\InsertTodoOnProjectRequest;
use App\Service\ContentService;
use App\Service\ProjectService;
use App\Service\SubscriberService;
use App\Service\TodoService;
use App\Utility\DateUtility;
use DateTime;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;

class TodoInProjectController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private ProjectService $projectServer;
    private SubscriberService $subscriberService;
    private TodoService $todoService;
    private ContentService $contentService;


    /**
     * コンストラクタ
     */
    public function __construct()
    {
        $this->projectServer = ProjectService::getInstance();
        $this->subscriberService = SubscriberService::getInstance();
        $this->todoService = TodoService::getInstance();
        $this->contentService = ContentService::getInstance();
    }

    public function showDefaultTodoInPrivateProjectInDay(Request $request, int $projectId)
    {
        $nowDateArray = DateUtility::getDateAssociativeArrayByDateTime(new DateTime());

        return redirect(route('TodoInProjectController@showTodoInPrivateProjectInDay', $request->all() + [
            'year' => $nowDateArray[DateUtility::YEAR],
            'month' => $nowDateArray[DateUtility::MONTH],
            'day' => $nowDateArray[DateUtility::DAY],
            'projectId' => $projectId,
        ]));
    }

    public function showTodoInPrivateProjectInDay(Request $request, int $projectId, int $year, int $month, int $day)
    {
        $isToday = false;
        $date = DateUtility::createDate($year, $month, $day, 0, 0);
        $nowDate = new DateTime();
        $nowDateArray = DateUtility::getDateAssociativeArrayByDateTime($nowDate);
        $dateArray = DateUtility::getDateAssociativeArrayByDateTime($date);
        $finishDate = DateUtility::getNextDaysTopDateTime($date);

        if (
            $dateArray[DateUtility::YEAR] === $nowDateArray[DateUtility::YEAR] &&
            $dateArray[DateUtility::MONTH] === $nowDateArray[DateUtility::MONTH] &&
            $dateArray[DateUtility::DAY] === $nowDateArray[DateUtility::DAY]
        ) {
            $isToday = true;
            $date = $nowDate;

            $after5HourDate = DateUtility::addDate($nowDate, [
                DateUtility::HOUR => 5
            ]);

            if (DateUtility::getNextDaysTopDateTime($date)->getTimestamp() < $after5HourDate->getTimestamp())
                $finishDate = $after5HourDate;
        }

        $projectData = $this->projectServer->getProjectDataByPrivateProject($this->getOauthToken(), $projectId);
        $todoInDay = $this->todoService->getTodoInProjectInDayData($this->getOauthToken(), $projectId, $nowDate, $finishDate, $request->includeCompleted !== null);
        if (!$isToday)
            $todoInDay->setExpiredTodoList([]);

        return View('todo_in_day_layout')
            ->with('todoInDay', $todoInDay)
            ->with('includeCompleted', $request->includeCompleted)
            ->with('projectData', $projectData)
            ->with('mySubscriberData', null)
            ->with('dateAssociativeArray', $dateArray);
    }

    public function showTodoInPrivateProjectInDayNext(Request $request, int $projectId, int $year, int $month, int $day)
    {
        $dateArray = DateUtility::getDateAssociativeArrayByDateTime(
            DateUtility::addDate(
                DateUtility::createDate($year, $month, $day, 0, 0),
                [DateUtility::DAY => 1]
            )
        );

        return redirect(route('TodoInProjectController@showTodoInPrivateProjectInDay', $request->all() + [
            'year' => $dateArray[DateUtility::YEAR],
            'month' => $dateArray[DateUtility::MONTH],
            'day' => $dateArray[DateUtility::DAY],
            'projectId' => $projectId,
        ]));
    }

    public function showTodoInPrivateProjectInDayBack(Request $request, int $projectId, int $year, int $month, int $day)
    {
        $dateArray = DateUtility::getDateAssociativeArrayByDateTime(
            DateUtility::addDate(
                DateUtility::createDate($year, $month, $day, 0, 0),
                [DateUtility::DAY => -1]
            )
        );

        return redirect(route('TodoInProjectController@showTodoInPrivateProjectInDay', $request->all() + [
            'year' => $dateArray[DateUtility::YEAR],
            'month' => $dateArray[DateUtility::MONTH],
            'day' => $dateArray[DateUtility::DAY],
            'projectId' => $projectId,
        ]));
    }

    public function showDefaultTodoInPrivateProjectInMonth(Request $request, int $projectId)
    {
        $nowDateArray = DateUtility::getDateAssociativeArrayByDateTime(new DateTime());

        return redirect(route('TodoInProjectController@showTodoInPrivateProjectInMonth', $request->all() + [
            'year' => $nowDateArray[DateUtility::YEAR],
            'month' => $nowDateArray[DateUtility::MONTH],
            'projectId' => $projectId,
        ]));
    }

    public function showTodoInPrivateProjectInMonth(Request $request, int $projectId, int $year, int $month)
    {
        $projectData = $this->projectServer->getProjectDataByPrivateProject($this->getOauthToken(), $projectId);
        $todoInMonth = $this->todoService->getTodoInProjectInMonthData($this->getOauthToken(), $projectId, $year, $month, $request->includeCompleted !== null);

        return View('todo_in_month_layout')
            ->with('todoInMonth', $todoInMonth)
            ->with('includeCompleted', $request->includeCompleted)
            ->with('projectData', $projectData)
            ->with('mySubscriberData', null)
            ->with(
                'dateAssociativeArray',
                DateUtility::getDateAssociativeArrayByDateTime(
                    DateUtility::createDate($year, $month, 1, 1, 1)
                )
            );
    }

    public function showTodoInPrivateProjectInMonthNext(Request $request, int $projectId, int $year, int $month)
    {
        $dateArray = DateUtility::getDateAssociativeArrayByDateTime(
            DateUtility::addDate(
                DateUtility::createDate($year, $month, 1, 0, 0),
                [DateUtility::MONTH => 1]
            )
        );

        return redirect(route('TodoInProjectController@showTodoInPrivateProjectInMonth', $request->all() + [
            'year' => $dateArray[DateUtility::YEAR],
            'month' => $dateArray[DateUtility::MONTH],
            'projectId' => $projectId,
        ]));
    }

    public function showTodoInPrivateProjectInMonthBack(Request $request, int $projectId, int $year, int $month)
    {
        $dateArray = DateUtility::getDateAssociativeArrayByDateTime(
            DateUtility::addDate(
                DateUtility::createDate($year, $month, 1, 0, 0),
                [DateUtility::MONTH => -1]
            )
        );

        return redirect(route('TodoInProjectController@showTodoInPrivateProjectInMonth', $request->all() + [
            'year' => $dateArray[DateUtility::YEAR],
            'month' => $dateArray[DateUtility::MONTH],
            'projectId' => $projectId,
        ]));
    }

    public function showDefaultTodoInPublicProjectInDay(Request $request, int $projectId)
    {
        $nowDateArray = DateUtility::getDateAssociativeArrayByDateTime(new DateTime());

        return redirect(route('TodoInProjectController@showTodoInPublicProjectInDay', $request->all() + [
            'year' => $nowDateArray[DateUtility::YEAR],
            'month' => $nowDateArray[DateUtility::MONTH],
            'day' => $nowDateArray[DateUtility::DAY],
            'projectId' => $projectId,
        ]));
    }

    public function showTodoInPublicProjectInDay(Request $request, int $projectId, int $year, int $month, int $day)
    {
        $isToday = false;
        $date = DateUtility::createDate($year, $month, $day, 0, 0);
        $nowDate = new DateTime();
        $nowDateArray = DateUtility::getDateAssociativeArrayByDateTime($nowDate);
        $dateArray = DateUtility::getDateAssociativeArrayByDateTime($date);
        $finishDate = DateUtility::getNextDaysTopDateTime($date);

        if (
            $dateArray[DateUtility::YEAR] === $nowDateArray[DateUtility::YEAR] &&
            $dateArray[DateUtility::MONTH] === $nowDateArray[DateUtility::MONTH] &&
            $dateArray[DateUtility::DAY] === $nowDateArray[DateUtility::DAY]
        ) {
            $isToday = true;
            $date = $nowDate;

            $after5HourDate = DateUtility::addDate($nowDate, [
                DateUtility::HOUR => 5
            ]);

            if (DateUtility::getNextDaysTopDateTime($date)->getTimestamp() < $after5HourDate->getTimestamp())
                $finishDate = $after5HourDate;
        }

        $projectData = $this->projectServer->getProjectDataByPublicProject($this->getOauthToken(), $projectId);
        $mySubscriber = $this->subscriberService->getMySubscriberData($this->getOauthToken(), $projectId);
        $todoInDay = $this->todoService->getTodoInProjectInDayData($this->getOauthToken(), $projectId, $nowDate, $finishDate, $request->includeCompleted !== null);

        if (!$isToday)
            $todoInDay->setExpiredTodoList([]);

        return View('todo_in_day_layout')
            ->with('todoInDay', $todoInDay)
            ->with('includeCompleted', $request->includeCompleted)
            ->with('projectData', $projectData)
            ->with('mySubscriberData', $mySubscriber)
            ->with('dateAssociativeArray', $dateArray);
    }

    public function showTodoInPublicProjectInDayNext(Request $request, int $projectId, int $year, int $month, int $day)
    {
        $dateArray = DateUtility::getDateAssociativeArrayByDateTime(
            DateUtility::addDate(
                DateUtility::createDate($year, $month, $day, 0, 0),
                [DateUtility::DAY => 1]
            )
        );

        return redirect(route('TodoInProjectController@showTodoInPublicProjectInDay', $request->all() + [
            'year' => $dateArray[DateUtility::YEAR],
            'month' => $dateArray[DateUtility::MONTH],
            'day' => $dateArray[DateUtility::DAY],
            'projectId' => $projectId,
        ]));
    }

    public function showTodoInPublicProjectInDayBack(Request $request, int $projectId, int $year, int $month, int $day)
    {
        $dateArray = DateUtility::getDateAssociativeArrayByDateTime(
            DateUtility::addDate(
                DateUtility::createDate($year, $month, $day, 0, 0),
                [DateUtility::DAY => -1]
            )
        );

        return redirect(route('TodoInProjectController@showTodoInPublicProjectInDay', $request->all() + [
            'year' => $dateArray[DateUtility::YEAR],
            'month' => $dateArray[DateUtility::MONTH],
            'day' => $dateArray[DateUtility::DAY],
            'projectId' => $projectId,
        ]));
    }

    public function showDefaultTodoPublicProjectInMonth(Request $request, int $projectId)
    {
        $nowDateArray = DateUtility::getDateAssociativeArrayByDateTime(new DateTime());

        return redirect(route('TodoInProjectController@showTodoInPublicProjectInMonth', $request->all() + [
            'year' => $nowDateArray[DateUtility::YEAR],
            'month' => $nowDateArray[DateUtility::MONTH],
            'projectId' => $projectId,
        ]));
    }

    public function showTodoInPublicProjectInMonth(Request $request, int $projectId, int $year, int $month)
    {
        $projectData = $this->projectServer->getProjectDataByPublicProject($this->getOauthToken(), $projectId);
        $todoInMonth = $this->todoService->getTodoInProjectInMonthData($this->getOauthToken(), $projectId, $year, $month, $request->includeCompleted !== null);
        $mySubscriber = $this->subscriberService->getMySubscriberData($this->getOauthToken(), $projectId);

        return View('todo_in_month_layout')
            ->with('todoInMonth', $todoInMonth)
            ->with('includeCompleted', $request->includeCompleted)
            ->with('projectData', $projectData)
            ->with('mySubscriberData', $mySubscriber)
            ->with(
                'dateAssociativeArray',
                DateUtility::getDateAssociativeArrayByDateTime(
                    DateUtility::createDate($year, $month, 1, 1, 1)
                )
            );
    }

    public function showTodoInPublicProjectInMonthNext(Request $request, int $projectId, int $year, int $month)
    {
        $dateArray = DateUtility::getDateAssociativeArrayByDateTime(
            DateUtility::addDate(
                DateUtility::createDate($year, $month, 1, 0, 0),
                [DateUtility::MONTH => 1]
            )
        );

        return redirect(route('TodoInProjectController@showTodoInPublicProjectInMonth', $request->all() + [
            'year' => $dateArray[DateUtility::YEAR],
            'month' => $dateArray[DateUtility::MONTH],
            'projectId' => $projectId,
        ]));
    }

    public function showTodoInPublicProjectInMonthBack(Request $request, int $projectId, int $year, int $month)
    {
        $dateArray = DateUtility::getDateAssociativeArrayByDateTime(
            DateUtility::addDate(
                DateUtility::createDate($year, $month, 1, 0, 0),
                [DateUtility::MONTH => -1]
            )
        );

        return redirect(route('TodoInProjectController@showTodoInPublicProjectInMonth', $request->all() + [
            'year' => $dateArray[DateUtility::YEAR],
            'month' => $dateArray[DateUtility::MONTH],
            'projectId' => $projectId,
        ]));
    }

    public function showDefaultResponsibleTodoInPublicProjectInDay(Request $request, int $projectId)
    {
        $nowDateArray = DateUtility::getDateAssociativeArrayByDateTime(new DateTime());

        return redirect(route('TodoInProjectController@showResponsibleTodoInPublicProjectInDay', $request->all() + [
            'year' => $nowDateArray[DateUtility::YEAR],
            'month' => $nowDateArray[DateUtility::MONTH],
            'day' => $nowDateArray[DateUtility::DAY],
            'projectId' => $projectId,
        ]));
    }

    public function showResponsibleTodoInPublicProjectInDay(Request $request, int $projectId, int $year, int $month, int $day)
    {
        $isToday = false;
        $date = DateUtility::createDate($year, $month, $day, 0, 0);
        $nowDate = new DateTime();
        $nowDateArray = DateUtility::getDateAssociativeArrayByDateTime($nowDate);
        $dateArray = DateUtility::getDateAssociativeArrayByDateTime($date);
        $finishDate = DateUtility::getNextDaysTopDateTime($date);

        if (
            $dateArray[DateUtility::YEAR] === $nowDateArray[DateUtility::YEAR] &&
            $dateArray[DateUtility::MONTH] === $nowDateArray[DateUtility::MONTH] &&
            $dateArray[DateUtility::DAY] === $nowDateArray[DateUtility::DAY]
        ) {
            $isToday = true;
            $date = $nowDate;

            $after5HourDate = DateUtility::addDate($nowDate, [
                DateUtility::HOUR => 5
            ]);

            if (DateUtility::getNextDaysTopDateTime($date)->getTimestamp() < $after5HourDate->getTimestamp())
                $finishDate = $after5HourDate;
        }

        $projectData = $this->projectServer->getProjectDataByPublicProject($this->getOauthToken(), $projectId);
        $todoInDay = $this->todoService->getResponsibleTodoInProjectInDayData($this->getOauthToken(), $projectId, $nowDate, $finishDate, $request->includeCompleted !== null);
        if (!$isToday)
            $todoInDay->setExpiredTodoList([]);

        return View('todo_in_day_layout')
            ->with('todoInDay', $todoInDay)
            ->with('includeCompleted', $request->includeCompleted)
            ->with('projectData', $projectData)
            ->with('mySubscriberData', null)
            ->with('dateAssociativeArray', $dateArray);
    }

    public function showResponsibleTodoInPublicProjectInDayNext(Request $request, int $projectId, int $year, int $month, int $day)
    {
        $dateArray = DateUtility::getDateAssociativeArrayByDateTime(
            DateUtility::addDate(
                DateUtility::createDate($year, $month, $day, 0, 0),
                [DateUtility::DAY => 1]
            )
        );

        return redirect(route('TodoInProjectController@showResponsibleTodoInPublicProjectInDay', $request->all() + [
            'year' => $dateArray[DateUtility::YEAR],
            'month' => $dateArray[DateUtility::MONTH],
            'day' => $dateArray[DateUtility::DAY],
            'projectId' => $projectId,
        ]));
    }

    public function showResponsibleTodoInPublicProjectInDayBack(Request $request, int $projectId, int $year, int $month, int $day)
    {
        $dateArray = DateUtility::getDateAssociativeArrayByDateTime(
            DateUtility::addDate(
                DateUtility::createDate($year, $month, $day, 0, 0),
                [DateUtility::DAY => -1]
            )
        );

        return redirect(route('TodoInProjectController@showResponsibleTodoInPublicProjectInDay', $request->all() + [
            'year' => $dateArray[DateUtility::YEAR],
            'month' => $dateArray[DateUtility::MONTH],
            'day' => $dateArray[DateUtility::DAY],
            'projectId' => $projectId,
        ]));
    }

    public function showResponsibleTodaulPublicPrivateProjectInMonth(Request $request, int $projectId)
    {
        $nowDateArray = DateUtility::getDateAssociativeArrayByDateTime(new DateTime());

        return redirect(route('TodoInProjectController@showResponsibleTodoInPublicProjectInMonth', $request->all() + [
            'year' => $nowDateArray[DateUtility::YEAR],
            'month' => $nowDateArray[DateUtility::MONTH],
            'projectId' => $projectId,
        ]));
    }

    public function showResponsibleTodoInPublicProjectInMonth(Request $request, int $projectId, int $year, int $month)
    {
        $projectData = $this->projectServer->getProjectDataByPrivateProject($this->getOauthToken(), $projectId);
        $todoInMonth = $this->todoService->getResponsibleTodoInProjectInMonthData($this->getOauthToken(), $projectId, $year, $month, $request->includeCompleted !== null);

        $projectData = $this->projectServer->getProjectDataByPrivateProject($this->getOauthToken(), $projectId);
        $mySubscriber = $this->subscriberService->getMySubscriberData($this->getOauthToken(), $projectId);

        return View('todo_in_month_layout')
            ->with('todoInMonth', $todoInMonth)
            ->with('includeCompleted', $request->includeCompleted)
            ->with('projectData', $projectData)
            ->with('mySubscriberData', $mySubscriber)
            ->with(
                'dateAssociativeArray',
                DateUtility::getDateAssociativeArrayByDateTime(
                    DateUtility::createDate($year, $month, 1, 1, 1)
                )
            );
    }

    public function showResponsibleTodoInPublicProjectInMonthNext(Request $request, int $projectId, int $year, int $month)
    {
        $dateArray = DateUtility::getDateAssociativeArrayByDateTime(
            DateUtility::addDate(
                DateUtility::createDate($year, $month, 1, 0, 0),
                [DateUtility::MONTH => 1]
            )
        );

        return redirect(route('TodoInProjectController@showResponsibleTodoInPublicProjectInMonth', $request->all() + [
            'year' => $dateArray[DateUtility::YEAR],
            'month' => $dateArray[DateUtility::MONTH],
            'projectId' => $projectId,
        ]));
    }

    public function showResponsibleTodoInPublicProjectInMonthBack(Request $request, int $projectId, int $year, int $month)
    {
        $dateArray = DateUtility::getDateAssociativeArrayByDateTime(
            DateUtility::addDate(
                DateUtility::createDate($year, $month, 1, 0, 0),
                [DateUtility::MONTH => -1]
            )
        );

        return redirect(route('TodoInProjectController@showResponsibleTodoInPublicProjectInMonth', $request->all() + [
            'year' => $dateArray[DateUtility::YEAR],
            'month' => $dateArray[DateUtility::MONTH],
            'projectId' => $projectId,
        ]));
    }

    public function showInsertTodoToPrivateProject(Request $request, int $projectId)
    {
        $projectData = $this->projectServer->getProjectDataByPrivateProject($this->getOauthToken(), $projectId);
        
        session()->put('_old_input', $request->old());
        return View('insert_todo_on_project_layout')
            ->with('formError', $request->formError)
            ->with('projectData', $projectData);
    }

    public function insertTodoToPrivateProject(InsertTodoOnProjectRequest $request, int $projectId)
    {
        try{
            $todoId = $this->todoService->insertTodoOnProject($this->getOauthToken(), $projectId, $request->todoName,
                $request->startDate, $request->finishData, $request->isCopyToResponsible !== null);
            $this->contentService->insertContentArray($this->getOauthToken(), $todoId, $request->contentArray);
            
            return redirect(route('TodoInProjectController@showInsertTodoToPrivateProject',[
                'projectId' => $projectId,
            ]));
        }
        catch(NotHaveAuthorityToOperateProjectException){
            return redirect(route('TodoInProjectController@showInsertTodoToPrivateProject',[
                'projectId' => $projectId,
                'formError' => 'あなたにはやることをこのプロジェクトに作成する権限がありません。',
            ]));
        }
        catch(BadRequestException){
            return redirect(route('TodoInProjectController@showInsertTodoToPrivateProject',[
                'projectId' => $projectId,
                'formError' => '指定されている開始日時と終了日時が不正だと思われます。プロジェクトの期間をご確認のうえ、期間内に設定してください。',
            ]));
        }
    }

    public function showInsertTodoToPublicProject(Request $request, int $projectId)
    {
        $projectData = $this->projectServer->getProjectDataByPublicProject($this->getOauthToken(), $projectId);
        
        session()->put('_old_input', $request->old());
        return View('insert_todo_on_project_layout')
            ->with('formError', $request->formError)
            ->with('projectData', $projectData);
    }

    public function insertTodoToPublicProject(InsertTodoOnProjectRequest $request, int $projectId)
    {
        try{
            $todoId = $this->todoService->insertTodoOnProject($this->getOauthToken(), $projectId, $request->todoName,
                $request->startDate, $request->finishData, $request->isCopyToResponsible !== null);
            $this->contentService->insertContentArray($this->getOauthToken(), $todoId, $request->contentArray);
            
            return redirect(route('TodoOnProjectController@show',[
                'todoId' => $todoId,
            ]));
        }
        catch(NotHaveAuthorityToOperateProjectException){
            return redirect(route('TodoInProjectController@showInsertTodoToPublicProject',[
                'projectId' => $projectId,
                'formError' => 'あなたにはやることをこのプロジェクトに作成する権限がありません。',
            ]));
        }
        catch(BadRequestException){
            return redirect(route('TodoInProjectController@showInsertTodoToPublicProject',[
                'projectId' => $projectId,
                'formError' => '指定されている開始日時と終了日時が不正だと思われます。プロジェクトの期間をご確認のうえ、期間内に設定してください。',
            ]));
        }
    }
}

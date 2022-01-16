<?php

namespace App\Http\Controllers;

use App\Service\NoticeService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

class NoticeController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private NoticeService $noticeService;

    /**
     * コンストラクタ
     */
    public function __construct()
    {
        $this->noticeService = NoticeService::getInstance();
    }

    public function show()
    {
        $noticeDataArray = $this->noticeService->getNoticeDataArray($this->getOauthToken());

        if(count($noticeDataArray) === 0){
            return '';
        }else{
            return View('notice_layout')
                ->with('noticeDataArray', $noticeDataArray);
        }
    }
}

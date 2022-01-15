<?php

namespace App\Http\Controllers;

use App\Http\Requests\InsertContentRequest;
use App\Http\Requests\SetIsCompletedRequest;
use App\Http\Requests\UpdateContentRequest;
use App\Service\ContentService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

class ContentController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private ContentService $contentService;

    /**
     * コンストラクタ
     */
    public function __construct()
    {
        $this->contentService = ContentService::getInstance();
    }

    public function insert(InsertContentRequest $request)
    {
        $contentId = $this->contentService->insertContent($this->getOauthToken(), $request->todoId, $request->title, $request->explanation);
        return ['contentId' => $contentId];
    }

    public function update(UpdateContentRequest $request, int $contentId)
    {
        $this->contentService->updateContent($this->getOauthToken(), $contentId, $request->title, $request->explanation);
    }

    public function delete(int $contentId)
    {
        $this->contentService->deleteContent($this->getOauthToken(), $contentId);
    }

    public function setIsCompleted(SetIsCompletedRequest $request, int $contentId)
    {
        $this->contentService->setIsCompletedToContent($this->getOauthToken(), $contentId, $request->isCompleted);
    }
}

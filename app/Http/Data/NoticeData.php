<?php

namespace App\Http\Data;

class NoticeData
{
    private const TODO_NOTICE = "TODO_NOTICE";
    private const PROJECT_NOTICE = "PROJECT_NOTICE";

    private string $noticeType;

    private string $message;

    private string $link;

    public function isTodoNotice()
    {
        return $this->noticeType === self::TODO_NOTICE;
    }

    public function isProjectNotice()
    {
        return $this->noticeType === self::PROJECT_NOTICE;
    }

    /**
     * linkのセット
     * 
     * @param string $link
     * @return void
     */
    public function setLink(string $link)
    {
        $this->link = $link;
    }

    /**
     * linkの取得
     * 
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * messageのセット
     * 
     * @param string $message
     * @return void
     */
    public function setMessage(string $message)
    {
        $this->message = $message;
    }

    /**
     * messageの取得
     * 
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * noticeTypeのセット
     * 
     * @param string $noticeType
     * @return void
     */
    public function setNoticeType(string $noticeType)
    {
        $this->noticeType = $noticeType;
    }

    /**
     * noticeTypeの取得
     * 
     * @return string
     */
    public function getNoticeType(): string
    {
        return $this->noticeType;
    }
}

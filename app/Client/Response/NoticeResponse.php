<?php

namespace App\Client\Response;

class NoticeResponse 
{
    private const TODO_NOTICE = "TODO_NOTICE";
    private const PROJECT_NOTICE = "PROJECT_NOTICE";

    private string $message;
    private int $noticeId;
    private string $noticeType;
    
    /**
     * NoticeResponse単体を生成する
     * 
     * @param array $arrayData UserResponseの連想配列の配列もしくは連想配列
     * @return NoticeResponse
     */
    public static function parseNoticeResponse(array $arrayData): NoticeResponse
    {
        $singleArrayDate = $arrayData;

        $entity = new NoticeResponse();
        $entity->setMessage($singleArrayDate['message']);
        $entity->setNoticeId($singleArrayDate['id']);
        $entity->setNoticeType($singleArrayDate['noticeType']);

        return $entity;
    }

    /**
     * NoticeResponseの配列を生成する
     * 
     * @param array $arrayData UserResponseの連想配列の配列
     * @return array ${1:ClassName}の配列
     */
    public static function parseNoticeResponseArray(array $arrayData): array
    {
        $entityArray = array();
        foreach($arrayData as $valueArray)
            $entityArray[] = self::parseNoticeResponse($valueArray);

        return $entityArray;
    }
    
    /**
     * 「やること」に関する通知であるかどうか
     *
     * @return boolean 
     */
    public function isTodoNotice(): bool
    {
        return $this->noticeType === self::TODO_NOTICE;
    }

    /**
     * プロジェクトに関する通知であるかどうか
     *
     * @return boolean
     */
    public function isProjectNotice(): bool
    {
        return $this->noticeType === self::PROJECT_NOTICE;
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
    
    /**
     * noticeIdのセット
     *
     * @param int $noticeId
     * @return void
     */
    public function setNoticeId(int $noticeId)
    {
        $this->noticeId = $noticeId;
    }
    
    /**
     * noticeIdの取得
     *
     * @return int
     */
    public function getNoticeId(): int
    {
        return $this->noticeId;
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
}
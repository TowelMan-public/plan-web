<?php

namespace App\Client\Response;

class ContentResponse 
{
    
    private int $contentId;
    private int $todoId;
    private string $contentTitle;
    private string $contentExplanation;
    private bool $isCompleted;
    
    /**
     * ContentResponse単体を生成する
     * 
     * @param array $arrayData UserResponseの連想配列の配列もしくは連想配列
     * @return ContentResponse
     */
    public static function parseContentResponse(array $arrayData): ContentResponse
    {
        $singleArrayDate = $arrayData;

        $entity = new ContentResponse();
        $entity->setContentId($singleArrayDate['contentId']);
        $entity->setTodoId($singleArrayDate['todoId']);
        $entity->setContentTitle($singleArrayDate['contentTitle']);
        $entity->setContentExplanation($singleArrayDate['contentExplanation']);
        $entity->setIsCompleted($singleArrayDate['isCompleted']);

        return $entity;
    }

    /**
     * ContentResponseの配列を生成する
     * 
     * @param array $arrayData UserResponseの連想配列の配列
     * @return array ${1:ClassName}の配列
     */
    public static function parseContentResponseArray(array|string $arrayData): array
    {
        $entityArray = array();
        foreach($arrayData as $valueArray)
            $entityArray[] = self::parseContentResponse($valueArray);

        return $entityArray;
    }
    
    /**
     * isCompletedのセット
     *
     * @param bool $isCompleted
     * @return void
     */
    public function setIsCompleted(bool $isCompleted)
    {
        $this->isCompleted = $isCompleted;
    }
    
    /**
     * isCompletedの取得
     *
     * @return bool
     */
    public function getIsCompleted(): bool
    {
        return $this->isCompleted;
    }
    
    /**
     * contentExplanationのセット
     *
     * @param string $contentExplanation
     * @return void
     */
    public function setContentExplanation(string $contentExplanation)
    {
        $this->contentExplanation = $contentExplanation;
    }
    
    /**
     * contentExplanationの取得
     *
     * @return string
     */
    public function getContentExplanation(): string
    {
        return $this->contentExplanation;
    }
    
    /**
     * contentTitleのセット
     *
     * @param string $contentTitle
     * @return void
     */
    public function setContentTitle(string $contentTitle)
    {
        $this->contentTitle = $contentTitle;
    }
    
    /**
     * contentTitleの取得
     *
     * @return string
     */
    public function getContentTitle(): string
    {
        return $this->contentTitle;
    }
    
    /**
     * todoIdのセット
     *
     * @param int $todoId
     * @return void
     */
    public function setTodoId(int $todoId)
    {
        $this->todoId = $todoId;
    }
    
    /**
     * todoIdの取得
     *
     * @return int
     */
    public function getTodoId(): int
    {
        return $this->todoId;
    }
    
    /**
     * contentIdのセット
     *
     * @param int $contentId
     * @return void
     */
    public function setContentId(int $contentId)
    {
        $this->contentId = $contentId;
    }
    
    /**
     * contentIdの取得
     *
     * @return int
     */
    public function getContentId(): int
    {
        return $this->contentId;
    }
}
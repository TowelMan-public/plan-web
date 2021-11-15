<?php

use Symfony\Component\VarDumper\Cloner\Data;

/**
 * リクエストパラメターを扱うクラス
 */
class DtoParamaters
{
    private array $paramaters = array();

    public function setTodoId(int $todoId)
    {
        $this->paramaters['todoId'] = (string)$todoId;
    }
    
    public function setTodoOnProjectId(int $todoOnProjectId)
    {
        $this->paramaters['todoOnProjectId'] = (string)$todoOnProjectId;
    }

    public function setContentTitle(string $contentTitle)
    {
        $this->paramaters['contentTitle'] = $contentTitle;
    }

    public function setContentExplanation(string $contentExplanation)
    {
        $this->paramaters['contentExplanation'] = $contentExplanation;
    }

    public function setIsCompleted(bool $isCompleted)
    {
        $this->paramaters['isCompleted'] = $isCompleted;
    }

    public function setTerminalName(string $terminalName)
    {
        $this->paramaters['terminalName'] = $terminalName;
    }

    public function setProjectName(string $projectName)
    {
        $this->paramaters['projectName'] = $projectName;
    }

    public function setFinishDate(Data $finishDate)
    {
        $this->paramaters['finishDate'] = $finishDate;
    }

    public function setStartDate(Data $startDate)
    {
        $this->paramaters['startDate'] = (string)$startDate;
    }

    public function setPublicProjectId(int $publicProjectId)
    {
        $this->paramaters['publicProjectId'] = (string)$publicProjectId;
    }

    public function setUserName(string $userName)
    {
        $this->paramaters['userName'] = $userName;
    }

    public function setIsInclideCompletedTodo(bool $isInclideCompletedTodo)
    {
        $this->paramaters['isInclideCompletedTodo'] = (string)$isInclideCompletedTodo;
    }

    public function setAuthorityId(int $authorityId)
    {
        $this->paramaters['authorityId'] = (string)$authorityId;
    }

    public function setTodoName(String $todoName)
    {
        $this->paramaters['todoName'] = $todoName;
    }

    public function setIsCopyContentsToResponsible(bool $isCopyContentsToResponsible)
    {
        $this->paramaters['isCopyContentsToResponsible'] = (string)$isCopyContentsToResponsible;
    }

    public function setIsInPrivateProjectOnly(bool $isInPrivateProjectOnly)
    {
        $this->paramaters['isInPrivateProjectOnly'] = (string)$isInPrivateProjectOnly;
    }

    public function setBeforeDeadlineForTodoNotice(int $beforeDeadlineForTodoNotice)
    {
        $this->paramaters['beforeDeadlineForTodoNotice'] = (string)$beforeDeadlineForTodoNotice;
    }

    public function setBeforeDeadlineForProjectNotice(int $beforeDeadlineForProjectNotice)
    {
        $this->paramaters['beforeDeadlineForProjectNotice'] = (string)$beforeDeadlineForProjectNotice;
    }

    public function setPushInsertedTodoNotice(bool $pushInsertedTodoNotice)
    {
        $this->paramaters['pushInsertedTodoNotice'] = (string)$pushInsertedTodoNotice;
    }

    public function setIsPushSatrtedTodoNotice(bool $isPushSatrtedTodoNotice)
    {
        $this->paramaters['isPushSatrtedTodoNotice'] = (string)$isPushSatrtedTodoNotice;
    }

    public function setUserNickName(String $userNickName)
    {
        $this->paramaters['userNickName'] = $userNickName;
    }

    public function setPassword(String $password)
    {
        $this->paramaters['password'] = $password;
    }

    public function setRefreshJwtToken(String $refreshJwtToken)
    {
        $this->paramaters['refreshJwtToken'] = $refreshJwtToken;
    }

    public function setOldTerminalName(String $oldTerminalName)
    {
        $this->paramaters['oldTerminalName'] = $oldTerminalName;
    }

    public function setNewTerminalName(String $newTerminalName)
    {
        $this->paramaters['newTerminalName'] = $newTerminalName;
    }

    /**
     * リクエストパラメターを連想配列として出力する
     *
     * @return array リクエストパラメターの連想配列
     */
    public function toArray(): array{
        return array();
    }
}

?>
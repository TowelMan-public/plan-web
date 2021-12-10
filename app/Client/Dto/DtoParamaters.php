<?php

namespace App\Client\Dto;

use App\Utility\DateUtility;
use DateTime;

/**
 * リクエストパラメターを扱うクラス
 */
class DtoParamaters
{
    private array $paramaters = array();

    public function setProjectId(int $projectId)
    {
        if(!is_null($projectId)){
            $this->paramaters['projectId'] = (string)$projectId;
        }
    }

    /**
     * 「やること」のIDをセットする
     *
     * @param integer $todoId nullが指定されたら何もしない
     * @return void
     */
    public function setTodoId(int $todoId)
    {
        if(!is_null($todoId)){
            $this->paramaters['todoId'] = (string)$todoId;
        }
    }
    
    /**
     * プロジェクト向けの「やること」IDをセットする
     *
     * @param integer $todoOnProjectId nullが指定されたら何もしない
     * @return void
     */
    public function setTodoOnProjectId(int $todoOnProjectId)
    {
        if(!is_null($todoOnProjectId)){
            $this->paramaters['todoOnProjectId'] = (string)$todoOnProjectId;
        }
    }

    /**
     * 内容のタイトルをセットする
     *
     * @param string $contentTitle nullが指定されたら何もしない
     * @return void
     */
    public function setContentTitle(string $contentTitle)
    {
        if(!is_null($contentTitle)){
            $this->paramaters['contentTitle'] = $contentTitle;
        }
    }

    /**
     * 内容の説明をセットする
     *
     * @param string $contentExplanation nullが指定されたら何もしない
     * @return void
     */
    public function setContentExplanation(string $contentExplanation)
    {
        if(!is_null($contentExplanation)){
            $this->paramaters['contentExplanation'] = $contentExplanation;
        }
    }

    /**
     * 完了状況をセットする
     *
     * @param boolean $isCompleted nullが指定されたら何もしない
     * @return void
     */
    public function setIsCompleted(bool $isCompleted)
    {
        if(!is_null($isCompleted)){
            $this->paramaters['isCompleted'] = $isCompleted;
        }
    }

    /**
     * 機種名をセットする
     *
     * @param string $terminalName nullが指定されたら何もしない
     * @return void
     */
    public function setTerminalName(string $terminalName)
    {
        if(!is_null($terminalName)){
            $this->paramaters['terminalName'] = $terminalName;
        }
    }

    /**
     * プロジェクト名をセットする
     *
     * @param string $projectName nullが指定されたら何もしない
     * @return void
     */
    public function setProjectName(string $projectName)
    {
        if(!is_null($projectName)){
            $this->paramaters['projectName'] = $projectName;
        }
    }

    /**
     * 締め切り日時をセットする
     *
     * @param DateTime $finishDate nullが指定されたら何もしない
     * @return void
     */
    public function setFinishDate(DateTime $finishDate)
    {
        if(!is_null($finishDate)){
            $this->paramaters['finishDate'] = DateUtility::dateToString($finishDate);
        }
    }

    /**
     * 開始日時をセットする
     *
     * @param DateTime $startDate nullが指定されたら何もしない
     * @return void
     */
    public function setStartDate(DateTime $startDate)
    {
        if(!is_null($startDate)){
            $this->paramaters['startDate'] = DateUtility::dateToString($startDate);
        }
    }

    /**
     * パブリックプロジェクトIDをセットする
     *
     * @param integer $publicProjectId nullが指定されたら何もしない
     * @return void
     */
    public function setPublicProjectId(int $publicProjectId)
    {
        if(!is_null($publicProjectId)){
            $this->paramaters['publicProjectId'] = (string)$publicProjectId;
        }
    }

    /**
     * ユーザー名をセットする
     *
     * @param string $userName nullが指定されたら何もしない
     * @return void
     */
    public function setUserName(string $userName)
    {
        if(!is_null($userName)){
            $this->paramaters['userName'] = $userName;
        }
    }

    /**
     * 完了済み「やること」を含めるかをセットする
     *
     * @param boolean $isInclideCompletedTodo nullが指定されたら何もしない
     * @return void
     */
    public function setIsInclideCompletedTodo(bool $isInclideCompletedTodo)
    {
        if(!is_null($isInclideCompletedTodo)){
            $this->paramaters['isInclideCompletedTodo'] = (string)$isInclideCompletedTodo;
        }
    }

    /**
     * 権限IDをセットする
     *
     * @param integer $authorityId nullが指定されたら何もしない
     * @return void
     */
    public function setAuthorityId(int $authorityId)
    {
        if(!is_null($authorityId)){
            $this->paramaters['authorityId'] = (string)$authorityId;
        }
    }

    /**
     * 「やること」名をセットする
     *
     * @param String $todoName nullが指定されたら何もしない
     * @return void
     */
    public function setTodoName(String $todoName)
    {
        if(!is_null($todoName)){
            $this->paramaters['todoName'] = $todoName;
        }
    }

    /**
     * 担当者向け「やること」にも内容を引き継がせるかどうかをセットする
     *
     * @param boolean $isCopyContentsToResponsible nullが指定されたら何もしない
     * @return void
     */
    public function setIsCopyContentsToResponsible(bool $isCopyContentsToResponsible)
    {
        if(!is_null($isCopyContentsToResponsible)){
            $this->paramaters['isCopyContentsToResponsible'] = (string)$isCopyContentsToResponsible;
        }
    }

    /**
     * プライベートプロジェクトに限定して取得するかどうかをセットする
     *
     * @param boolean $isInPrivateProjectOnly nullが指定されたら何もしない
     * @return void
     */
    public function setIsInPrivateProjectOnly(bool $isInPrivateProjectOnly)
    {
        if(!is_null($isInPrivateProjectOnly)){
            $this->paramaters['isInPrivateProjectOnly'] = (string)$isInPrivateProjectOnly;
        }
    }

    /**
     * 「やること」の締め切り何秒以内になったら通知を生成するかをセットする
     *
     * @param integer $beforeDeadlineForTodoNotice nullが指定されたら何もしない
     * @return void
     */
    public function setBeforeDeadlineForTodoNotice(int $beforeDeadlineForTodoNotice)
    {
        if(!is_null($beforeDeadlineForTodoNotice)){
            $this->paramaters['beforeDeadlineForTodoNotice'] = (string)$beforeDeadlineForTodoNotice;
        }
    }

    /**
     *パブリックプロジェクトの締め切り何秒以内になったら通知を生成するかをセットする
     *
     * @param integer $beforeDeadlineForProjectNotice nullが指定されたら何もしない
     * @return void
     */
    public function setBeforeDeadlineForProjectNotice(int $beforeDeadlineForProjectNotice)
    {
        if(!is_null($beforeDeadlineForProjectNotice)){
            $this->paramaters['beforeDeadlineForProjectNotice'] = (string)$beforeDeadlineForProjectNotice;
        }
    }

    /**
     * 「やること」の担当者に選ばれたら通知を生成するかどうかをセットする
     *
     * @param boolean $pushInsertedTodoNotice nullが指定されたら何もしない
     * @return void
     */
    public function setPushInsertedTodoNotice(bool $pushInsertedTodoNotice)
    {
        if(!is_null($pushInsertedTodoNotice)){
            $this->paramaters['pushInsertedTodoNotice'] = (string)$pushInsertedTodoNotice;
        }
    }

    /**
     * 「やること」が始まったら通知を生成するかをセットする
     *
     * @param boolean $isPushSatrtedTodoNotice nullが指定されたら何もしない
     * @return void
     */
    public function setIsPushSatrtedTodoNotice(bool $isPushSatrtedTodoNotice)
    {
        if(!is_null($isPushSatrtedTodoNotice)){
            $this->paramaters['isPushSatrtedTodoNotice'] = (string)$isPushSatrtedTodoNotice;
        }
    }

    /**
     * ユーザーニックネームをセットする
     *
     * @param String $userNickName nullが指定されたら何もしない
     * @return void
     */
    public function setUserNickName(String $userNickName)
    {
        if(!is_null($userNickName)){
            $this->paramaters['userNickName'] = $userNickName;
        }
    }

    /**
     * パスワードをセットする
     *
     * @param String $password nullが指定されたら何もしない
     * @return void
     */
    public function setPassword(String $password)
    {
        if(!is_null($password)){
            $this->paramaters['password'] = $password;
        }
    }

    /**
     * リフレッシュトークンをセットする
     *
     * @param String $refreshJwtToken nullが指定されたら何もしない
     * @return void
     */
    public function setRefreshJwtToken(String $refreshJwtToken)
    {
        if(!is_null($refreshJwtToken)){
            $this->paramaters['refreshJwtToken'] = $refreshJwtToken;
        }
    }

    /**
     * 元の機種名を指定する
     *
     * @param String $oldTerminalName nullが指定されたら何もしない
     * @return void
     */
    public function setOldTerminalName(String $oldTerminalName)
    {
        if(!is_null($oldTerminalName)){
            $this->paramaters['oldTerminalName'] = $oldTerminalName;
        }
    }

    /**
     * 新しい機種名を指定する
     *
     * @param String $newTerminalName nullが指定されたら何もしない
     * @return void
     */
    public function setNewTerminalName(String $newTerminalName)
    {
        if(!is_null($newTerminalName)){
            $this->paramaters['newTerminalName'] = $newTerminalName;
        }
    }

    /**
     * リクエストパラメターを連想配列として出力する
     *
     * @return array リクエストパラメターの連想配列
     */
    public function toArray(): array{
        return $this->paramaters;
    }
}
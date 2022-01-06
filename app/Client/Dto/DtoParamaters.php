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

    public function setProjectId(int|null $projectId)
    {
        if(!is_null($projectId)){
            $this->paramaters['projectId'] = (string)$projectId;
        }
    }

    /**
     * 「やること」のIDをセットする
     *
     * @param integer|null $todoId nullが指定されたら何もしない
     * @return void
     */
    public function setTodoId(int|null $todoId)
    {
        if(!is_null($todoId)){
            $this->paramaters['todoId'] = (string)$todoId;
        }
    }
    
    /**
     * プロジェクト向けの「やること」IDをセットする
     *
     * @param integer|null $todoOnProjectId nullが指定されたら何もしない
     * @return void
     */
    public function setTodoOnProjectId(int|null $todoOnProjectId)
    {
        if(!is_null($todoOnProjectId)){
            $this->paramaters['todoOnProjectId'] = (string)$todoOnProjectId;
        }
    }

    /**
     * 内容のタイトルをセットする
     *
     * @param string|null $contentTitle nullが指定されたら何もしない
     * @return void
     */
    public function setContentTitle(string|null $contentTitle)
    {
        if(!is_null($contentTitle)){
            $this->paramaters['contentTitle'] = $contentTitle;
        }
    }

    /**
     * 内容の説明をセットする
     *
     * @param string|null $contentExplanation nullが指定されたら何もしない
     * @return void
     */
    public function setContentExplanation(string|null $contentExplanation)
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
     * @param string|null $terminalName nullが指定されたら何もしない
     * @return void
     */
    public function setTerminalName(string|null $terminalName)
    {
        if(!is_null($terminalName)){
            $this->paramaters['terminalName'] = $terminalName;
        }
    }

    /**
     * プロジェクト名をセットする
     *
     * @param string|null $projectName nullが指定されたら何もしない
     * @return void
     */
    public function setProjectName(string|null $projectName)
    {
        if(!is_null($projectName)){
            $this->paramaters['projectName'] = $projectName;
        }
    }

    /**
     * 締め切り日時をセットする
     *
     * @param DateTime|null $finishDate nullが指定されたら何もしない
     * @return void
     */
    public function setFinishDate(DateTime|null $finishDate)
    {
        if(!is_null($finishDate)){
            $this->paramaters['finishDate'] = DateUtility::dateToString($finishDate);
        }
    }

    /**
     * 開始日時をセットする
     *
     * @param DateTime|null $startDate nullが指定されたら何もしない
     * @return void
     */
    public function setStartDate(DateTime|null $startDate)
    {
        if(!is_null($startDate)){
            $this->paramaters['startDate'] = DateUtility::dateToString($startDate);
        }
    }

    /**
     * パブリックプロジェクトIDをセットする
     *
     * @param integer|null $publicProjectId nullが指定されたら何もしない
     * @return void
     */
    public function setPublicProjectId(int|null $publicProjectId)
    {
        if(!is_null($publicProjectId)){
            $this->paramaters['publicProjectId'] = (string)$publicProjectId;
        }
    }

    /**
     * ユーザー名をセットする
     *
     * @param string|null $userName nullが指定されたら何もしない
     * @return void
     */
    public function setUserName(string|null $userName)
    {
        if(!is_null($userName)){
            $this->paramaters['userName'] = $userName;
        }
    }

    /**
     * 完了済み「やること」を含めるかをセットする
     *
     * @param boolean|null $isInclideCompletedTodo nullが指定されたら何もしない
     * @return void
     */
    public function setIsInclideCompletedTodo(bool|null $isInclideCompletedTodo)
    {
        if(!is_null($isInclideCompletedTodo)){
            $this->paramaters['isInclideCompletedTodo'] = $isInclideCompletedTodo;
        }
    }

    /**
     * 権限IDをセットする
     *
     * @param integer|null $authorityId nullが指定されたら何もしない
     * @return void
     */
    public function setAuthorityId(int|null $authorityId)
    {
        if(!is_null($authorityId)){
            $this->paramaters['authorityId'] = (string)$authorityId;
        }
    }

    /**
     * 「やること」名をセットする
     *
     * @param String|null $todoName nullが指定されたら何もしない
     * @return void
     */
    public function setTodoName(String|null $todoName)
    {
        if(!is_null($todoName)){
            $this->paramaters['todoName'] = $todoName;
        }
    }

    /**
     * 担当者向け「やること」にも内容を引き継がせるかどうかをセットする
     *
     * @param boolean|null $isCopyContentsToResponsible nullが指定されたら何もしない
     * @return void
     */
    public function setIsCopyContentsToResponsible(bool|null $isCopyContentsToResponsible)
    {
        if(!is_null($isCopyContentsToResponsible)){
            $this->paramaters['isCopyContentsToResponsible'] = $isCopyContentsToResponsible;
        }
    }

    /**
     * プライベートプロジェクトに限定して取得するかどうかをセットする
     *
     * @param boolean|null $isInPrivateProjectOnly nullが指定されたら何もしない
     * @return void
     */
    public function setIsInPrivateProjectOnly(bool|null $isInPrivateProjectOnly)
    {
        if(!is_null($isInPrivateProjectOnly)){
            $this->paramaters['isInPrivateProjectOnly'] = $isInPrivateProjectOnly;
        }
    }

    /**
     * 「やること」の締め切り何秒以内になったら通知を生成するかをセットする
     *
     * @param integer|null $beforeDeadlineForTodoNotice nullが指定されたら何もしない
     * @return void
     */
    public function setBeforeDeadlineForTodoNotice(int|null $beforeDeadlineForTodoNotice)
    {
        if(!is_null($beforeDeadlineForTodoNotice)){
            $this->paramaters['beforeDeadlineForTodoNotice'] = (string)$beforeDeadlineForTodoNotice;
        }
    }

    /**
     *パブリックプロジェクトの締め切り何秒以内になったら通知を生成するかをセットする
     *
     * @param integer|null $beforeDeadlineForProjectNotice nullが指定されたら何もしない
     * @return void
     */
    public function setBeforeDeadlineForProjectNotice(int|null $beforeDeadlineForProjectNotice)
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
            $this->paramaters['pushInsertedTodoNotice'] = $pushInsertedTodoNotice;
        }
    }

    /**
     * 「やること」が始まったら通知を生成するかをセットする
     *
     * @param boolean|null $isPushSatrtedTodoNotice nullが指定されたら何もしない
     * @return void
     */
    public function setIsPushSatrtedTodoNotice(bool|null $isPushSatrtedTodoNotice)
    {
        if(!is_null($isPushSatrtedTodoNotice)){
            $this->paramaters['isPushSatrtedTodoNotice'] = $isPushSatrtedTodoNotice;
        }
    }

    /**
     * ユーザーニックネームをセットする
     *
     * @param String|null $userNickName nullが指定されたら何もしない
     * @return void
     */
    public function setUserNickName(String|null $userNickName)
    {
        if(!is_null($userNickName)){
            $this->paramaters['userNickName'] = $userNickName;
        }
    }

    /**
     * パスワードをセットする
     *
     * @param String|null $password nullが指定されたら何もしない
     * @return void
     */
    public function setPassword(String|null $password)
    {
        if(!is_null($password)){
            $this->paramaters['password'] = $password;
        }
    }

    /**
     * リフレッシュトークンをセットする
     *
     * @param String|null $refreshJwtToken nullが指定されたら何もしない
     * @return void
     */
    public function setRefreshJwtToken(String|null $refreshJwtToken)
    {
        if(!is_null($refreshJwtToken)){
            $this->paramaters['refreshJwtToken'] = $refreshJwtToken;
        }
    }

    /**
     * 元の機種名を指定する
     *
     * @param String|null $oldTerminalName nullが指定されたら何もしない
     * @return void
     */
    public function setOldTerminalName(String|null $oldTerminalName)
    {
        if(!is_null($oldTerminalName)){
            $this->paramaters['oldTerminalName'] = $oldTerminalName;
        }
    }

    /**
     * 新しい機種名を指定する
     *
     * @param String|null $newTerminalName nullが指定されたら何もしない
     * @return void
     */
    public function setNewTerminalName(String|null $newTerminalName)
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
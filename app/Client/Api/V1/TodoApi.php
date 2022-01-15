<?php

namespace App\Client\Api\V1;

use App\Client\Dto\DtoParamaters;
use App\Client\Header\OauthHeader;
use App\Client\Response\TodoOnProjectResponse;
use App\Client\Rest\RestTemplate;
use App\Config\Config;
use DateTime;

/**
 * 「やること」に関するAPI
 */
class TodoAPI
{
    private const ROOT_URL = Config::API_ROOT_URL_V1 . "todo";
    private static TodoApi $instance;
    private RestTemplate $restTemplate;

    /**
     * コンストラクタ シングルトン設計のためプライベート
     */
    private function __construct()
    {
        $this->restTemplate = RestTemplate::getInstance();
    }

    /**
     * インスタンスを取得する
     *
     * @return TodoApi TodoApiのインスタンス
     */
    public static function getInstance(): TodoApi
    {
        self::$instance ??= new TodoApi();
        return self::$instance;
    }

    /**
     * 「やること」を作成する
     *
     * @param string $token
     * @param integer $projectId
     * @param string $todoName
     * @param DateTime $startDate
     * @param DateTime $finishDate
     * @param boolean $isCopyContentsToResponsible
     * @return integer ID
     */
    public function post(string $token, int $projectId, string $todoName, DateTime $startDate, DateTime $finishDate, bool $isCopyContentsToResponsible): int
    {
        $url = self::ROOT_URL;

        //リクエストパラメタ
        $dto = new DtoParamaters();
        $dto->setProjectId($projectId);
        $dto->setTodoName($todoName);
        $dto->setStartDate($startDate);
        $dto->setFinishDate($finishDate);
        $dto->setIsCopyContentsToResponsible($isCopyContentsToResponsible);

        //ヘッダー
        $header = new OauthHeader($token);

        $responseArrayOrContents = $this->restTemplate->post($url, $dto, $header, false);
        return (int)$responseArrayOrContents[0];
    }

    /**
     * 検索条件から「やること」リストを取得する
     *
     * @param string $token
     * @param integer|null $projectId
     * @param DateTime|null $startDate
     * @param DateTime|null $finishDate
     * @param boolean $isInPrivateProjectOnly
     * @param boolean $isIncludeCompletedTodo
     * @return array TodoOnProjectResponse
     */
    public function getListByExample(string $token, int|null $projectId, DateTime|null $startDate, DateTime|null $finishDate, bool $isInPrivateProjectOnly, bool $isIncludeCompletedTodo): array
    {
        $url = self::ROOT_URL;

        //リクエストパラメタ
        $dto = new DtoParamaters();
        $dto->setProjectId($projectId);
        $dto->setIsInPrivateProjectOnly($isInPrivateProjectOnly);
        $dto->setIsInclideCompletedTodo($isIncludeCompletedTodo);
        $dto->setStartDate($startDate);
        $dto->setFinishDate($finishDate);

        //ヘッダー
        $header = new OauthHeader($token);

        $responseArrayOrContents = $this->restTemplate->get($url, $dto, $header);
        return TodoOnProjectResponse::parseTodoOnProjectResponseArray($responseArrayOrContents);
    }

    /**
     * 「やること」を取得する
     *
     * @param string $token
     * @param integer $todoOnProjectId
     * @return TodoOnProjectResponse
     */
    public function get(string $token, int $todoOnProjectId): TodoOnProjectResponse
    {
        $url = self::ROOT_URL . "/$todoOnProjectId";

        //リクエストパラメタ
        $dto = new DtoParamaters();

        //ヘッダー
        $header = new OauthHeader($token);

        $responseArrayOrContents = $this->restTemplate->get($url, $dto, $header);
        return TodoOnProjectResponse::parseTodoOnProjectResponse($responseArrayOrContents);
    }

    /**
     * 「やること」に変更を加える
     *
     * @param string $token
     * @param integer $todoOnProjectId
     * @param string|null $todoName
     * @param DateTime|null $startDate
     * @param DateTime|null $finishDate
     * @param boolean|null $isCopyContentsToResponsible
     * @return void
     */
    public function put(string $token, int $todoOnProjectId, string $todoName = null, DateTime $startDate = null, DateTime $finishDate = null, bool $isCopyContentsToResponsible = null)
    {
        $url = self::ROOT_URL . "/$todoOnProjectId";

        //リクエストパラメタ
        $dto = new DtoParamaters();
        $dto->setTodoName($todoName);
        $dto->setStartDate($startDate);
        $dto->setFinishDate($finishDate);
        $dto->setIsCopyContentsToResponsible($isCopyContentsToResponsible);

        //ヘッダー
        $header = new OauthHeader($token);

        $this->restTemplate->put($url, $dto, $header);
    }

    /**
     * 「やること」を削除する
     *
     * @param string $token
     * @param integer $todoOnProjectId
     * @return void
     */
    public function delete(string $token, int $todoOnProjectId)
    {
        $url = self::ROOT_URL . "/$todoOnProjectId";

        //リクエストパラメタ
        $dto = new DtoParamaters();

        //ヘッダー
        $header = new OauthHeader($token);

        $this->restTemplate->delete($url, $dto, $header);
    }

    /**
     * 「やること」の完了状況をセットする
     *
     * @param string $token
     * @param integer $todoOnProjectId
     * @param boolean $isCompleted
     * @return void
     */
    public function putIsCompleted(string $token, int $todoOnProjectId, bool $isCompleted)
    {
        $url = self::ROOT_URL . "/$todoOnProjectId/is_completed";

        //リクエストパラメタ
        $dto = new DtoParamaters();
        $dto->setIsCompleted($isCompleted);

        //ヘッダー
        $header = new OauthHeader($token);

        $this->restTemplate->put($url, $dto, $header);
    }
}

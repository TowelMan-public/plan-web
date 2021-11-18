<?php

/**
 * ユーザーの設定に関するAPI
 */
class UserConfigAPI
{
    private const ROOT_URL = Config::API_ROOT_URL_V1 + "user/config";
    private static UserConfigApi $instance;
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
     * @return UserConfigApiのインスタンス
     */
    public static function getInstance(): UserConfigApi
    {
        self::$instance ??= new UserConfigApi();
        return self::$instance;
    }

    /**
     * ユーザーの現在の設定を取得する
     *
     * @param string $token
     * @return UserConfigResponse
     */
    public function get(string $token): UserConfigResponse
    {
        $url = self::ROOT_URL;

        //リクエストパラメタ
        $dto = new DtoParamaters();

        //ヘッダー
        $header = new OauthHeader($token);

        $responseArray = $this->restTemplate->get($url, $dto, $header);
        return UserConfigResponse::parseUserConfigResponse($responseArray);
    }

    /**
     * ユーザーの設定を更新する
     *
     * @param string $token
     * @param integer|null $beforeDeadlineForTodoNotice
     * @param integer|null $beforeDeadlineForProjectNotice
     * @param boolean|null $pushInsertedTodoNotice
     * @param boolean|null $isPushSatrtedTodoNotice
     * @return void
     */
    public function put(
        string $token,
        int $beforeDeadlineForTodoNotice = null,
        int $beforeDeadlineForProjectNotice = null,
        bool $pushInsertedTodoNotice = null,
        bool $isPushSatrtedTodoNotice = null
    ) {
        $url = self::ROOT_URL;

        //リクエストパラメタ
        $dto = new DtoParamaters();
        $dto->setBeforeDeadlineForProjectNotice($beforeDeadlineForProjectNotice);
        $dto->setBeforeDeadlineForTodoNotice($beforeDeadlineForTodoNotice);
        $dto->setPushInsertedTodoNotice($pushInsertedTodoNotice);
        $dto->setIsPushSatrtedTodoNotice($isPushSatrtedTodoNotice);

        //ヘッダー
        $header = new OauthHeader($token);

        $this->restTemplate->put($url, $dto, $header);
    }
}

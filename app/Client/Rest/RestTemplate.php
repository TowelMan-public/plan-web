<?php

namespace App\Client\Rest;

use App\Client\Dto\DtoParamaters;
use App\Client\Header\BaseHeader;
use GuzzleHttp\Client;

/**
 * 外部APIを呼ぶ為の便利クラス。内部にguzzleを使っている
 */
class RestTemplate
{
    private static RestTemplate $restTemplate;

    private Client $client;
    private RestTemplateErrorHandler $errorHandler;

    /**
     * コンストラクタ
     */
    private function __construct()
    {
        $this->client = new Client();
        $this->errorHandler = new RestTemplateErrorHandler();
    }

    /**
     * インスタンスを取得する
     *
     * @return RestTemplateのインスタンス
     */
    public static function getInstance(): RestTemplate{
        self::$restTemplate ??= new RestTemplate();
        return self::$restTemplate;
    }

    /**
     * HTTP通信のGETリクエスト
     *
     * @param String $url リクエストするURL（クエリパラメータを省く）
     * @param DtoParamaters $dtoParamaters リクエスト内容（パラメタ）
     * @param BaseHeader $header リクエストヘッダ
     * @param bool $isJson JSONとして取得するか否か。通常ではtrue。
     * @return array|null リクエスト結果（連想配列）
     */
    public function get(string $url, DtoParamaters $dtoParamaters, BaseHeader $header, bool $isJson = true): ?array
    {
        $result = $this->client->get($url, 
            [
                'allow_redirects' => true,
                'http_errors' => false,
                'headers'         => $header->toArray(),
                'query'     => $dtoParamaters->toArray(),
            ]);
        
        $statusCode = $result->getStatusCode();
        $resultContents = $result->getBody()->getContents();
        $resultArray = json_decode($resultContents, true);

        $this->checkErrorAndThrows($statusCode, $resultArray);
        if($isJson)
            return $resultArray;
        else
            return [$resultContents];
    }

    /**
     * HTTP通信のPOSTリクエスト
     *
     * @param String $url リクエストするURL
     * @param DtoParamaters $dtoParamaters リクエスト内容（パラメタ）
     * @param BaseHeader $header リクエストヘッダ
     * @param bool $isJson JSONとして取得するか否か。通常ではtrue。
     * @return array|null リクエスト結果（連想配列）
     */
    public function post(string $url, DtoParamaters $dtoParamaters, BaseHeader $header, bool $isJson = true): ?array
    {
        $result = $this->client->post($url, 
        [
            'allow_redirects' => true,
            'http_errors' => false,
            'headers'         => $header->toArray(),
            'json'     => $dtoParamaters->toArray(),
        ]);
        
        $statusCode = $result->getStatusCode();
        $resultContents = $result->getBody()->getContents();
        $resultArray = json_decode($resultContents, true);

        $this->checkErrorAndThrows($statusCode, $resultArray);
        if($isJson)
            return $resultArray;
        else
            return [$resultContents];
    }

    /**
     * HTTP通信のPUTリクエスト
     *
     * @param String $url リクエストするURL
     * @param DtoParamaters $dtoParamaters リクエスト内容（パラメタ）
     * @param BaseHeader $header リクエストヘッダ
     * @param bool $isJson JSONとして取得するか否か。通常ではtrue。
     * @return array|null リクエスト結果（連想配列）
     */
    public function put(string $url, DtoParamaters $dtoParamaters, BaseHeader $header, bool $isJson = true): ?array
    {
        $result = $this->client->put($url, 
        [
            'allow_redirects' => true,
            'http_errors' => false,
            'headers'         => $header->toArray(),
            'json'     => $dtoParamaters->toArray(),
        ]);
        
        $statusCode = $result->getStatusCode();
        $resultContents = $result->getBody()->getContents();
        $resultArray = json_decode($resultContents, true);

        $this->checkErrorAndThrows($statusCode, $resultArray);
        if($isJson)
            return $resultArray;
        else
            return [$resultContents];;
    }

    /**
     * HTTP通信のDELETEリクエスト
     *
     * @param String $url リクエストするURL
     * @param DtoParamaters $dtoParamaters リクエスト内容（パラメタ）
     * @param BaseHeader $header リクエストヘッダ
     * @param bool $isJson JSONとして取得するか否か。通常ではtrue。
     * @return array|null リクエスト結果（連想配列）
     */
    public function delete(string $url, DtoParamaters $dtoParamaters, BaseHeader $header, bool $isJson = true): ?array
    {
        $result = $this->client->delete($url, 
        [
            'allow_redirects' => true,
            'http_errors' => false,
            'headers'         => $header->toArray(),
            'json'     => $dtoParamaters->toArray(),
        ]);
        
        $statusCode = $result->getStatusCode();
        $resultContents = $result->getBody()->getContents();
        $resultArray = json_decode($resultContents, true);

        $this->checkErrorAndThrows($statusCode, $resultArray);
        if($isJson)
            return $resultArray;
        else
            return [$resultContents];;
    }

    /**
     * HTTPリクエストで、何かエラーがあれば例外を投げる
     *
     * @param integer $statusCode HTMPステータスコード
     * @param array|null $resultArray HTTPの結果のボディーの連想配列
     * @return void
     */
    private function checkErrorAndThrows(int $statusCode, array $resultArray = null)
    {
        $this->errorHandler->checkErrorAndThrows($statusCode, $resultArray);
    }
}

?>
<?php

namespace App\Service;

use App\Client\Api\Api;

class ContentService
{
     private static ContentService $instance;

     /**
      * コンストラクタ シングルトン設計のためプライベート
      */
     private function __construct()
     {
     }

     /**
      * インスタンスを取得する
      *
      * @return ContentServiceのインスタンス
      */
     public static function getInstance(): ContentService
     {
          self::$instance ??= new ContentService();
          return self::$instance;
     }
    
     public function insertContent(string $oauthToken, int $todoId, string $contentTitle, string $contentExplanation): int
     {
          return Api::last()->content()->post($oauthToken, $todoId, $contentTitle, $contentExplanation);
     }

     /**
      * やることの内容を複数登録する
      *
      * @param string $oauthToken
      * @param int $todoId
      * @param array $contentArray 中身は、「title」と「explanation」をそれぞれnullがないことを保証し保持している連想配列の連想配列。
      * @return void
      */
     public function insertContentArray(string $oauthToken, int $todoId, array $contentArray)
     {
          foreach ($contentArray as $nullableContent) {
               if($nullableContent !== null){
                    Api::last()->content()->post($oauthToken, $todoId, $nullableContent['title'], $nullableContent['explanation']);
               }
          }
     }
}
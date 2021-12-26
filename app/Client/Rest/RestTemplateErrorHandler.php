<?php

namespace App\Client\Rest;

use App\Client\Exception\AlreadyJoinedPublicProjectException;
use App\Client\Exception\AlreadySelectedAsTodoResponsibleException;
use App\Client\Exception\AlreadyUsedTerminalNameException;
use App\Client\Exception\AlreadyUsedUserNameException;
use App\Client\Exception\ApiHttpException;
use App\Client\Exception\BadRequestException;
use App\Client\Exception\FailureCreateAuthenticationTokenException;
use App\Client\Exception\InvalidLoginException;
use App\Client\Exception\NotFoundValueException;
use App\Client\Exception\NotHaveAuthorityToOperateProjectException;
use App\Client\Exception\NotJoinedPublicProjectException;
use App\Client\Exception\NotSelectedAsTodoResponsibleException;
use App\Client\Exception\ValidateException;

/**
 * 外部APIを呼び出すときに生じたエラーを処理するクラス
 */
class RestTemplateErrorHandler
{
    /**
     * エラーがないかをチェックし、エラーがあれば例外を投げる
     *
     * @param integer $statusCode HTTPステータスコード
     * @param array|null $resultArray HTTPの結果のボディーの連想配列
     * @return void
     */
    public function checkErrorAndThrows(int $statusCode, array $resultArray = null)
    {
        $errorName = '';
        $message = '';

        if( isset($resultArray['errorCode']) && isset($resultArray['message']) ){
            $errorName = $resultArray['errorCode'];
            $message = $resultArray['message'];
        }

        switch($errorName){
            case 'AlreadyJoinedPublicProjectException':
                throw new AlreadyJoinedPublicProjectException($message);
            case 'AlreadySelectedAsTodoResponsibleException':
                throw new AlreadySelectedAsTodoResponsibleException($message);
            case 'AlreadyUsedTerminalNameException':
                throw new AlreadyUsedTerminalNameException($message);
            case 'AlreadyUsedUserNameException':
                throw new AlreadyUsedUserNameException($message);
            case 'BadRequestException':
                throw new BadRequestException($message);
            case 'FailureCreateAuthenticationTokenException':
                throw new FailureCreateAuthenticationTokenException($message);
            case 'NotFoundValueException':
                throw new NotFoundValueException($message);
            case 'NotHaveAuthorityToOperateProjectException':
                throw new NotHaveAuthorityToOperateProjectException($message);
            case 'NotJoinedPublicProjectException':
                throw new NotJoinedPublicProjectException($message);
            case 'NotSelectedAsTodoResponsibleException':
                throw new NotSelectedAsTodoResponsibleException($message);
            case 'ValidateException':
                throw new ValidateException($message);
            
        }

        if($statusCode === 401){
            throw new InvalidLoginException();
        }else if($statusCode >= 400){
            throw new ApiHttpException($statusCode, $resultArray);
        }
    }
}
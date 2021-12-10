<?php

namespace App\Client\Rest;

use App\Client\Exception\AlreadyJoinedPublicProjectException;
use App\Client\Exception\AlreadySelectedAsTodoResponsibleException;
use App\Client\Exception\AlreadyUsedTerminalNameException;
use App\Client\Exception\AlreadyUsedUserNameException;
use App\Client\Exception\BadRequestException;
use App\Client\Exception\FailureCreateAuthenticationTokenException;
use App\Client\Exception\InvalidLoginException;
use App\Client\Exception\NotFoundValueException;
use Symfony\Component\HttpKernel\Exception\HttpException;

use function PHPUnit\Framework\isNull;

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
        $errorName = $resultArray['errorCode'];
        $message = $resultArray['message'];

        if(!is_null($errorName)){
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
                    throw new AlreadyJoinedPublicProjectException($message);
                case 'NotJoinedPublicProjectException':
                    throw new AlreadyJoinedPublicProjectException($message);
                case 'NotSelectedAsTodoResponsibleException':
                    throw new NotFoundValueException($message);
                case 'ValidateException':
                    throw new AlreadyJoinedPublicProjectException($message);
                
            }
        }else if($statusCode === 401){
            throw new InvalidLoginException();
        }else if($statusCode >= 400){
            throw new HttpException($statusCode);
        }
    }
}
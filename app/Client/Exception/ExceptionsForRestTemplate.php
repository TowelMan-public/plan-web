<?php

/**
 * 既にプロジェクトに加入してるか、勧誘されてるユーザーが指定されたときの例外
 */
class AlreadyJoinedPublicProjectException extends Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}

/**
 * 既に「やること」の担当者に抜擢されているユーザーが指定されたときの例外
 */
class AlreadySelectedAsTodoResponsibleException extends Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}

/**
 * 既に使われている機種名が指定されたときの例外
 */
class AlreadyUsedTerminalNameException extends Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}

/**
 * 既に使われているユーザー名が指定されたときの例外
 */
class AlreadyUsedUserNameException extends Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}

/**
 * 不正なリクエストが来たときの例外
 */
class BadRequestException extends Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}

/**
 * 認証用トークンが不正
 */
class FailureCreateAuthenticationTokenException extends Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}

/**
 * 存在しない値が指定されたときに投げられる例外<br>
 * そのフィールド名と値をセットして投げる
 */
class NotFoundValueException extends Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }

    //TODO その都度作っていく
}

/**
 * 操作をする権限がないプロジェクトを操作しようとしたときに投げられる例外
 */
class NotHaveAuthorityToOperateProjectException extends Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}

/**
 * 加入していないか、勧誘されてないパブリックプロジェクトが指定されたときの例外
 */
class NotJoinedPublicProjectException extends Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}

/**
 * 担当者に抜擢されてない「やること」が指定されたときの例外
 */
class NotSelectedAsTodoResponsibleException extends Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}

/**
 * サーバ側でバリデーションチェックに引っかかった。
 */
class ValidateException extends Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}

/**
 * 認証エラー（認証用トークンが不正・再ログインが必要）
 */
class InvalidLoginException extends Exception
{
    public function __construct()
    {
        parent::__construct('You have not login or you have to login one more');
    }
}

?>
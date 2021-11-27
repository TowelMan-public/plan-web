@extends('unlogined_layout')

@section('page_name') 
    アカウント登録
@endsection

@section('title_bar')
    <h2>アカウント登録</h2>
@endsection

@section('contents')
    <form action="/test" method="get">
        <div class="input_label">
            <div class="input_label_core">
                <div class="input_name">ユーザー名</div>
                <input type="text" name="userName" placeholder="ユーザー名" />
            </div>
            <div class="error">{{ $errors->first('userName') }}</div>
        </div>
        <div class="input_label">
            <div class="input_label_core">
                <div class="input_name">ユーザーのニックネーム</div>
                <input type="text" name="userNickName" placeholder="ユーザーのニックネーム" />
            </div>
            <div class="error">{{ $errors->first('userNickName') }}</div>
        </div>
        <div class="input_label">
            <div class="input_label_core">
                <div class="input_name">パスワード</div>
                <input type="password" name="password" placeholder="パスワード" />
            </div>
            <div class="error">{{ $errors->first('password') }}</div>
        </div>
        <div class="input_label">
            <div class="input_label_core">
                <div class="input_name">パスワード（もう一度）</div>
                <input type="password" name="oneMorePassword" placeholder="パスワード（もう一度）" />
            </div>
            <div class="error">{{ $errors->first('oneMorePassword') }}</div>
        </div>
        
        <div class="input_label"><input type="submit" value="アカウント作成" class="button"></div>

        <a href="/test">既存のアカウントでログインする</a>
    </form>
@endsection
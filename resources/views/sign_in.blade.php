@extends('base_layout')

@section('page_name') 
    ログイン
@endsection

@section('title_bar')
    <h2>ログイン</h2>
@endsection

@section('contents')
    <form action="/test" method="get">
        @if (isset($loginError))
            <div class="error">{{ $loginError }}</div>
        @endif
        
        <div class="input_label">
            <div class="input_label_core">
                <div class="input_name">ユーザー名</div>
                <input type="text" name="userName" placeholder="ユーザー名" />
            </div>
            <div class="error">{{ $errors->first('userName') }}</div>
        </div>
        <div class="input_label">
            <div class="input_label_core">
                <div class="input_name">パスワード</div>
                <input type="password" name="password" placeholder="パスワード" />
            </div>
            <div class="error">{{ $errors->first('password') }}</div>
        </div>
        
        <div class="input_label"><input type="submit" value="ログイン" class="button"></div>

        <a href="/test">新しくユーザーを作成する</a>
    </form>
@endsection
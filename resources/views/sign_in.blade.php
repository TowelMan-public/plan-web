<!DOCTYPE html>
<html>
    <head>
        <title>ログイン - プラン子</title>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <meta name="viewport" content="width=device-width, inital-scale=1">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    </head>

    <body>
        <header>
            <h1>プラン子♪</h1>
        </header>

        <main>
            <div class="title_bar">
                <h2>ログイン</h2>
            </div>

            <div class="contents">
                <form action="/test" method="get"> 
                    @if(isset( $loginError ))
                        <div class="error">{{$loginError}}</div>
                    @endif

                    <div class="pc_mode">
                        <div class="input_label">
                            ユーザー名：<input type="text" name="userName" />
                            <div class="error">{{ $errors->first('userName') }}</div>
                        </div>
                        <div class="input_label">
                            パスワード：<input type="password" name="password"/>
                            <div class="error">{{ $errors->first('password') }}</div>
                        </div>
                        <div class="input_label"><input type="submit" value="ログイン" class="button"></div>
                    </div>
                    
                    <div class="mobile_mode">
                        <div class="input_label">ユーザー名</div>
                        <div class="error">{{ $errors->first('userName') }}</div>
                        <input type="text" name="userName" placeholder="ユーザー名" />
                        <div class="input_label">パスワード</div>
                        <div class="error">{{ $errors->first('password') }}</div>
                        <input type="password" name="password" placeholder="パスワード" />
                        <input type="submit" value="ログイン" class="button">
                    </div>
                    <a href="/test">新しくユーザーを作成する</a>
                </form>
            </div>
        </main>

        <footer>
            <p>&copy; Towelman. 2021.</p> 
        </footer>
    </body>
</html>
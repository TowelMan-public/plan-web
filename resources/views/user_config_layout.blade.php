@extends('default_layout')

@section('page_name') 
    設定
@endsection

@section('title_name')
    設定
@endsection

@section('contents_menu')
    <li><a href="#">機種名一覧</a></li>
    <li><a href="#">退会する</a></li>
@endsection

@section('contents')
    <h3 id="point_user_core_config" style="margin-top: 0;">ユーザーの設定</h3>
    @if (isset($userCoreConfigErrorString))
        <div class="error">{{ $userCoreConfigErrorString }}</div>
    @endif
    <form action="/user/config/core" method="post">
        @csrf

        <div class="input_label">
            <div class="input_label_core">
                <div class="input_name">ユーザー名</div>
                <input type="text" name="userName" placeholder="ユーザー名" value="{{ isset($user)? $user->getUserName() : old('userName', '') }}" />
            </div>
            <div class="error">{{ $errors->first('userName') }}</div>
        </div>
        <div class="input_label">
            <div class="input_label_core">
                <div class="input_name">ユーザーのニックネーム</div>
                <input type="text" name="userNickName" placeholder="ユーザーのニックネーム" value="{{ isset($user)? $user->getUserNickName() : old('userNickName', '') }}" />
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
        
        <div class="input_label"><input type="submit" value="反映" class="button"></div>
    </form>

    <h3 id="point_notice_config">通知の設定</h3>

    <form action="/user/config/notice" method="post">
        @csrf

        <div class="input_label">
            <div class="input_label_core">
                <div class="input_name">プロジェクトの締め切り通知を出すタイミング</div>
                <div class="inputs">
                    <input type="number" name="beforeDeadlineForProjectNoticeDay" placeholder="日" style="width: 3em;"
                        max="50" min="1"
                        value="{{ isset($userConfig)? $userConfig->getBeforeDeadlineForProjectNoticeDay() : old('beforeDeadlineForProjectNoticeDay', '') }}" />
                    <div style="margin-top: auto;">日</div>
                    <input type="number" name="beforeDeadlineForProjectNoticeHour" placeholder="時" style="width: 3em;"
                        max="23" min="0"
                        value="{{ isset($userConfig)? $userConfig->getBeforeDeadlineForProjectNoticeHour() : old('beforeDeadlineForProjectNoticeHour', '') }}" />
                    <div style="margin-top: auto;">時</div>
                    <input type="number" name="beforeDeadlineForProjectNoticeMinute" placeholder="分" style="width: 3em;"
                        max="59" min="0"
                        value="{{ isset($userConfig)? $userConfig->getBeforeDeadlineForProjectNoticeMinute() : old('beforeDeadlineForProjectNoticeMinute', '') }}" />
                    <div style="margin-top: auto;">分前</div>
                </div>
            </div>
            <div class="error">{{ $errors->first('beforeDeadlineForProjectNoticeDay').$errors->first('beforeDeadlineForProjectNoticeHour').$errors->first('beforeDeadlineForProjectNoticeMinute') }}</div>
        </div>
        <div class="input_label">
            <div class="input_label_core">
                <div class="input_name">やることの締め切り通知を出すタイミング</div>
                <div class="inputs">
                    <input type="number" name="beforeDeadlineForTodoNoticeDay" placeholder="日" style="width: 3em;"
                        max="50" min="1"
                        value="{{ isset($userConfig)? $userConfig->getBeforeDeadlineForTodoNoticeDay() : old('beforeDeadlineForTodoNoticeDay', '') }}" />
                    <div style="margin-top: auto;">日</div>
                    <input type="number" name="beforeDeadlineForTodoNoticeHour" placeholder="時" style="width: 3em;"
                        max="23" min="0"
                        value="{{ isset($userConfig)? $userConfig->getBeforeDeadlineForTodoNoticeHour() : old('beforeDeadlineForTodoNoticeHour', '') }}" />
                    <div style="margin-top: auto;">時</div>
                    <input type="number" name="beforeDeadlineForTodoNoticeMinute" placeholder="分" style="width: 3em;"
                        max="59" min="0"
                        value="{{ isset($userConfig)? $userConfig->getBeforeDeadlineForTodoNoticeMinute() : old('beforeDeadlineForTodoNoticeMinute', '') }}" />
                    <div style="margin-top: auto;">分前</div>
                </div>
            </div>
            <div class="error">{{ $errors->first('beforeDeadlineForTodoNoticeDay').$errors->first('beforeDeadlineForTodoNoticeHour').$errors->first('beforeDeadlineForTodoNoticeMinute') }}</div>
        </div>

        <div class="input_label">
            <input type="checkbox" id="isPushInsertedTodoNotice" name="isPushInsertedTodoNotice" 
                value="1"
                {{ $userConfig->getIsPushInsertedTodoNotice()? 'checked' : '' }}/>
            <label for="isPushInsertedTodoNotice" class="switch_label">
                <div class="input_name">やることの担当者に抜擢されたときに通知する</div>
                <div class="switch">
                    <div class="circle"></div>
                    <div class="base"></div>
                </div>
            </label>
        </div>

        <div class="input_label">
            <input type="checkbox" id="isPushStartedTodoNotice" name="isPushStartedTodoNotice" 
                value="1"
                {{ $userConfig->getIsPushStartedTodoNotice()? 'checked' : '' }}/>
            <label for="isPushStartedTodoNotice" class="switch_label">
                <div class="input_name">やることが始まったときに通知する</div>
                <div class="switch">
                    <div class="circle"></div>
                    <div class="base"></div>
                </div>
            </label>
        </div>
        
        <div class="input_label"><input type="submit" value="反映" class="button"></div>
    </form>
@endsection
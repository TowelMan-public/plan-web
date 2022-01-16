@extends('default_layout')

@section('page_name') 
    {{ $todoData->getName(); }}の担当者情報
@endsection

@section('title_name')
    {{ $todoData->getName(); }}の担当者情報
@endsection

@section('contents_menu')
    @if ($errorForAll !== null)
        <script>
            confirm('{{ $errorForAll }}');
        </script>
    @endif

    <li><a href="/todo/onProject/{{ $todoData->getId() }}">全体向けやることページへ</a></li>
    <li id="exit_todo">辞退</li>
    <form class="none" id="exit_todo_form" action="/todo/onResponsible/{{ $todoData->getId() }}/exit" method="POST">
        @csrf
    </form>
@endsection

@section('contents')
    @if ($operatable)
        <h3>担当者の抜擢</h3>
        <form action="/todo/onResponsible/{{ $todoData->getId() }}/insert" method="post">
            @csrf
            @isset($formError)
                <div class="error">{{ $formError }}</div>
            @endisset
            <div class="input_label">
                <div class="input_label_core">
                    <div class="input_name">ユーザー名</div>
                    <input type="text" name="userName" placeholder="ユーザー名" value="{{ old('userName', '') }}" />
                </div>
                <div class="error">{{ $errors->first('userName') }}</div>
            </div>
            <div class="input_label"><input type="submit" value="抜擢" class="button"></div>
        </form>

        <br>
        <div>
            <a class="a_in_contents" id="todo_responsible_completed_true_a">この担当者全員の完了状況を完了にする</a>
            <form class="none" id="todo_responsible_completed_true_form" action="/todo/onResponsible/{{ $todoData->getId() }}/isCompleted/all" method="POST">
                @csrf
                <input type="hidden" name="isCompleted" value="1">
            </form>
            <script>
                $('#todo_responsible_completed_true_a').click(function () {
                    $('#todo_responsible_completed_true_form').submit();
                });
            </script>
        </div>

        <br>
        <div>
            <a class="a_in_contents" id="todo_responsible_completed_false_a">この担当者全員の完了状況を未完了にする</a>
            <form class="none" id="todo_responsible_completed_false_form" action="/todo/onResponsible/{{ $todoData->getId() }}/isCompleted/all" method="POST">
                @csrf
                <input type="hidden" name="isCompleted" value="0">
            </form>
            <script>
                $('#todo_responsible_completed_false_a').click(function () {
                    $('#todo_responsible_completed_false_form').submit();
                });
            </script>
        </div>

        <br>
    @endif
    @foreach ($userInResponsibleDataArray as $userInResponsibleData)

    <div id="todo_on_responsible_{{ $userInResponsibleData->getUserName() }}" class="todo_on_responsible">
        <div class="is_completed" id="todo_on_responsible_{{ $userInResponsibleData->getUserName() }}_is_completed" style="margin-right: auto; margin-top: auto; margin-bottom: auto;">
            <img src="{{ asset('img/check.png') }}" class="{{ $userInResponsibleData->getIsCompleted() ? '' : 'none' }}" style="height: 1em; width: 1em;">
        </div>
        <div class="text">
            <div class="name">{{ $userInResponsibleData->getUserNickName() }}</div>
            <div>ユーザー名: {{ $userInResponsibleData->getUserName() }}</div>
        </div>

        @if ($operatable)
            <div id="todo_on_responsible_{{ $userInResponsibleData->getUserName() }}_delete_button" class="delete_button"> 削除 </div>
        @endif
    </div>
    @if ($operatable)
        <script>
            $("#todo_on_responsible_{{ $userInResponsibleData->getUserName() }}_delete_button").click(function (){
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "/todo/onResponsible/{{ $todoData->getId() }}/delete",
                    type: "post",
                    data : {
                        userName : "{{ $userInResponsibleData->getUserName() }}",
                    },
                })
                .done((res)=>{
                    jQuery("#todo_on_responsible_{{ $userInResponsibleData->getUserName() }}").addClass("leaved");
                })
                .fail((error)=>{
                    console.log(error.statusText)
                    confirm('あなたにその捜査権限がないため、その操作を行うことができないと思われます。');
                })
            })
        </script>
    @endif

    @endforeach
@endsection
@extends('default_layout')

@section('page_name') 
    {{ $projectData->getName() }}の加入者情報
@endsection

@section('title_name')
    {{ $projectData->getName() }}の加入者情報
@endsection

@section('title_bar_contents')
    @if ($mySubscriberData->hasTentativeAuthority())
        <div>あなたはこのプロジェクトに勧誘されています</div><br>

        <input type="submit" value="加入" class="button" form="project_accept_form">
        <input type="submit" value="断る" class="button" form="project_block_form">

        <form class="none" id="project_accept_form" action="/project/public/{{ $projectData->getId() }}/accept" method="POST">
            @csrf
        </form>

        <form class="none" id="project_block_form" action="/project/public/{{ $projectData->getId() }}/block" method="POST">
            @csrf
        </form>
    @endif
@endsection

@section('contents_menu')
    <li><a href="/project/public/{{ $projectData->getId() }}">プロジェクトの設定</a></li>
    <li id="exit_project">脱退</li>
    <form class="none" id="exit_project_form" action="/project/public/{{ $projectData->getId() }}/exit" method="POST">
        @csrf
    </form>
@endsection

@section('contents')
    <script>
        @if($exitError !== null)
            confirm("あなたは脱退できません");
        @endif

        $('#exit_project').click(function () {
            if(confirm('本当に脱退しますか？')){
                $('#exit_project_form').submit();
            }
        })
    </script>

    @if ($mySubscriberData->hasSuperAuthority())
    <h3>ユーザーの勧誘</h3>
    <form action="/project/public/{{ $projectData->getId() }}/subscriber/invitation" method="post">
        @csrf
        @isset($invitationFormError)
            <div class="error">{{ $invitationFormError }}</div>
        @endisset
        <div class="input_label">
            <div class="input_label_core">
                <div class="input_name">ユーザー名</div>
                <input type="text" name="userName" placeholder="ユーザー名" value="{{ old('userName', '') }}" />
            </div>
            <div class="error">{{ $errors->first('userName') }}</div>
        </div>
        <div class="input_label"><input type="submit" value="勧誘" class="button"></div>
    </form>

    <br>
    @endif

    <h3>加入者一覧</h3>
    @foreach ($subscriberDataArray as $subscriberData)
        <div id="subscriber_{{ $subscriberData->getUserName() }}" class="subscriber">
            @if($subscriberData->hasTentativeAuthority())
                <div class="is_now_invitation">勧誘中</div>
            @endif
            <div class="text">
                <div class="name">{{ $subscriberData->getUserNickName() }}</div>
                <div>ユーザー名: {{ $subscriberData->getUserName() }}</div>
            </div>

            @if(!$subscriberData->hasTentativeAuthority())
                <div class="select">
                    <div class="">
                        <select id="{{ $subscriberData->getUserName() }}_authority_id" name="authorityId"
                            {{ (isset($projectData)? $projectData->getIsCompleted() : old('isCompleted', false))? 'checked' : '' }}>
                            <option value="2" {{ $subscriberData->hasSuperAuthority()? 'selected' : '' }}>管理者</option>
                            <option value="1" {{ $subscriberData->hasSuperAuthority()? '' : 'selected'  }}>一般</option>
                        </select>
                    </div>
                    <div class="error">{{ $errors->first('authorityId') }}</div>
                </div>
            @endif

            @if ($mySubscriberData->hasSuperAuthority())
                <div id="subscriber_{{ $subscriberData->getUserName() }}_delete_button" class="delete_button"> 削除 </div>
            @endif
        </div>
        @if ($mySubscriberData->hasSuperAuthority())
            <script>
                $("#subscriber_{{ $subscriberData->getUserName() }}_delete_button").click(function (){
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "/project/public/{{ $projectData->getId() }}/subscriber/delete",
                        type: "post",
                        data : {
                            userName : "{{ $subscriberData->getUserName() }}",
                        },
                    })
                    .done((res)=>{
                        jQuery("#subscriber_{{ $subscriberData->getUserName() }}").addClass("leaved");
                    })
                    .fail((error)=>{
                        console.log(error.statusText)
                        confirm('あなたにその捜査権限がないか、その操作はこのプロジェクトから管理者をいなくしてしまうため出来ません。');
                    })
                })

                $('#{{ $subscriberData->getUserName() }}_authority_id').change(function () {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "/project/public/{{ $projectData->getId() }}/subscriber/update",
                        type: "post",
                        data : {
                            userName : "{{ $subscriberData->getUserName() }}",
                            authorityId : $('#{{ $subscriberData->getUserName() }}_authority_id').val(),
                        },
                    })
                    .done((res)=>{
                        //何もしない
                    })
                    .fail((error)=>{
                        console.log(error.statusText)
                        let authorityId = $('#{{ $subscriberData->getUserName() }}_authority_id').val();
                        if(authorityId == 1){
                            authorityId = 2;
                        }
                        else{
                            authorityId = 1
                        }

                        $('#{{ $subscriberData->getUserName() }}_authority_id').val(authorityId);
                        confirm('あなたにその捜査権限がないか、その操作はこのプロジェクトから管理者をいなくしてしまうため出来ません。');
                    })
                })
            </script>
        @endif
    @endforeach

    <br>
    <div>
        <a href="/project/public/{{ $projectData->getId() }}">プロジェクトの設定をする</a>
    </div>
@endsection
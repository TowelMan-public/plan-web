@extends('default_layout')

@section('page_name') 
    {{ $projectData->getName() }}
@endsection

@section('title_name')
    {{ $projectData->getName() }}
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
    <li><a href="/project/public/{{ $projectData->getId() }}/todo/onResponsible/month">担当していやること</a></li>
    <li><a href="/project/public/{{ $projectData->getId() }}/todo/onProject/month">全体のやること</a></li>
    <li><a href="/project/public/{{ $projectData->getId() }}/todo/insert">やること作成</a></li>
    <li><a href="/project/public/{{ $projectData->getId() }}/subscriber">加入者一覧</a></li>
@endsection

@section('contents')
    <form action={{ $mySubscriberData->hasSuperAuthority() ? '/project/public/'.$projectData->getId().'/update' : '' }} method="post">
        @csrf

        <div class="input_label">
            <div class="input_label_core">
                <div class="input_name">プロジェクト名</div>
                <input {{ $mySubscriberData->hasSuperAuthority()? '' : 'readonly' }} type="text" name="projectName" placeholder="プロジェクト名" value="{{ old('projectName', $projectData->getName()) }}" />
            </div>
            <div class="error">{{ $errors->first('projectName') }}</div>
        </div>

        <div id="inputs_for_public_project">
            <div class="input_label">
                <div class="input_label_core">
                    <div class="input_name">プロジェクトの開始日時</div>
                    <div class="inputs">
                        <input {{ $mySubscriberData->hasSuperAuthority()? '' : 'readonly' }} type="number" name="startDateTimeYear" placeholder="年" style=":width: 4em;"
                            max="2200" min="1980"
                            value="{{ old('startDateTimeYear', $projectData->getStartDateAssociativeArray()['year'])  }}" />
                        <div style="margin-top: auto;">年</div>
                        <input {{ $mySubscriberData->hasSuperAuthority()? '' : 'readonly' }} type="number" name="startDateTimeMonth" placeholder="月" style="width: 2em;"
                            max="12" min="1"
                            value="{{ old('startDateTimeMonth', $projectData->getStartDateAssociativeArray()['month']) }}" />
                        <div style="margin-top: auto;">月</div>
                        <input {{ $mySubscriberData->hasSuperAuthority()? '' : 'readonly' }} type="number" name="startDateTimeDay" placeholder="日" style="width: 2em;"
                            max="31" min="1"
                            value="{{ old('startDateTimeDay', $projectData->getStartDateAssociativeArray()['day']) }}" />
                        <div style="margin-top: auto;">日</div>
                        <input {{ $mySubscriberData->hasSuperAuthority()? '' : 'readonly' }} type="number" name="startDateTimeHour" placeholder="時" style="width: 2em;"
                            max="23" min="0"
                            value="{{ old('startDateTimeHour', $projectData->getStartDateAssociativeArray()['hour']) }}" />
                        <div style="margin-top: auto;">時</div>
                        <input {{ $mySubscriberData->hasSuperAuthority()? '' : 'readonly' }} type="number" name="startDateTimeMinute" placeholder="分" style="width: 2em;"
                            max="59" min="0"
                            value="{{ old('startDateTimeMinute', $projectData->getStartDateAssociativeArray()['minute']) }}" />
                        <div style="margin-top: auto;">分</div>
                    </div>
                </div>
                <div class="error">{{ $errors->first('startDateTimeYear')?:$errors->first('startDateTimeMonth')?:$errors->first('startDateTimeDay')
                ?:$errors->first('startDateTimeHour')?:$errors->first('startDateTimeMinute') }}</div>
            </div>
    
            <div class="input_label">
                <div class="input_label_core">
                    <div class="input_name">プロジェクトの締め切り日時</div>
                    <div class="inputs">
                        <input {{ $mySubscriberData->hasSuperAuthority()? '' : 'readonly' }} type="number" name="finishDateTimeYear" placeholder="年" style=":width: 4em;"
                            max="2200" min="1980"
                            value="{{ old('finishDateTimeYear', $projectData->getFinishDateAssociativeArray()['year']) }}" />
                        <div style="margin-top: auto;">年</div>
                        <input {{ $mySubscriberData->hasSuperAuthority()? '' : 'readonly' }} type="number" name="finishDateTimeMonth" placeholder="月" style="width: 2em;"
                            max="12" min="1"
                            value="{{ old('finishDateTimeMonth', $projectData->getFinishDateAssociativeArray()['month']) }}" />
                        <div style="margin-top: auto;">月</div>
                        <input {{ $mySubscriberData->hasSuperAuthority()? '' : 'readonly' }} type="number" name="finishDateTimeDay" placeholder="日" style="width: 2em;"
                            max="31" min="1"
                            value="{{ old('finishDateTimeDay', $projectData->getFinishDateAssociativeArray()['day']) }}" />
                        <div style="margin-top: auto;">日</div>
                        <input {{ $mySubscriberData->hasSuperAuthority()? '' : 'readonly' }} type="number" name="finishDateTimeHour" placeholder="時" style="width: 2em;"
                            max="23" min="0"
                            value="{{ old('finishDateTimeHour', $projectData->getFinishDateAssociativeArray()['hour']) }}" />
                        <div style="margin-top: auto;">時</div>
                        <input {{ $mySubscriberData->hasSuperAuthority()? '' : 'readonly' }} type="number" name="finishDateTimeMinute" placeholder="分" style="width: 2em;"
                            max="59" min="0"
                            value="{{ old('finishDateTimeMinute', $projectData->getFinishDateAssociativeArray()['minute']) }}" />
                        <div style="margin-top: auto;">分</div>
                    </div>
                </div>
                <div class="error">{{ $errors->first('finishDateTimeYear')?:$errors->first('finishDateTimeMonth')?:$errors->first('finishDateTimeDay')
                ?:$errors->first('finishDateTimeHour')?:$errors->first('finishDateTimeMinute') }}</div>

                <div class="error">{{ $errors->first('dateTimeError') }}</div>
            </div>
        </div>

        <div class="input_label {{ $mySubscriberData->hasSuperAuthority()? '' : 'none' }}"><input type="submit" value="反映" class="button"></div>

        <br>
        <div class="input_label">
            <input {{ $mySubscriberData->hasSuperAuthority()? '' : 'disabled' }} type="checkbox" id="is_completed" name="isCompleted" 
                value="1"
                {{ (isset($projectData)? $projectData->getIsCompleted() : old('isCompleted', false))? 'checked' : '' }}/>
            <label for="is_completed" class="switch_label">
                <div id="is_completed_input_name" class="input_name">{{ (isset($projectData)? $projectData->getIsCompleted() : old('isCompleted', false))? '完了済み' : '完了していない' }}</div>
                <div class="switch">
                    <div class="circle"></div>
                    <div class="base"></div>
                </div>
            </label>
    
            @if ($mySubscriberData->hasSuperAuthority())
                <script>
                    $('#is_completed').change(function () {
                        let newIsCompleted = $('#is_completed').prop("checked");
                        
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: "/project/public/{{ $projectData->getId() }}/isCompleted",
                            type: "post",
                            data : {
                                isCompleted : newIsCompleted ? 1 : 0,
                            },
                        })
                        .done((res)=>{
                            $("#is_completed_input_name").text(newIsCompleted? '完了済み' : '完了していない');
                        })
                        .fail((error)=>{
                            console.log(error.statusText)
                        })
                    });
                </script>
            @endif
        </div>
    </form>
    
    @if ($mySubscriberData->hasSuperAuthority())
        <br>
        <div>
            <a class="a_in_contents" id="project_delete_a">このパブリックプロジェクトを削除する</a>
            <form class="node" id="project_delete_form" action="/project/public/{{ $projectData->getId() }}/delete" method="POST">
                @csrf
            </form>
            <script>
                $('#project_delete_a').click(function () {
                    $('#project_delete_form').submit();
                });
            </script>
        </div>
    @endif

    @if ($mySubscriberData->hasTentativeAuthority())
        <br>
        <div>
            <a class="a_in_contents" id="project_accept_a">勧誘を受け入れる</a>
            <form class="node" id="project_accept_form" action="/project/public/{{ $projectData->getId() }}/accept" method="POST">
                @csrf
            </form>
            <script>
                $('#project_accept_a').click(function () {
                    $('#project_accept_form').submit();
                });
            </script>
        </div>
    @endif

    <br>
    <div>
        <a href="/project/public/{{ $projectData->getId() }}/subscriber">加入者一覧を見る</a>
    </div>
@endsection
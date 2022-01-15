@extends('default_layout')

@section('page_name') 
    {{ $todoData->getName(); }}
@endsection

@section('title_name')
    {{ $todoData->getName(); }}
@endsection

@section('contents_menu')
    @if ($errorForAll !== null)
        <script>
            confirm('{{ $errorForAll }}');
        </script>
    @endif

    @if (!$projectData->getIsPrivate())
        @if ($todoData->getIsOnProject())
            <li><a href="/todo/onProject/{{ $todoData->getId() }}/responsible">自分向けのやること</a></li>
        @else
            <li><a href="/todo/onResponsible/{{ $todoData->getId() }}/project">全体版のやること</a></li>
        @endif
    @endif

    <li><a href="/project/{{ $projectData->getIsPrivate() ? 'private' : 'public' }}/{{ $projectData->getId() }}">プロジェクトへ</a></li>
    <li><a href="/project/{{ $projectData->getIsPrivate() ? 'private' : 'public' }}/{{ $projectData->getId() }}/todo/{{ $todoData->getIsOnProject() ? 'onProject' : 'onResponsible' }}/month">やることの一月ごとの表示</a></li>
@endsection

@section('contents')
    <h3>やること</h3>
    <form action="/todo/onProject/{{ $todoData->getId() }}/update" method="post">
        @csrf

        @if ($formError !== null)
            <div class="error">{{ $formError }}</div>
        @endif

        <div class="input_label">
            <div class="input_label_core">
                <div class="input_name">やることの名前</div>
                <input {{ $operatable && $todoData->getIsOnProject()? '' : 'disabled' }} type="text" name="todoName" placeholder="やることの名前" value="{{ old('todoName', $todoData->getName()) }}" />
            </div>
            <div class="error">{{ $errors->first('todoName') }}</div>
        </div>

        <div class="input_label">
            <div class="input_label_core">
                <div class="input_name">やることの開始日時</div>
                <div class="inputs">
                    <input {{ $operatable && $todoData->getIsOnProject()? '' : 'disabled' }} type="number" name="startDateTimeYear" placeholder="年" style=":width: 4em;"
                        max="2200" min="1980"
                        value="{{ old('startDateTimeYear', $todoData->getStartDateAssociativeArray()['year'])  }}" />
                    <div style="margin-top: auto;">年</div>
                    <input {{ $operatable && $todoData->getIsOnProject()? '' : 'disabled' }} type="number" name="startDateTimeMonth" placeholder="月" style="width: 2em;"
                        max="12" min="1"
                        value="{{ old('startDateTimeMonth', $todoData->getStartDateAssociativeArray()['month']) }}" />
                    <div style="margin-top: auto;">月</div>
                    <input {{ $operatable && $todoData->getIsOnProject()? '' : 'disabled' }} type="number" name="startDateTimeDay" placeholder="日" style="width: 2em;"
                        max="31" min="1"
                        value="{{ old('startDateTimeDay', $todoData->getStartDateAssociativeArray()['day']) }}" />
                    <div style="margin-top: auto;">日</div>
                    <input {{ $operatable && $todoData->getIsOnProject()? '' : 'disabled' }} type="number" name="startDateTimeHour" placeholder="時" style="width: 2em;"
                        max="23" min="0"
                        value="{{ old('startDateTimeHour', $todoData->getStartDateAssociativeArray()['hour']) }}" />
                    <div style="margin-top: auto;">時</div>
                    <input {{ $operatable && $todoData->getIsOnProject()? '' : 'disabled' }} type="number" name="startDateTimeMinute" placeholder="分" style="width: 2em;"
                        max="59" min="0"
                        value="{{ old('startDateTimeMinute', $todoData->getStartDateAssociativeArray()['minute']) }}" />
                    <div style="margin-top: auto;">分</div>
                </div>
            </div>
            <div class="error">
                {{ $errors->first('startDateTimeYear')?:$errors->first('startDateTimeMonth')?:$errors->first('startDateTimeDay')
                    ?:$errors->first('startDateTimeHour')?:$errors->first('startDateTimeMinute') }}
            </div>
        </div>

        <div class="input_label">
            <div class="input_label_core">
                <div class="input_name">やることの締め切り日時</div>
                <div class="inputs">
                    <input {{ $operatable && $todoData->getIsOnProject()? '' : 'disabled' }} type="number" name="finishDateTimeYear" placeholder="年" style=":width: 4em;"
                        max="2200" min="1980"
                        value="{{ old('finishDateTimeYear', $todoData->getFinishDateAssociativeArray()['year'])  }}" />
                    <div style="margin-top: auto;">年</div>
                    <input {{ $operatable && $todoData->getIsOnProject()? '' : 'disabled' }} type="number" name="finishDateTimeMonth" placeholder="月" style="width: 2em;"
                        max="12" min="1"
                        value="{{ old('finishDateTimeMonth', $todoData->getFinishDateAssociativeArray()['month']) }}" />
                    <div style="margin-top: auto;">月</div>
                    <input {{ $operatable && $todoData->getIsOnProject()? '' : 'disabled' }} type="number" name="finishDateTimeDay" placeholder="日" style="width: 2em;"
                        max="31" min="1"
                        value="{{ old('finishDateTimeDay', $todoData->getFinishDateAssociativeArray()['day']) }}" />
                    <div style="margin-top: auto;">日</div>
                    <input {{ $operatable && $todoData->getIsOnProject()? '' : 'disabled' }} type="number" name="finishDateTimeHour" placeholder="時" style="width: 2em;"
                        max="23" min="0"
                        value="{{ old('finishDateTimeHour', $todoData->getFinishDateAssociativeArray()['hour']) }}" />
                    <div style="margin-top: auto;">時</div>
                    <input {{ $operatable && $todoData->getIsOnProject()? '' : 'disabled' }} type="number" name="finishDateTimeMinute" placeholder="分" style="width: 2em;"
                        max="59" min="0"
                        value="{{ old('finishDateTimeMinute', $todoData->getFinishDateAssociativeArray()['minute']) }}" />
                    <div style="margin-top: auto;">分</div>
                </div>
            </div>
            <div class="error">
                {{ $errors->first('finishDateTimeYear')?:$errors->first('finishDateTimeMonth')?:$errors->first('finishDateTimeDay')
                    ?:$errors->first('finishDateTimeHour')?:$errors->first('finishDateTimeMinute') }}
            </div>

            <br>
            <div class="input_label">
                <input {{ $operatable && $todoData->getIsOnProject()? '' : 'disabled' }} type="checkbox" id="isCopyToResponsible" name="isCopyToResponsible" 
                    value="1"
                    {{ $todoData->getIsCopyToResponsible() ?  'checked' : '' }}/>
                <label for="isCopyToResponsible" class="switch_label">
                    <div class="input_name">
                        担当者にもやることの内容を引き継がせる<br>
                        パブリックプロジェクトのやることでのみ有効
                    </div>
                    <div class="switch" style="margin-top: auto; margin-bottom: auto;">
                        <div class="circle"></div>
                        <div class="base"></div>
                    </div>
                </label>
            </div>

            <div class="error">{{ $errors->first('isCopyToResponsible') }}</div>
        </div>

        @if ($operatable && $todoData->getIsOnProject())
            <div class="input_label"><input type="submit" value="反映" class="button"></div>
        @endif

        <br>
        <div class="input_label">
            <div class="input_label">
                <input {{ $operatable? '' : 'disabled' }} type="checkbox" id="is_completed_todo" name="isCompleted" 
                    value="1"
                    {{ $todoData->getIsCompleted()? 'checked' : '' }}/>
                <label for="is_completed_todo" class="switch_label">
                    <div id="is_completed_todo_input_name" class="input_name">{{ $todoData->getIsCompleted()? '完了済み' : '完了していない' }}</div>
                    <div class="switch">
                        <div class="circle"></div>
                        <div class="base"></div>
                    </div>
                </label>
            </div>
    
            @if ($operatable)
                <script>
                    $('#is_completed_todo').change(function () {
                        let newIsCompleted = $(this).prop("checked");
                        
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: "/todo/{{ $todoData->getIsOnProject()? 'onProject' : 'onResponsible' }}/{{ $todoData->getId() }}/isCompleted",
                            type: "post",
                            data : {
                                isCompleted : newIsCompleted ? 1 : 0,
                            },
                        })
                        .done((res)=>{
                            $("#is_completed_todo_input_name").text(newIsCompleted? '完了済み' : '完了していない');
                        })
                        .fail((error)=>{
                            $(this).removeAttr("checked");
                            console.log(error.statusText)
                        })
                    });
                </script>
            @endif
        </div>
    </form>

    <br>
    @if (!$projectData->getIsPrivate() && $todoData->getIsOnProject())
        <div>
            <a href="/todo/onProject/{{ $todoData->getId() }}/responsibleList">担当者一覧へ</a>
        </div>
        <br>
    @endif

    @if ($operatable)
        <div>
            <a class="a_in_contents" id="todo_delete_a">やることを削除する</a>
            <br>
            <form class="node" id="todo_delete_form" action="/todo/onProject/{{ $todoData->getId() }}/delete" method="POST">
                @csrf
            </form>
            <script>
                $('#todo_delete_a').click(function () {
                    $('#todo_delete_form').submit();
                });
            </script>
        </div>

    @elseif (!$todoData->getIsOnProject())
        <div>
            <a class="a_in_contents" id="todo_on_responsible_exit_a">担当を辞退する</a>
            <br>
            <form class="node" id="todo_on_responsible_exit_form" action="/todo/onResponsible/{{ $projectData->getId() }}/exit" method="POST">
                @csrf
            </form>
            <script>
                $('#todo_on_responsible_exit_a').click(function () {
                    $('#todo_on_responsible_exit_form').submit();
                });
            </script>
        </div>
    @endif

    <br>
    <h3>内容</h3>
    @if ($operatable)
        <div class="content" style="display: block; background-color: rgb(114, 247, 154);">
            <div style="display: flex;">            
                <div class="input_label" style="width: 100%; margin-bottom: 0; margin-right: 0.3em;">
                    <div class="input_label_core" style="width: 100%">
                        <input style="width: 100%" type="text" id="content_add_title_input" placeholder="内容のタイトル"/>
                    </div>
                    <div id="error_for_content_add_title_input" class="error"></div>
                </div>
                <div class="img_block" style="margin-left: auto;  margin-top: auto; margin-bottom: auto;">
                    <input id="content_{{ $todoData->getId() }}_add" type="submit" value="追加" class="button" style="font-size: 0.7em;">
                </div>
            </div>
            <div class="content_explanation" id="content_add_{{ $todoData->getId() }}_explanation" style="margin-top: 0.25em;">
                <div class="input_label" style="margin-bottom: 0;">
                    <div class="input_label_core">
                        <textarea style="width: 100%; resize: none; font-size: 0.7em;" id="content_add_explanation_input" placeholder="内容の説明"></textarea>
                    </div>
                    <div class="error_for_content_add_explanation_input" class="error"></div>
                </div>
            </div>
        </div>
    @endif

    <br>
    <div id="content_list" style="background-color: rgb(88, 157, 247);">
        <div id="dummy_content" class="none">
            <div id="content_$contentId" class="content" style="display: flex;">
                <div class="is_completed" id="content_$contentId_is_comleted" style="margin-right: auto; margin-top: auto; margin-bottom: auto;">
                    <img src="{{ asset('img/check.png') }}" class="none" style="height: 1em; width: 1em;">
                </div>
                <div style="width: 100%;">
                    <div style="display: flex;">
                        <div class="input_label" style="width: 100%; margin-bottom: 0;">
                            <div class="input_label_core" style="width: 100%">
                                <input {{ $operatable? '' : 'disabled' }} style="width: 100%" type="text" id="content_$contentId_title" placeholder="内容のタイトル" value="$contentTitle" />
                            </div>
                        </div>
                        <div class="img_block" style="display: flex; margin-left: auto; width: 4.5em; height: 1.5em; margin-top: auto; margin-bottom: auto;">
                            <img id="content_$contentId_save" src="{{ asset('img/save.png') }}"
                                style="width: 1.5em; height: 1.5em;">
                            <img id="content_$contentId_delete" src="{{ asset('img/close.png') }}"
                                style="width: 1.5em; height: 1.5em;">
                            <img id="content_$contentId_switch" src="{{ asset('img/triangle.png') }}"
                                style="width: 1.5em; height: 1.5em; transform: rotate(-90deg);">
                        </div>
                    </div>
                    <div class="content_explanation leaved" id="content_$contentId_explanation" style="margin-top: 0.25em;">
                        <div class="input_label" style="margin-bottom: 0;">
                            <div class="input_label_core">
                                <textarea {{ $operatable? '' : 'disabled' }} id="content_$contentId_explanation" name="content_$contentId_explanation" placeholder="内容の説明" >$contentExplanation</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if ($operatable)
                <script>
                    let content_newIsCompleted_$contentId = false;
                    $('#content_$contentId_is_comleted').click(function () {
                        content_newIsCompleted_$contentId = !content_newIsCompleted_$contentId;
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: "/content/$contentId/isCompleted",
                            type: "post",
                            data : {
                                isCompleted : content_newIsCompleted_$contentId ? 1 : 0,
                            },
                        })
                        .done((res)=>{
                            if(content_newIsCompleted_$contentId){
                                $(this).children('img').removeClass('none');
                            }else{
                                $(this).children('img').addClass('none');
                            }
                        })
                        .fail((error)=>{
                            console.log(error.statusText)
                        })
                    });

                    $('#content_$contentId_delete').click(function () {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: "/content/$contentId/delete",
                            type: "post"
                        })
                        .done((res)=>{
                            $('#content_$contentId').remove();
                        })
                        .fail((error)=>{
                            confirm('削除できませんでした。操作をする権限がない可能性があります。');

                            console.log(error.statusText)
                        })
                    });

                    $('#content_$contentId_save').click(function () {
                        let newTitle = $('#content_$contentId_title').val();
                        let newExplanation = $('textarea#content_$contentId_explanation').val();

                        if(newTitle === null || newTitle === '' || newTitle.length > 100){
                            confirm('内容のタイトルは必須なので100文字以内でご入力ください。');
                            return;
                        }
                        
                        if(newExplanation === null || newExplanation === '' || newExplanation.length > 2000){
                            confirm('内容の説明は必須なので2000文字以内でご入力ください。');
                            return;
                        }

                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: "/content/$contentId/update",
                            type: "post",
                            data : {
                                title : newTitle,
                                explanation : newExplanation,
                            },
                        })
                        .done((res)=>{
                            confirm('反映しました。');
                        })
                        .fail((error)=>{
                            confirm('反映できませんでした。操作をする権限がない可能性があります。');
                            console.log(error.statusText)
                        })
                    });
                </script>
            @endif
            <script>
                let contentExplanationVisible_$contentId = false;
                $('#content_$contentId_switch').click(function () {
                    contentExplanationVisible_$contentId = !contentExplanationVisible_$contentId;

                    if(contentExplanationVisible_$contentId){
                        $('#content_$contentId_explanation')
                            .removeClass('leaved')
                            .addClass('visabled');
                        $(this).css('transform', 'rotate(90deg)')
                            .css('transition', '1s');
                    }else{
                        $('#content_$contentId_explanation')
                            .removeClass('visabled')
                            .addClass('leaved'); 
                        $(this).css('transform', 'rotate(-90deg)')
                            .css('transition', '1s');
                    }
                });
            </script>
        </div>
        @foreach ($todoData->getContentList() as $contentData)
            <div id="content_{{ $contentData->getId() }}" class="content" style="display: flex;">
                <div class="is_completed" id="content_{{ $contentData->getId() }}_is_comleted" style="margin-right: auto; margin-top: auto; margin-bottom: auto;">
                    <img src="{{ asset('img/check.png') }}" class="{{ $contentData->getIsCompleted()? '' : 'none' }}" style="height: 1em; width: 1em;">
                </div>
                <div style="width: 100%;">
                    <div style="display: flex;">
                        <div class="input_label" style="width: 100%; margin-bottom: 0;">
                            <div class="input_label_core" style="width: 100%">
                                <input {{ $operatable? '' : 'disabled' }} style="width: 100%" type="text" id="content_{{ $contentData->getId() }}_title" placeholder="内容のタイトル" value="{{ $contentData->getTitle() }}" />
                            </div>
                        </div>
                        <div class="img_block" style="display: flex; margin-left: auto; width: 4.5em; height: 1.5em; margin-top: auto; margin-bottom: auto;">
                            <img id="content_{{ $contentData->getId() }}_save" src="{{ asset('img/save.png') }}"
                                style="width: 1.5em; height: 1.5em;">
                            <img id="content_{{ $contentData->getId() }}_delete" src="{{ asset('img/close.png') }}"
                                style="width: 1.5em; height: 1.5em;">
                            <img id="content_{{ $contentData->getId() }}_switch" src="{{ asset('img/triangle.png') }}"
                                style="width: 1.5em; height: 1.5em; transform: rotate(-90deg);">
                        </div>
                    </div>
                    <div class="content_explanation leaved" id="content_{{ $contentData->getId() }}_explanation" style="margin-top: 0.25em;">
                        <div class="input_label" style="margin-bottom: 0;">
                            <div class="input_label_core">
                                <textarea {{ $operatable? '' : 'disabled' }} id="content_{{ $contentData->getId() }}_explanation" name="content_{{ $contentData->getId() }}_explanation" placeholder="内容の説明" >{{ $contentData->getExplanation() }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if ($operatable)
                <script>
                    let content_newIsCompleted_{{ $contentData->getId() }} = {{ $contentData->getIsCompleted()? 'true' : 'false' }};
                    $('#content_{{ $contentData->getId() }}_is_comleted').click(function () {
                        content_newIsCompleted_{{ $contentData->getId() }} = !content_newIsCompleted_{{ $contentData->getId() }};
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: "/content/{{ $contentData->getId() }}/isCompleted",
                            type: "post",
                            data : {
                                isCompleted : content_newIsCompleted_{{ $contentData->getId() }} ? 1 : 0,
                            },
                        })
                        .done((res)=>{
                            if(content_newIsCompleted_{{ $contentData->getId() }}){
                                $(this).children('img').removeClass('none');
                            }else{
                                $(this).children('img').addClass('none');
                            }
                        })
                        .fail((error)=>{
                            console.log(error.statusText)
                        })
                    });

                    $('#content_{{ $contentData->getId() }}_delete').click(function () {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: "/content/{{ $contentData->getId() }}/delete",
                            type: "post"
                        })
                        .done((res)=>{
                            $('#content_{{ $contentData->getId() }}').remove();
                        })
                        .fail((error)=>{
                            confirm('削除できませんでした。操作をする権限がない可能性があります。');

                            console.log(error.statusText)
                        })
                    });

                    $('#content_{{ $contentData->getId() }}_save').click(function () {
                        let newTitle = $('#content_{{ $contentData->getId() }}_title').val();
                        let newExplanation = $('textarea#content_{{ $contentData->getId() }}_explanation').val();

                        if(newTitle === null || newTitle === '' || newTitle.length > 100){
                            confirm('内容のタイトルは必須なので100文字以内でご入力ください。');
                            return;
                        }
                        
                        if(newExplanation === null || newExplanation === '' || newExplanation.length > 2000){
                            confirm('内容の説明は必須なので2000文字以内でご入力ください。');
                            return;
                        }

                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: "/content/{{ $contentData->getId() }}/update",
                            type: "post",
                            data : {
                                title : newTitle,
                                explanation : newExplanation,
                            },
                        })
                        .done((res)=>{
                            confirm('反映しました。');
                        })
                        .fail((error)=>{
                            confirm('反映できませんでした。操作をする権限がない可能性があります。');
                            console.log(error.statusText)
                        })
                    });
                </script>
            @endif
            <script>
                let contentExplanationVisible_{{ $contentData->getId() }} = false;
                $('#content_{{ $contentData->getId() }}_switch').click(function () {
                    contentExplanationVisible_{{ $contentData->getId() }} = !contentExplanationVisible_{{ $contentData->getId() }};

                    if(contentExplanationVisible_{{ $contentData->getId() }}){
                        $('#content_{{ $contentData->getId() }}_explanation')
                            .removeClass('leaved')
                            .addClass('visabled');
                        $(this).css('transform', 'rotate(90deg)')
                            .css('transition', '1s');
                    }else{
                        $('#content_{{ $contentData->getId() }}_explanation')
                            .removeClass('visabled')
                            .addClass('leaved'); 
                        $(this).css('transform', 'rotate(-90deg)')
                            .css('transition', '1s');
                    }
                });
            </script>
        @endforeach
    </div>
    @if ($operatable)
        <script>
            const newContentStr = $('#dummy_content').clone(true).html();
            $('#content_{{ $todoData->getId() }}_add').click(function () {
                let newTitle = $('#content_add_title_input').val();
                let newExplanation = $('#content_add_explanation_input').val();
                
                if(newTitle === null || newTitle === '' || newTitle.length > 100){
                    confirm('内容のタイトルは必須なので100文字以内でご入力ください。');
                    return;
                }
                
                if(newExplanation === null || newExplanation === '' || newExplanation.length > 2000){
                    confirm('内容の説明は必須なので2000文字以内でご入力ください。');
                    return;
                }

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "/content/insert",
                    type: "post",
                    data : {
                        title : newTitle,
                        explanation : newExplanation,
                        todoId : {{ $todoData->getId() }},
                    },
                })
                .done((res)=>{
                    $newContentId = res['contentId'];
                    $('#content_list').append(newContentStr
                        .split('$contentId').join($newContentId)
                        .split('$contentTitle').join(newTitle)
                        .split('$contentExplanation').join(newExplanation)
                    );
                    $('#content_add_title_input').val('');
                    $('#content_add_explanation_input').val('');
                })
                .fail((error)=>{
                    console.log(error.statusText)
                })
            });
        </script>
    @endif
@endsection
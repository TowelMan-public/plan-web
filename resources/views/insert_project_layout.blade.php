@extends('default_layout')

@section('page_name') 
    プロジェクト作成
@endsection

@section('title_name')
プロジェクト作成
@endsection

@section('contents')
    @if (isset($formError))
        <div class="error">{{ $formError }}</div>
    @endif
    
    <form id="insert_project_form" action="/project/public/insert" method="post">
        @csrf

        <div class="input_label">
            <div class="input_label_core">
                <div class="input_name">プロジェクト名</div>
                <input type="text" name="name" placeholder="プロジェクト名" value="{{ old('name', '') }}" />
            </div>
            <div class="error">{{ $errors->first('name') }}</div>
        </div>

        <div class="input_label">
            <div class="input_label_core">
                <div class="input_name">プロジェクトの種類</div>
                <select id="is_private" name="isPrivate">
                    <option value="0" {{ old('isPrivate', false)? '' : 'selected' }}>パブリック</option>
                    <option value="1" {{ old('isPrivate', false)? 'selected' : '' }}>プライベート</option>
                </select>
            </div>
            <div class="error">{{ $errors->first('isPrivate') }}</div>
        </div>

        <div id="inputs_for_public_project">
            <div class="input_label">
                <div class="input_label_core">
                    <div class="input_name">プロジェクトの開始日時</div>
                    <div class="inputs">
                        <input type="number" name="startDateTimeYear" placeholder="年" style=":width: 4em;"
                            max="2200" min="1980"
                            value="{{ old('startDateTimeYear', '')  }}" />
                        <div style="margin-top: auto;">年</div>
                        <input type="number" name="startDateTimeMonth" placeholder="月" style="width: 2em;"
                            max="12" min="1"
                            value="{{ old('startDateTimeMonth', '') }}" />
                        <div style="margin-top: auto;">月</div>
                        <input type="number" name="startDateTimeDay" placeholder="日" style="width: 2em;"
                            max="31" min="1"
                            value="{{ old('startDateTimeDay', '') }}" />
                        <div style="margin-top: auto;">日</div>
                        <input type="number" name="startDateTimeHour" placeholder="時" style="width: 2em;"
                            max="23" min="0"
                            value="{{ old('startDateTimeHour', '') }}" />
                        <div style="margin-top: auto;">時</div>
                        <input type="number" name="startDateTimeMinute" placeholder="分" style="width: 2em;"
                            max="59" min="0"
                            value="{{ old('startDateTimeMinute', '') }}" />
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
                        <input type="number" name="finishDateTimeYear" placeholder="年" style=":width: 4em;"
                            max="2200" min="1980"
                            value="{{ old('finishDateTimeYear', '')  }}" />
                        <div style="margin-top: auto;">年</div>
                        <input type="number" name="finishDateTimeMonth" placeholder="月" style="width: 2em;"
                            max="12" min="1"
                            value="{{ old('finishDateTimeMonth', '') }}" />
                        <div style="margin-top: auto;">月</div>
                        <input type="number" name="finishDateTimeDay" placeholder="日" style="width: 2em;"
                            max="31" min="1"
                            value="{{ old('finishDateTimeDay', '') }}" />
                        <div style="margin-top: auto;">日</div>
                        <input type="number" name="finishDateTimeHour" placeholder="時" style="width: 2em;"
                            max="23" min="0"
                            value="{{ old('finishDateTimeHour', '') }}" />
                        <div style="margin-top: auto;">時</div>
                        <input type="number" name="finishDateTimeMinute" placeholder="分" style="width: 2em;"
                            max="59" min="0"
                            value="{{ old('finishDateTimeMinute', '') }}" />
                        <div style="margin-top: auto;">分</div>
                    </div>
                </div>
                <div class="error">{{ $errors->first('finishDateTimeYear')?:$errors->first('finishDateTimeMonth')?:$errors->first('finishDateTimeDay')
                ?:$errors->first('finishDateTimeHour')?:$errors->first('finishDateTimeMinute') }}</div>

                <div class="error">{{ $errors->first('dateTimeError') }}</div>
            </div>
        </div>

        <div class="input_label"><input type="submit" value="作成" class="button"></div>
    </form>
    <script>
        function changeToPrivateForm(){
            let inputsForPublicProject = $('#inputs_for_public_project');
            let insertProjectForm = $('#insert_project_form');
            
            insertProjectForm.attr('action', '/project/private/insert');
            inputsForPublicProject.addClass('leaved');
            inputsForPublicProject.removeClass('visabled');
        }

        function changeToPublicForm(){
            let inputsForPublicProject = $('#inputs_for_public_project');
            let insertProjectForm = $('#insert_project_form');
            
            insertProjectForm.attr('action', '/project/public/insert');
            inputsForPublicProject.addClass('visabled');
            inputsForPublicProject.removeClass('leaved');
        }

        function changeByIsPrivate(isPrivate){
            if(isPrivate === '1'){
                changeToPrivateForm();
            }else{
                changeToPublicForm();
            }
        }

        //初期イベント
        changeByIsPrivate($("#is_private").val());

        //イベント定義
        $("#is_private").change(function(){
            changeByIsPrivate($(this).val());
        });
    </script>
@endsection
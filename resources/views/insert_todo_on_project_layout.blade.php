@extends('default_layout')

@section('page_name') 
    {{ $projectData->getName() }}のやること作成
@endsection

@section('title_name')
    {{ $projectData->getName() }}のやること作成
@endsection

@section('contents_menu')
    <li><a href="/project/{{ $projectData->getIsPrivate()? 'private' : 'public' }}/{{ $projectData->getId() }}">プロジェクト</a></li>
    <li><a href="/project/{{ $projectData->getIsPrivate()? 'private' : 'public' }}/{{ $projectData->getId() }}/todo/onProject/month">やることリスト</a></li>
@endsection

@section('contents')
    <form action="/project/{{ $projectData->getIsPrivate()? 'private' : 'public' }}/{{ $projectData->getId() }}/todo/insert" method="post">
        @csrf

        @if ($formError !== null)
            <div class="error">{{ $formError }}</div>
        @endif

        <h3>やること</h3>
        <div class="input_label">
            <div class="input_label_core">
                <div class="input_name">やることの名前</div>
                <input type="text" name="todoName" placeholder="やることの名前" value="{{ old('todoName', '') }}" />
            </div>
            <div class="error">{{ $errors->first('todoName') }}</div>
        </div>

        <div class="input_label">
            <div class="input_label_core">
                <div class="input_name">やることの開始日時</div>
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
            <div class="error">
                {{ $errors->first('startDateTimeYear')?:$errors->first('startDateTimeMonth')?:$errors->first('startDateTimeDay')
                    ?:$errors->first('startDateTimeHour')?:$errors->first('startDateTimeMinute') }}
            </div>
        </div>

        <div class="input_label">
            <div class="input_label_core">
                <div class="input_name">やることの締め切り日時</div>
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
            <div class="error">
                {{ $errors->first('finishDateTimeYear')?:$errors->first('finishDateTimeMonth')?:$errors->first('finishDateTimeDay')
                    ?:$errors->first('finishDateTimeHour')?:$errors->first('finishDateTimeMinute') }}
            </div>

            <br>
            <div class="input_label">
                <input type="checkbox" id="isCopyToResponsible" name="isCopyToResponsible" 
                    value="1"
                    {{ old('isCopyToResponsible', false)? 'checkd' : '' }}/>
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

            <div class="error">{{ $errors->first('dateTimeError') }}</div>
        </div>

        <h3>内容</h3>
        <div id="content_list" style="background-color: rgb(54, 139, 250);">
            <input type="checkbox" class="none" id="content_array_last_index" value="{{ count(old('contentArray', [])) - 1 }}" >
            
            @for ($i = 0; $i < count(old('contentArray', [])); $i++)
                <div id="content_{{ $i }}" class="content" style="display: block;">
                    <div style="display: flex;">
                        <input type="hidden" id="content_{{ $i }}_explanation_visible" value="{{ $errors->first('contentArray.'.$i.'.explanation') === '' ? false: true }}">
                        <div class="input_label" style="width: 100%; margin-bottom: 0;">
                            <div class="input_label_core" style="width: 100%">
                                <input style="width: 100%" type="text" name="contentArray[{{ $i }}][title]" placeholder="内容のタイトル" value="{{ old('contentArray.'.$i.'.title', '') }}" />
                            </div>
                            <div class="error">{{ $errors->first('contentArray.'.$i.'.title') }}</div>
                        </div>
                        <div class="img_block" style="display: flex; margin-left: auto; width: 3em; height: 1.5em; margin-top: auto; margin-bottom: auto;">
                            <img id="content_{{ $i }}_delete" src="{{ asset('img/close.png') }}"
                                style="width: 1.5em; height: 1.5em;">
                            <img id="content_{{ $i }}_switch" src="{{ asset('img/triangle.png') }}"
                                style="width: 1.5em; height: 1.5em; transform: rotate({{ $errors->first('contentArray.'.$i.'.explanation') === '' ? '-' : '' }}90deg);">
                        </div>
                    </div>
                    <div class="content_explanation {{ $errors->first('contentArray.'.$i.'.explanation') === '' ? 'leaved' : '' }}" id="content_{{ $i }}_explanation" style="margin-top: 0.25em;">
                        <div class="input_label" style="margin-bottom: 0;">
                            <div class="input_label_core">
                                <textarea style="width: 100%; resize: none; font-size: 0.7em;" name="contentArray[{{ $i }}][explanation]" placeholder="内容の説明" >{{ old('contentArray.'.$i.'.explanation', '') }}</textarea>
                            </div>
                            <div class="error">{{ $errors->first('contentArray.'.$i.'.explanation') }}</div>
                        </div>
                    </div>
                </div>
                <script>
                    $('#content_{{ $i }}_delete').click(function () {
                        $('#content_{{ $i }}').remove();
                    });

                    $('#content_{{ $i }}_switch').click(function () {
                        let visible = !$('#content_{{ $i }}_explanation_visible').val();

                        if(visible){
                            $('#content_{{ $i }}_explanation')
                                .removeClass('leaved')
                                .addClass('visabled');
                            $(this).css('transform', 'rotate(90deg)')
                                .css('transition', '1s');
                        }else{
                            $('#content_{{ $i }}_explanation')
                                .removeClass('visabled')
                                .addClass('leaved'); 
                            $(this).css('transform', 'rotate(-90deg)')
                                .css('transition', '1s');
                        }

                        $('#content_{{ $i }}_explanation_visible').val(visible? 1 : null);
                    })
                </script>
            @endfor
        </div>
        <div style="text-align: center;">
            <img id="add_content" src="{{ asset('img/plus.png') }}" class="add_content_img">
        </div>     

        <div class="input_label"><input type="submit" value="作成" class="button"></div>
    </form>

    <div class="none" id="dummy_for_new_content_dom">
        <div class="content" style="display: block;" id="content_$index">
            <div style="display: flex;">
                <input type="hidden" id="content_$index_explanation_visible" value="{{ false }}">
                <div class="input_label" style="width: 100%; margin-bottom: 0;">
                    <div class="input_label_core" style="width: 100%;">
                        <input style="width: 100%;" type="text" name="contentArray[$index][title]" placeholder="内容のタイトル" value="" />
                    </div>
                </div>
                <div class="img_block" style="display: flex; margin-left: auto; width: 3em; height: 1.5em; margin-top: auto; margin-bottom: auto;">
                    <img id="content_$index_delete" src="{{ asset('img/close.png') }}"
                        style="width: 1.5em; height: 1.5em;">
                    <img id="content_$index_switch" src="{{ asset('img/triangle.png') }}"
                        style="width: 1.5em; height: 1.5em; transform: rotate(-90deg);">
                </div>            
            </div>
            <div class="content_explanation leaved" id="content_$index_explanation" style="margin-top: 0.25em;">
                <div class="input_label" style="margin-bottom: 0;">
                    <div class="input_label_core">
                        <textarea style="width: 100%; resize: none; font-size: 0.7em;" name="contentArray[$index][explanation]" placeholder="内容の説明" value="" ></textarea>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $('#content_$index_delete').click(function () {
                $('#content_$index').remove();
            });

            $('#content_$index_switch').click(function () {
                let visible = !$('#content_$index_explanation_visible').val();

                if(!$('#content_$index_explanation_visible').val()){
                    $('#content_$index_explanation')
                        .removeClass('leaved')
                        .addClass('visabled');
                    $(this).css('transform', 'rotate(90deg)')
                            .css('transition', '1s');
                }else{
                    $('#content_$index_explanation')
                        .removeClass('visabled')
                        .addClass('leaved');                 
                    $(this).css('transform', 'rotate(-90deg)')
                        .css('transition', '1s');

                }

                $('#content_$index_explanation_visible').val(visible? 1 : null);
            })
        </script>
    </div>

    <script>
        $('#add_content').click(function (){
            const newContentStr = $('#dummy_for_new_content_dom').clone(true).html();
            let index = Number($('#content_array_last_index').val()) + 1;                

            $('#content_list').append(newContentStr.split('$index').join(index));
            $('#content_array_last_index').val(index);
        });
    </script>
@endsection

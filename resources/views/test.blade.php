@extends('default_layout')

@section('page_name') 
    パブリックプロジェクト
@endsection

@section('title_name')
    パブリックプロジェクト
@endsection

@section('contents_menu')
    <li><a href="#">やること系</a></li>
@endsection

@section('contents')
    
@endsection

//メモ
<div class="input_label">
    <input type="checkbox" id="is_completed" name="isCompleted" 
        value="1"
        {{ (isset($projectData)? $projectData->isCompleted : old('isCompleted', false))? 'checked' : '' }}/>
    <label for="is_completed" class="switch_label">
        <div id="is_completed_input_name" class="input_name">{{ (isset($projectData)? $projectData->isCompleted : old('isCompleted', false))? '完了済み' : '完了していない' }}</div>
        <div class="switch">
            <div class="circle"></div>
            <div class="base"></div>
        </div>
    </label>
    <script>
        $('#is_completed').change(function () {
            let newIsCompleted = typeof attr !== 'undefined' && attr !== false;
            
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/project/private/{{ $projectId }}/isCompleted",
                type: "post",
                data : {
                    isCompleted : newIsCompleted,
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
</div>
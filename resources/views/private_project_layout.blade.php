@extends('default_layout')

@section('page_name') 
    {{ $projectName }}
@endsection

@section('title_name')
    {{ $projectName }}
@endsection

@section('contents_menu')
    <li><a href="#">やること系</a></li>
@endsection

@section('contents')
    <form action="/project/private/{{ $projectId }}/update" method="post">
        @csrf

        <div class="input_label">
            <div class="input_label_core">
                <div class="input_name">プロジェクト名</div>
                <input type="text" name="projectName" placeholder="プロジェクト名" value="{{ isset($projectName)? $projectName : old('projectName', '') }}" />
            </div>
            <div class="error">{{ $errors->first('projectName') }}</div>
        </div>
        <div class="input_label"><input type="submit" value="反映" class="button"></div>
    </form>

    <div>
        <a class="a_in_contents" id="project_delete_a">このプライベートプロジェクトを削除する</a>
        <form class="node" id="project_delete_form" action="/project/private/{{ $projectId }}/delete" method="POST">
            @csrf
        </form>
        <script>
            $('#project_delete_a').click(function () {
                $('#project_delete_form').submit();
            });
        </script>
    </div>
@endsection
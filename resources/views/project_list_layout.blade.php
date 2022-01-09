@extends('default_layout')

@section('page_name') 
    @if (isset($isInvitation))
        勧誘されているプロジェクト一覧
    @else
        プロジェクト一覧
    @endif
@endsection

@section('title_name')
    <div>
        @if (isset($isInvitation))
            勧誘されているプロジェクト一覧
        @else
            プロジェクト一覧
        @endif
    </div>
@endsection

@section('contents_menu')
    <li><a href="/me/project/list/invitation">勧誘一覧</a></li>
    @if($includeCompleted !==null)
        <li><a href="/me/project/list/invitation">完了を非表示</a></li>
    @else
        <li><a href="/me/project/list?includeCompleted=1">完了を表示</a></li>
    @endif

    @if($unIncludePrivate !== null)
        <li><a href="/me/project/list{{ $includeCompleted !==null? '?includeCompleted=1' : '' }}">プライベート表示</a></li>        
    @else
        <li><a href="/me/project/list?unIncludePrivate=1{{ $includeCompleted !==null? '&includeCompleted=1' : '' }}">プライベート非表示</a></li>
    @endif

    <li><a href="/me/project/month">月ごとに表示</a></li>
@endsection

@section('contents')

    @foreach ($projectListData->getPrivateProjectList() as $data)
        <div id="private_project_{{ $data->getId() }}" class="project" style="background-color: aqua;">
            
            <div class="is_private">プライベート</div>

            <div class="text">
                <div class="name">
                    {{ $data->getName() }}
                </div>
            </div>

        </div>
        <script>
            $('#private_project_{{ $data->getId() }}').click(function () {
                window.location.href = "/project/private/{{ $data->getId() }}";
            });
        </script>
    @endforeach
    
    @foreach ($projectListData->getExpiredProjectList() as $data)
        <div class="project"  id="public_project_{{ $data->getId() }}"
            style="
                border-color: rgb(189, 15, 15);
                background-color: rgb(255, 0, 0);">

            <div class="text">
                <div class="name">
                    {{ $data->getName() }}
                </div>
                <div class="date_string">
                    {{ '開始日時: '.$data->getStartDateString() }}
                </div>
                <div class="date_string">
                    {{ '締め切り日時: '.$data->getFinishDateString() }}
                </div>
            </div>

            <div class="is_completed">
                @if ($data->getIsCompleted())
                    <img src="{{ asset('img/check.png') }}">
                @endif
            </div>

        </div>
        <script>
            $('#public_project_{{ $data->getId() }}').click(function () {
                window.location.href = "/project/public/{{ $data->getId() }}";
            });
        </script>
    @endforeach

    @foreach ($projectListData->getApproachingProjectList() as $data)
        <div class="project" id="public_project_$data->getId() }}" style="background-color: rgb(255, 111, 0);">

            <div class="text">
                <div class="name">
                    {{ $data->getName() }}
                </div>
                <div class="date_string">
                    {{ '開始日時: '.$data->getStartDateString() }}
                </div>
                <div class="date_string">
                    {{ '締め切り日時: '.$data->getFinishDateString() }}
                </div>
            </div>

            <div class="is_completed">
                @if ($data->getIsCompleted())
                    <img src="{{ asset('img/check.png') }}">
                @endif
            </div>

        </div>
        <script>
            $('#public_project_{{ $data->getId() }}').click(function () {
                window.location.href = "/project/public/{{ $data->getId() }}";
            });
        </script>
    @endforeach

    @foreach ($projectListData->getOtherProjectList() as $data)
        <div class="project" id="public_project_{{ $data->getId() }}" style="background-color: rgb(67, 193, 4);">

            <div class="text">
                <div class="name">
                    {{ $data->getName() }}
                </div>
                <div class="date_string">
                    {{ '開始日時: '.$data->getStartDateString() }}
                </div>
                <div class="date_string">
                    {{ '締め切り日時: '.$data->getFinishDateString() }}
                </div>
            </div>

            <div class="is_completed">
                @if ($data->getIsCompleted())
                    <img src="{{ asset('img/check.png') }}">
                @endif
            </div>

        </div>
        <script>
            $('#public_project_{{ $data->getId() }}').click(function () {
                window.location.href = "/project/public/{{ $data->getId() }}";
            });
        </script>
    @endforeach

@endsection
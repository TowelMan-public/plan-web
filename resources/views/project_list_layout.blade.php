@extends('default_layout')

@section('page_name') 
    今日のやること
@endsection

@section('title_name')
    <div>プロジェクト一覧</div>
@endsection

@section('contents_menu')
    <li><a href="#">完了を表示</a></li>
    <li><a href="#">プライベート非表示</a></li>
    <li><a href="#">月ごとに表示</a></li>
@endsection

@section('contents')

    @foreach ($projectListData->getPrivateProjectList() as $data)
        <div class="project" style="background-color: aqua;">
            
            <div class="is_private">プライベート</div>

            <div class="text">
                <div class="name">
                    {{ $data->getName() }}
                </div>
            </div>

        </div>
    @endforeach
    
    @foreach ($projectListData->getExpiredProjectList() as $data)
        <div class="project" 
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
    @endforeach

    @foreach ($projectListData->getApproachingProjectList() as $data)
        <div class="project" style="background-color: rgb(255, 111, 0);">

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
    @endforeach

    @foreach ($projectListData->getOtherProjectList() as $data)
        <div class="project" style="background-color: rgb(67, 193, 4);">

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
    @endforeach

@endsection
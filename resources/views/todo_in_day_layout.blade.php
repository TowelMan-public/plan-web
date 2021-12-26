@extends('default_layout')

@section('page_name') 
    今日のやること
@endsection

@section('title_name')
    <div>今日のやること</div>
@endsection

@section('title_bar_contents')
    <div class="dateStringBar">
        <img src="{{ asset('img/triangle.png') }}">
        <div class="dateString">{{ $dateAssociativeArray['year'].'-'.$dateAssociativeArray['month'].'-'.$dateAssociativeArray['day'] }}</div>
        <img src="{{ asset('img/triangle.png') }}"
            style="transform: rotate(180deg);">
    </div>
@endsection

@section('contents_menu')
    <li><a href="#">完了を非表示</a></li>
@endsection

@section('contents')

    @foreach ($todoInDay->getExpiredTodoList() as $todo)
        
        <div class="todo"
            style="
                border-color: rgb(189, 15, 15);
                background-color: rgb(255, 0, 0);">
                
            <div class="inner">
                <div class="name">{{ $todo->getName() }}</div>

                <div class="hamburger_img">
                    <img src="{{ asset('img/plus.png') }}">
                    <img class="none" src="{{ asset('img/close.png') }}">
                </div>

                <div class="is_completed">
                    @if ($todo->getIsCompleted())
                        <img src="{{ asset('img/check.png') }}">
                    @endif                    
                </div>
            </div>

            <div class="contents none">
                @foreach ($todo->getContentList() as $content)
                    <div class="content">
                        <div class="name">{{ $content->getTitle() }}</div>

                        <div class="is_completed">
                            @if ($content->getIsCompleted())
                                <img src="{{ asset('img/check.png') }}">
                            @endif   
                        </div>
                    </div>
                @endforeach                
            </div>
        </div>

    @endforeach

    @foreach ($todoInDay->getApproachingTodoList() as $todo)
        
        <div class="todo"
            style="
                border-color: rgb(160, 72, 21);
                background-color: rgb(160, 72, 21);">
                
            <div class="inner">
                <div class="name">{{ $todo->getName() }}</div>

                <div class="hamburger_img">
                    <img src="{{ asset('img/plus.png') }}">
                    <img class="none" src="{{ asset('img/close.png') }}">
                </div>

                <div class="is_completed">
                    @if ($todo->getIsCompleted())
                        <img src="{{ asset('img/check.png') }}">
                    @endif                    
                </div>
            </div>

            <div class="contents none">
                @foreach ($todo->getContentList() as $content)
                    <div class="content">
                        <div class="name">{{ $content->getTitle() }}</div>

                        <div class="is_completed">
                            @if ($content->getIsCompleted())
                                <img src="{{ asset('img/check.png') }}">
                            @endif   
                        </div>
                    </div>
                @endforeach                
            </div>
        </div>

    @endforeach

    @foreach ($todoInDay->getTodaysTodoList() as $todo)
        
        <div class="todo"
            style="
                border-color: rgb(67, 193, 4);
                background-color: rgb(67, 193, 4);">
                
            <div class="inner">
                <div class="name">{{ $todo->getName() }}</div>

                <div class="hamburger_img">
                    <img src="{{ asset('img/plus.png') }}">
                    <img class="none" src="{{ asset('img/close.png') }}">
                </div>

                <div class="is_completed">
                    @if ($todo->getIsCompleted())
                        <img src="{{ asset('img/check.png') }}">
                    @endif                    
                </div>
            </div>

            <div class="contents none">
                @foreach ($todo->getContentList() as $content)
                    <div class="content">
                        <div class="name">{{ $content->getTitle() }}</div>

                        <div class="is_completed">
                            @if ($content->getIsCompleted())
                                <img src="{{ asset('img/check.png') }}">
                            @endif   
                        </div>
                    </div>
                @endforeach                
            </div>
        </div>

    @endforeach

    @foreach ($todoInDay->getOtherTodoList() as $todo)
        
        <div class="todo"
            style="
                border-color: rgb(81, 80, 101);
                background-color: rgb(81, 80, 101);">
                
            <div class="inner">
                <div class="name">{{ $todo->getName() }}</div>

                <div class="hamburger_img">
                    <img src="{{ asset('img/plus.png') }}">
                    <img class="none" src="{{ asset('img/close.png') }}">
                </div>

                <div class="is_completed">
                    @if ($todo->getIsCompleted())
                        <img src="{{ asset('img/check.png') }}">
                    @endif                    
                </div>
            </div>

            <div class="contents none">
                @foreach ($todo->getContentList() as $content)
                    <div class="content">
                        <div class="name">{{ $content->getTitle() }}</div>

                        <div class="is_completed">
                            @if ($content->getIsCompleted())
                                <img src="{{ asset('img/check.png') }}">
                            @endif   
                        </div>
                    </div>
                @endforeach                
            </div>
        </div>

    @endforeach

@endsection
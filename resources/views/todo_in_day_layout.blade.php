@extends('default_layout')

@section('page_name') 
    @if ($projectData === null)
        一日の自分のやること
    @else
        一日の{{ $projectData->getName() }}のやること
    @endif
@endsection

@section('title_name')
    <div>
        @if ($projectData === null)
            一日の自分のやること
        @else
            一日の{{ $projectData->getName() }}のやること
        @endif
    </div>
@endsection

@section('title_bar_contents')
    <div class="dateStringBar">
        <img id="back_day" src="{{ asset('img/triangle.png') }}">
        <div class="dateString">{{ $dateAssociativeArray['year'].'-'.$dateAssociativeArray['month'].'-'.$dateAssociativeArray['day'] }}</div>
        <img id="next_day" src="{{ asset('img/triangle.png') }}"
            style="transform: rotate(180deg);">
    </div>

    @if ($projectData === null)
        <script>
            $('#back_day').click(function(){
                window.location.href = "/me/todo/day/{{ $dateAssociativeArray['year'] }}/{{ $dateAssociativeArray['month'] }}/{{ $dateAssociativeArray['day'] }}/back{{ $includeCompleted === null ? '' : '?includeCompleted=1' }}";
            });

            $('#next_day').click(function(){
                window.location.href = "/me/todo/day/{{ $dateAssociativeArray['year'] }}/{{ $dateAssociativeArray['month'] }}/{{ $dateAssociativeArray['day'] }}/next{{ $includeCompleted === null ? '' : '?includeCompleted=1' }}";
            });
        </script>
    @else
        <script>
            $('#back_day').click(function(){
                window.location.href = "/project/{{ $projectData->getIsPrivate()? 'private' : 'public' }}/{{ $projectData->getId() }}/todo/" + 
                    "{{ $projectData->getIsPrivate() || $mySubscriberData !== null ? 'onProject' : 'onResponsible' }}/day/{{ $dateAssociativeArray['year'] }}/{{ $dateAssociativeArray['month'] }}/{{ $dateAssociativeArray['day'] }}/back{{ $includeCompleted === null ? '' : '?includeCompleted=1' }}";
            });

            $('#next_day').click(function(){
                window.location.href = "/project/{{ $projectData->getIsPrivate()? 'private' : 'public' }}/{{ $projectData->getId() }}/todo/" + 
                    "{{ $projectData->getIsPrivate() || $mySubscriberData !== null ? 'onProject' : 'onResponsible' }}/day/{{ $dateAssociativeArray['year'] }}/{{ $dateAssociativeArray['month'] }}/{{ $dateAssociativeArray['day'] }}/next{{ $includeCompleted === null ? '' : '?includeCompleted=1' }}";
            });
        </script>
    @endif
@endsection

@section('contents_menu')
    @if ($projectData === null)
        <li><a href="/me/todo/day/{{ $dateAssociativeArray['year'] }}/{{ $dateAssociativeArray['month'] }}/{{ $dateAssociativeArray['day'] }}?{{ $includeCompleted === null ? 'includeCompleted=1' : '' }}">
            {{ $includeCompleted === null ? '完了を表示' : '完了を非表示' }}
        </a></li>
    @else        
        <li><a href="/project/{{ $projectData->getIsPrivate()? 'private' : 'public' }}/{{ $projectData->getId() }}/todo/{{ $projectData->getIsPrivate() || $mySubscriberData !== null ? 'onProject' : 'onResponsible' }}/day/{{ $dateAssociativeArray['year'] }}/{{ $dateAssociativeArray['month'] }}/{{ $dateAssociativeArray['day'] }}?{{ $includeCompleted === null ? 'includeCompleted=1' : '' }}">
            {{ $includeCompleted === null ? '完了を表示' : '完了を非表示' }}
        </a></li>
        <li><a href="/project/{{ $projectData->getIsPrivate()? 'private' : 'public' }}/{{ $projectData->getId() }}/todo/{{ $projectData->getIsPrivate() || $mySubscriberData !== null ? 'onProject' : 'onResponsible' }}/month/{{ $dateAssociativeArray['year'] }}/{{ $dateAssociativeArray['month'] }}?{{ $includeCompleted === null ? '' : '?includeCompleted=1' }}">
            月間表示に
        </a></li>
        <li><a href="/project/{{ $projectData->getIsPrivate()? 'private' : 'public' }}/$projectData->getId()">
            プロジェクトへ
        </a></li>
    @endif
@endsection

@section('contents')

    @foreach ($todoInDay->getExpiredTodoList() as $todo)
        
        <div class="todo" id="todo_{{ $todo->getId() }}"
            style="
                border-color: rgb(189, 15, 15);
                background-color: rgb(255, 0, 0);">
                
            <div class="inner">
                <div class="text">
                    <div class="name">{{ $todo->getName() }}</div>
                    <div class="date_string">{{ '締め切り：'.$todo->getFinishDateAssociativeArray()['hour'].'時'.$todo->getFinishDateAssociativeArray()['minute'].'分' }}</div>
                </div>                

                <div class="hamburger_img" id="todo_{{ $todo->getId() }}_hamburger_img">
                    <img src="{{ asset('img/triangle.png') }}"
                            style="width: 1.5em; height: 1.5em; transform: rotate(-90deg);">
                </div>

                <div class="is_completed" id="todo_{{ $todo->getId() }}_is_comleted">                    
                    <img src="{{ asset('img/check.png') }}" class="{{ $todo->getIsCompleted()? '' : 'none' }}">
                </div>
            </div>

            <div class="contents leaved" id="todo_{{ $todo->getId() }}_content_list">
                @foreach ($todo->getContentList() as $content)
                    <div class="content {{ $includeCompleted === null && $content->getIsCompleted() ? 'none' : '' }}" id="content_{{ $content->getId() }}">
                        <div class="name">{{ $content->getTitle() }}</div>

                        <div class="is_completed" id="content_{{ $content->getId() }}_is_comleted">
                            <img src="{{ asset('img/check.png') }}" class="{{ $content->getIsCompleted()? '' : 'none' }}">
                        </div>
                    </div>
                    <script>
                        @if($mySubscriberData === null || $mySubscriberData->hasSuperAuthority())
                            let content_newIsCompleted_{{ $content->getId() }} = {{ $content->getIsCompleted()? 'true' : 'false' }};
                            $('#content_{{ $content->getId() }}_is_comleted').click(function () {
                                content_newIsCompleted_{{ $content->getId() }} = !content_newIsCompleted_{{ $content->getId() }};
                                console.log(content_newIsCompleted_{{ $content->getId() }});
                                $.ajax({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    url: "/content/{{ $content->getId() }}/isCompleted",
                                    type: "post",
                                    data : {
                                        isCompleted : content_newIsCompleted_{{ $content->getId() }} ? 1 : 0,
                                    },
                                })
                                .done((res)=>{
                                    if(content_newIsCompleted_{{ $content->getId() }}){
                                        @if($includeCompleted === null)
                                            $('#content_{{ $content->getId() }}').addClass('leaved');
                                        @else
                                            $(this).children('img').removeClass('none');
                                        @endif
                                    }else{
                                        $(this).children('img').addClass('none');
                                    }
                                })
                                .fail((error)=>{
                                    console.log(error.statusText)
                                })
                            });
                        </script>
                    @endif
                @endforeach                
            </div>
        </div>
        <script>
            $('#todo_{{ $todo->getId() }} .inner .text').click(function () {
                window.location.href = "/todo/{{ $todo->getIsOnProject()? 'onProject' : 'onResponsible' }}/{{ $todo->getId() }}";
            });

            let visibleContentListInTodo_{{ $todo->getId() }} = false;
            $('#todo_{{ $todo->getId() }}_hamburger_img').click(function () {
                visibleContentListInTodo_{{ $todo->getId() }} = !visibleContentListInTodo_{{ $todo->getId() }};
                if(visibleContentListInTodo_{{ $todo->getId() }}){
                    $('#todo_{{ $todo->getId() }}_content_list')
                        .removeClass('leaved')
                        .addClass('visabled');
                    $(this).children('img')
                        .css('transform', 'rotate(90deg)')
                        .css('transition', '1s');
                }else{
                    $('#todo_{{ $todo->getId() }}_content_list')
                        .removeClass('visabled')
                        .addClass('leaved')
                    $(this).children('img')
                        .css('transform', 'rotate(-90deg)')
                        .css('transition', '1s');
                }
            });            

            @if($mySubscriberData === null || $mySubscriberData->hasSuperAuthority())
                let newIsCompleted_{{ $todo->getId() }} = {{ $todo->getIsCompleted()? 'true' : 'false' }};
                $('#todo_{{ $todo->getId() }}_is_comleted').click(function () {
                    newIsCompleted_{{ $todo->getId() }} = !newIsCompleted_{{ $todo->getId() }};
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "/todo/{{ $todo->getIsOnProject()? 'onProject' : 'onResponsible' }}/{{ $todo->getId() }}/isCompleted",
                        type: "post",
                        data : {
                            isCompleted : newIsCompleted_{{ $todo->getId() }} ? 1 : 0,
                        },
                    })
                    .done((res)=>{
                        if(newIsCompleted_{{ $todo->getId() }}){
                            @if($includeCompleted === null)
                                $('#todo_{{ $todo->getId() }}').addClass('leaved');
                            @else
                                $(this).children('img').removeClass('none');
                            @endif
                        }else{
                            $(this).children('img').addClass('none');
                        }
                    })
                    .fail((error)=>{
                        newIsCompleted_{{ $todo->getId() }} = !newIsCompleted_{{ $todo->getId() }};
                        console.log(error.statusText);
                    })
                });
            </script>
        @endif

    @endforeach

    @foreach ($todoInDay->getApproachingTodoList() as $todo)
        
        <div class="todo" id="todo_{{ $todo->getId() }}"
            style="
                border-color: rgb(255, 111, 0);
                background-color: rgb(255, 111, 0);">
                
            <div class="inner">
                <div class="text">
                    <div class="name">{{ $todo->getName() }}</div>
                    <div class="date_string">{{ '締め切り：'.$todo->getFinishDateAssociativeArray()['hour'].'時'.$todo->getFinishDateAssociativeArray()['minute'].'分' }}</div>
                </div>                

                <div class="hamburger_img" id="todo_{{ $todo->getId() }}_hamburger_img">
                    <img src="{{ asset('img/triangle.png') }}"
                            style="width: 1.5em; height: 1.5em; transform: rotate(-90deg);">
                </div>

                <div class="is_completed" id="todo_{{ $todo->getId() }}_is_comleted">                    
                    <img src="{{ asset('img/check.png') }}" class="{{ $todo->getIsCompleted()? '' : 'none' }}">
                </div>
            </div>

            <div class="contents leaved" id="todo_{{ $todo->getId() }}_content_list">
                @foreach ($todo->getContentList() as $content)
                    <div class="content {{ $includeCompleted === null && $content->getIsCompleted() ? 'none' : '' }}" id="content_{{ $content->getId() }}">
                        <div class="name">{{ $content->getTitle() }}</div>

                        <div class="is_completed" id="content_{{ $content->getId() }}_is_comleted">
                            <img src="{{ asset('img/check.png') }}" class="{{ $content->getIsCompleted()? '' : 'none' }}">
                        </div>
                    </div>
                    <script>
                        @if($mySubscriberData === null || $mySubscriberData->hasSuperAuthority())
                            let content_newIsCompleted_{{ $content->getId() }} = {{ $content->getIsCompleted()? 'true' : 'false' }};
                            $('#content_{{ $content->getId() }}_is_comleted').click(function () {
                                content_newIsCompleted_{{ $content->getId() }} = !content_newIsCompleted_{{ $content->getId() }};
                                console.log(content_newIsCompleted_{{ $content->getId() }});
                                $.ajax({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    url: "/content/{{ $content->getId() }}/isCompleted",
                                    type: "post",
                                    data : {
                                        isCompleted : content_newIsCompleted_{{ $content->getId() }} ? 1 : 0,
                                    },
                                })
                                .done((res)=>{
                                    if(content_newIsCompleted_{{ $content->getId() }}){
                                        @if($includeCompleted === null)
                                            $('#content_{{ $content->getId() }}').addClass('leaved');
                                        @else
                                            $(this).children('img').removeClass('none');
                                        @endif
                                    }else{
                                        $(this).children('img').addClass('none');
                                    }
                                })
                                .fail((error)=>{
                                    console.log(error.statusText)
                                })
                            });
                        </script>
                    @endif
                @endforeach                
            </div>
        </div>
        <script>
            $('#todo_{{ $todo->getId() }} .inner .text').click(function () {
                window.location.href = "/todo/{{ $todo->getIsOnProject()? 'onProject' : 'onResponsible' }}/{{ $todo->getId() }}";
            });

            let visibleContentListInTodo_{{ $todo->getId() }} = false;
            $('#todo_{{ $todo->getId() }}_hamburger_img').click(function () {
                visibleContentListInTodo_{{ $todo->getId() }} = !visibleContentListInTodo_{{ $todo->getId() }};
                if(visibleContentListInTodo_{{ $todo->getId() }}){
                    $('#todo_{{ $todo->getId() }}_content_list')
                        .removeClass('leaved')
                        .addClass('visabled');
                    $(this).children('img')
                        .css('transform', 'rotate(90deg)')
                        .css('transition', '1s');
                }else{
                    $('#todo_{{ $todo->getId() }}_content_list')
                        .removeClass('visabled')
                        .addClass('leaved')
                    $(this).children('img')
                        .css('transform', 'rotate(-90deg)')
                        .css('transition', '1s');
                }
            });            

            @if($mySubscriberData === null || $mySubscriberData->hasSuperAuthority())
                let newIsCompleted_{{ $todo->getId() }} = {{ $todo->getIsCompleted()? 'true' : 'false' }};
                $('#todo_{{ $todo->getId() }}_is_comleted').click(function () {
                    newIsCompleted_{{ $todo->getId() }} = !newIsCompleted_{{ $todo->getId() }};
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "/todo/{{ $todo->getIsOnProject()? 'onProject' : 'onResponsible' }}/{{ $todo->getId() }}/isCompleted",
                        type: "post",
                        data : {
                            isCompleted : newIsCompleted_{{ $todo->getId() }} ? 1 : 0,
                        },
                    })
                    .done((res)=>{
                        if(newIsCompleted_{{ $todo->getId() }}){
                            @if($includeCompleted === null)
                                $('#todo_{{ $todo->getId() }}').addClass('leaved');
                            @else
                                $(this).children('img').removeClass('none');
                            @endif
                        }else{
                            $(this).children('img').addClass('none');
                        }
                    })
                    .fail((error)=>{
                        newIsCompleted_{{ $todo->getId() }} = !newIsCompleted_{{ $todo->getId() }};
                        console.log(error.statusText);
                    })
                });
            </script>
        @endif

    @endforeach

    @foreach ($todoInDay->getTodaysTodoList() as $todo)
        
        <div class="todo" id="todo_{{ $todo->getId() }}"
            style="
                border-color: rgb(67, 193, 4);
                background-color: rgb(67, 193, 4);">
                
            <div class="inner">
                <div class="text">
                    <div class="name">{{ $todo->getName() }}</div>
                    <div class="date_string">{{ '締め切り：'.$todo->getFinishDateAssociativeArray()['hour'].'時'.$todo->getFinishDateAssociativeArray()['minute'].'分' }}</div>
                </div>                

                <div class="hamburger_img" id="todo_{{ $todo->getId() }}_hamburger_img">
                    <img src="{{ asset('img/triangle.png') }}"
                            style="width: 1.5em; height: 1.5em; transform: rotate(-90deg);">
                </div>

                <div class="is_completed" id="todo_{{ $todo->getId() }}_is_comleted">                    
                    <img src="{{ asset('img/check.png') }}" class="{{ $todo->getIsCompleted()? '' : 'none' }}">
                </div>
            </div>

            <div class="contents leaved" id="todo_{{ $todo->getId() }}_content_list">
                @foreach ($todo->getContentList() as $content)
                    <div class="content {{ $includeCompleted === null && $content->getIsCompleted() ? 'none' : '' }}" id="content_{{ $content->getId() }}">
                        <div class="name">{{ $content->getTitle() }}</div>

                        <div class="is_completed" id="content_{{ $content->getId() }}_is_comleted">
                            <img src="{{ asset('img/check.png') }}" class="{{ $content->getIsCompleted()? '' : 'none' }}">
                        </div>
                    </div>
                    <script>
                        @if($mySubscriberData === null || $mySubscriberData->hasSuperAuthority())
                            let content_newIsCompleted_{{ $content->getId() }} = {{ $content->getIsCompleted()? 'true' : 'false' }};
                            $('#content_{{ $content->getId() }}_is_comleted').click(function () {
                                content_newIsCompleted_{{ $content->getId() }} = !content_newIsCompleted_{{ $content->getId() }};
                                console.log(content_newIsCompleted_{{ $content->getId() }});
                                $.ajax({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    url: "/content/{{ $content->getId() }}/isCompleted",
                                    type: "post",
                                    data : {
                                        isCompleted : content_newIsCompleted_{{ $content->getId() }} ? 1 : 0,
                                    },
                                })
                                .done((res)=>{
                                    if(content_newIsCompleted_{{ $content->getId() }}){
                                        @if($includeCompleted === null)
                                            $('#content_{{ $content->getId() }}').addClass('leaved');
                                        @else
                                            $(this).children('img').removeClass('none');
                                        @endif
                                    }else{
                                        $(this).children('img').addClass('none');
                                    }
                                })
                                .fail((error)=>{
                                    console.log(error.statusText)
                                })
                            });
                        </script>
                    @endif
                @endforeach                
            </div>
        </div>
        <script>
            $('#todo_{{ $todo->getId() }} .inner .text').click(function () {
                window.location.href = "/todo/{{ $todo->getIsOnProject()? 'onProject' : 'onResponsible' }}/{{ $todo->getId() }}";
            });

            let visibleContentListInTodo_{{ $todo->getId() }} = false;
            $('#todo_{{ $todo->getId() }}_hamburger_img').click(function () {
                visibleContentListInTodo_{{ $todo->getId() }} = !visibleContentListInTodo_{{ $todo->getId() }};
                if(visibleContentListInTodo_{{ $todo->getId() }}){
                    $('#todo_{{ $todo->getId() }}_content_list')
                        .removeClass('leaved')
                        .addClass('visabled');
                    $(this).children('img')
                        .css('transform', 'rotate(90deg)')
                        .css('transition', '1s');
                }else{
                    $('#todo_{{ $todo->getId() }}_content_list')
                        .removeClass('visabled')
                        .addClass('leaved')
                    $(this).children('img')
                        .css('transform', 'rotate(-90deg)')
                        .css('transition', '1s');
                }
            });            

            @if($mySubscriberData === null || $mySubscriberData->hasSuperAuthority())
                let newIsCompleted_{{ $todo->getId() }} = {{ $todo->getIsCompleted()? 'true' : 'false' }};
                $('#todo_{{ $todo->getId() }}_is_comleted').click(function () {
                    newIsCompleted_{{ $todo->getId() }} = !newIsCompleted_{{ $todo->getId() }};
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "/todo/{{ $todo->getIsOnProject()? 'onProject' : 'onResponsible' }}/{{ $todo->getId() }}/isCompleted",
                        type: "post",
                        data : {
                            isCompleted : newIsCompleted_{{ $todo->getId() }} ? 1 : 0,
                        },
                    })
                    .done((res)=>{
                        if(newIsCompleted_{{ $todo->getId() }}){
                            @if($includeCompleted === null)
                                $('#todo_{{ $todo->getId() }}').addClass('leaved');
                            @else
                                $(this).children('img').removeClass('none');
                            @endif
                        }else{
                            $(this).children('img').addClass('none');
                        }
                    })
                    .fail((error)=>{
                        newIsCompleted_{{ $todo->getId() }} = !newIsCompleted_{{ $todo->getId() }};
                        console.log(error.statusText);
                    })
                });
            </script>
        @endif

    @endforeach

    @foreach ($todoInDay->getOtherTodoList() as $todo)
        
        <div class="todo" id="todo_{{ $todo->getId() }}"
            style="
                border-color: rgb(81, 80, 101);
                background-color: rgb(81, 80, 101);">
                
            <div class="inner">
                <div class="text">
                    <div class="name">{{ $todo->getName() }}</div>
                </div>                

                <div class="hamburger_img" id="todo_{{ $todo->getId() }}_hamburger_img">
                    <img src="{{ asset('img/triangle.png') }}"
                            style="width: 1.5em; height: 1.5em; transform: rotate(-90deg);">
                </div>

                <div class="is_completed" id="todo_{{ $todo->getId() }}_is_comleted">                    
                    <img src="{{ asset('img/check.png') }}" class="{{ $todo->getIsCompleted()? '' : 'none' }}">
                </div>
            </div>

            <div class="contents leaved" id="todo_{{ $todo->getId() }}_content_list">
                @foreach ($todo->getContentList() as $content)
                    <div class="content {{ $includeCompleted === null && $content->getIsCompleted() ? 'none' : '' }}" id="content_{{ $content->getId() }}">
                        <div class="name">{{ $content->getTitle() }}</div>

                        <div class="is_completed" id="content_{{ $content->getId() }}_is_comleted">
                            <img src="{{ asset('img/check.png') }}" class="{{ $content->getIsCompleted()? '' : 'none' }}">
                        </div>
                    </div>
                    <script>
                        @if($mySubscriberData === null || $mySubscriberData->hasSuperAuthority())
                            let content_newIsCompleted_{{ $content->getId() }} = {{ $content->getIsCompleted()? 'true' : 'false' }};
                            $('#content_{{ $content->getId() }}_is_comleted').click(function () {
                                content_newIsCompleted_{{ $content->getId() }} = !content_newIsCompleted_{{ $content->getId() }};
                                $.ajax({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    url: "/content/{{ $content->getId() }}/isCompleted",
                                    type: "post",
                                    data : {
                                        isCompleted : content_newIsCompleted_{{ $content->getId() }} ? 1 : 0,
                                    },
                                })
                                .done((res)=>{
                                    if(content_newIsCompleted_{{ $content->getId() }}){
                                        @if($includeCompleted === null)
                                            $('#content_{{ $content->getId() }}').addClass('leaved');
                                        @else
                                            $(this).children('img').removeClass('none');
                                        @endif
                                    }else{
                                        $(this).children('img').addClass('none');
                                    }
                                })
                                .fail((error)=>{
                                    console.log(error.statusText)
                                })
                            });
                        </script>
                    @endif
                @endforeach                
            </div>
        </div>
        <script>
            $('#todo_{{ $todo->getId() }} .inner .text').click(function () {
                window.location.href = "/todo/{{ $todo->getIsOnProject()? 'onProject' : 'onResponsible' }}/{{ $todo->getId() }}";
            });

            let visibleContentListInTodo_{{ $todo->getId() }} = false;
            $('#todo_{{ $todo->getId() }}_hamburger_img').click(function () {
                visibleContentListInTodo_{{ $todo->getId() }} = !visibleContentListInTodo_{{ $todo->getId() }};
                if(visibleContentListInTodo_{{ $todo->getId() }}){
                    $('#todo_{{ $todo->getId() }}_content_list')
                        .removeClass('leaved')
                        .addClass('visabled');
                    $(this).children('img')
                        .css('transform', 'rotate(90deg)')
                        .css('transition', '1s');
                }else{
                    $('#todo_{{ $todo->getId() }}_content_list')
                        .removeClass('visabled')
                        .addClass('leaved')
                    $(this).children('img')
                        .css('transform', 'rotate(-90deg)')
                        .css('transition', '1s');
                }
            });            

            @if($mySubscriberData === null || $mySubscriberData->hasSuperAuthority())
                let newIsCompleted_{{ $todo->getId() }} = {{ $todo->getIsCompleted()? 'true' : 'false' }};
                $('#todo_{{ $todo->getId() }}_is_comleted').click(function () {
                    newIsCompleted_{{ $todo->getId() }} = !newIsCompleted_{{ $todo->getId() }};
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "/todo/{{ $todo->getIsOnProject()? 'onProject' : 'onResponsible' }}/{{ $todo->getId() }}/isCompleted",
                        type: "post",
                        data : {
                            isCompleted : newIsCompleted_{{ $todo->getId() }} ? 1 : 0,
                        },
                    })
                    .done((res)=>{
                        if(newIsCompleted_{{ $todo->getId() }}){
                            @if($includeCompleted === null)
                                $('#todo_{{ $todo->getId() }}').addClass('leaved');
                            @else
                                $(this).children('img').removeClass('none');
                            @endif
                        }else{
                            $(this).children('img').addClass('none');
                        }
                    })
                    .fail((error)=>{
                        newIsCompleted_{{ $todo->getId() }} = !newIsCompleted_{{ $todo->getId() }};
                        console.log(error.statusText);
                    })
                });
            </script>
        @endif

    @endforeach

@endsection
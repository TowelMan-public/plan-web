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
                window.location.href = "/project/{{ $projectData->getIsPrivate()? 'private' : 'public' }}/todo/" + 
                    "{{ $projectData->getIsPrivate() || $mySubscriberData !== null ? 'onProject' : 'onResponsible' }}/day/{{ $dateAssociativeArray['year'] }}/{{ $dateAssociativeArray['month'] }}/{{ $dateAssociativeArray['day'] }}/back{{ $includeCompleted === null ? '' : '?includeCompleted=1' }}";
            });

            $('#next_day').click(function(){
                window.location.href = "/project/{{ $projectData->getIsPrivate()? 'private' : 'public' }}/todo" + 
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
        <li><a href="/me/todo/day/{{ $dateAssociativeArray['year'] }}/{{ $dateAssociativeArray['month'] }}/{{ $dateAssociativeArray['day'] }}?{{ $includeCompleted === null ? 'includeCompleted=1' : '' }}">
            {{ $includeCompleted === null ? '完了を表示' : '完了を非表示' }}
        </a></li>
        <li><a href="/project/{{ $projectData->getIsPrivate()? 'private' : 'public' }}/todo/{{ $projectData->getIsPrivate() || $mySubscriberData !== null ? 'onProject' : 'onResponsible' }}/month/{{ $dateAssociativeArray['year'] }}/{{ $dateAssociativeArray['month'] }}?{{ $includeCompleted === null ? '' : '?includeCompleted=1' }}">
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
                    <div class="date_string">{{ '締め切り：'.$todo->getFinishDateAssociativeArray()['year'].'-'.$todo->getFinishDateAssociativeArray()['month'].'-'.$todo->getFinishDateAssociativeArray()['day'].' ' 
                        .$todo->getFinishDateAssociativeArray()['hour'].':'.$todo->getFinishDateAssociativeArray()['minute'] }}</div>
                </div>

                <div class="hamburger_img">
                    <img src="{{ asset('img/plus.png') }}">
                    <img class="none" src="{{ asset('img/close.png') }}">
                </div>

                <div class="is_completed" id="#content_{{ $content->getId() }}_is_comleted">
                    <input type="text" id="content_{{ $content->getId() }}_is_comleted" class="none" value="{{ $content->getIsCompleted() }}"/>
                    <img src="{{ asset('img/check.png') }}" class="{{ $content->getIsCompleted()? '' : 'none' }}">
                </div>
            </div>

            <div class="contents none">
                @foreach ($todo->getContentList() as $content)
                    <div class="content" id="content_{{ $content->getId() }}">
                        <div class="name">{{ $content->getTitle() }}</div>

                        <div class="is_completed" id="#content_{{ $content->getId() }}_is_comleted">
                            <input type="text" id="content_{{ $content->getId() }}_is_comleted" class="none" value="{{ $content->getIsCompleted() }}"/>
                            <img src="{{ asset('img/check.png') }}" class="{{ $content->getIsCompleted()? '' : 'none' }}">
                        </div>
                    </div>
                    <script>
                        $('#content_{{ $content->getId() }}').not('.is_completed').click(function () {
                            window.location.href = "/content/{{ $content->getId() }}";
                        });

                        @if($mySubscriberData === null || $mySubscriberData->hasSuperAuthority())
                            $('#content_{{ $content->getId() }}_is_comleted').click(function () {
                                let newIsCompleted = !$('this').val();
                                
                                $.ajax({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    url: "/content/{{ $content->getId() }}/isCompleted",
                                    type: "post",
                                    data : {
                                        isCompleted : newIsCompleted,
                                    },
                                })
                                .done((res)=>{
                                    $('this').val(newIsCompleted);

                                    if(newIsCompleted){
                                        @if($includeCompleted === null)
                                            $('this').addClass('leaved')
                                        @else
                                            $('this').children('img').addClass('none')
                                        @endif
                                    }else{
                                        $('this').children('img').removeClass('none');
                                    }
                                })
                                .fail((error)=>{
                                    console.log(error.statusText)
                                })
                            });
                        @endif
                    </scrip>
                @endforeach                
            </div>
        </div>
        <script>
            $('#todo_{{ $todo->getId() }}').not('.hamburger_img').not('is_completed').not(contents).click(function () {
                window.location.href = "/todo/{{ $todo->getIsOnProject? 'onProject' : 'onPrivate' }}/{{ $todo->getId() }}";
            });

            @if($mySubscriberData === null || $mySubscriberData->hasSuperAuthority())
                $('#todo_{{ $todo->getId() }}_is_comleted').click(function () {
                    let newIsCompleted = !$('this').val();

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "/todo/{{ $todo->getIsOnProject? 'onProject' : 'onPrivate' }}/{{ $content->getId() }}/isCompleted",
                        type: "post",
                        data : {
                            isCompleted : newIsCompleted,
                        },
                    })
                    .done((res)=>{
                        $('this').val(newIsCompleted);

                        if(newIsCompleted){
                            @if($includeCompleted === null)
                                $('this').addClass('leaved')
                            @else
                                $('this').children('img').addClass('none')
                            @endif
                        }else{
                            $('this').children('img').removeClass('none');
                        }
                    })
                    .fail((error)=>{
                        console.log(error.statusText)
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
                    <div class="date_string">{{ '締め切り：'.$todo->getFinishDateAssociativeArray()['hour'].':'.$todo->getFinishDateAssociativeArray()['minute'] }}</div>
                </div>                

                <div class="hamburger_img">
                    <img src="{{ asset('img/plus.png') }}">
                    <img class="none" src="{{ asset('img/close.png') }}">
                </div>

                <div class="is_completed" id="#content_{{ $content->getId() }}_is_comleted">
                    <input type="text" id="content_{{ $content->getId() }}_is_comleted" class="none" value="{{ $content->getIsCompleted() }}"/>
                    <img src="{{ asset('img/check.png') }}" class="{{ $content->getIsCompleted()? '' : 'none' }}">
                </div>
            </div>

            <div class="contents none">
                @foreach ($todo->getContentList() as $content)
                    <div class="content" id="content_{{ $content->getId() }}">
                        <div class="name">{{ $content->getTitle() }}</div>

                        <div class="is_completed" id="#content_{{ $content->getId() }}_is_comleted">
                            <input type="text" id="content_{{ $content->getId() }}_is_comleted" class="none" value="{{ $content->getIsCompleted() }}"/>
                            <img src="{{ asset('img/check.png') }}" class="{{ $content->getIsCompleted()? '' : 'none' }}">
                        </div>
                    </div>
                    <script>
                        $('#content_{{ $content->getId() }}').not('.is_completed').click(function () {
                            window.location.href = "/content/{{ $content->getId() }}";
                        });

                        @if($mySubscriberData === null || $mySubscriberData->hasSuperAuthority())
                            $('#content_{{ $content->getId() }}_is_comleted').click(function () {
                                let newIsCompleted = !$('this').val();
                                
                                $.ajax({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    url: "/content/{{ $content->getId() }}/isCompleted",
                                    type: "post",
                                    data : {
                                        isCompleted : newIsCompleted,
                                    },
                                })
                                .done((res)=>{
                                    $('this').val(newIsCompleted);

                                    if(newIsCompleted){
                                        @if($includeCompleted === null)
                                            $('this').addClass('leaved')
                                        @else
                                            $('this').children('img').addClass('none')
                                        @endif
                                    }else{
                                        $('this').children('img').removeClass('none');
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
            $('#todo_{{ $todo->getId() }}').not('.hamburger_img').not('is_completed').not(contents).click(function () {
                window.location.href = "/todo/{{ $todo->getIsOnProject? 'onProject' : 'onPrivate' }}/{{ $todo->getId() }}";
            });

            @if($mySubscriberData === null || $mySubscriberData->hasSuperAuthority())
                $('#todo_{{ $todo->getId() }}_is_comleted').click(function () {
                    let newIsCompleted = !$('this').val();

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "/todo/{{ $todo->getIsOnProject? 'onProject' : 'onPrivate' }}/{{ $content->getId() }}/isCompleted",
                        type: "post",
                        data : {
                            isCompleted : newIsCompleted,
                        },
                    })
                    .done((res)=>{
                        $('this').val(newIsCompleted);

                        if(newIsCompleted){
                            @if($includeCompleted === null)
                                $('this').addClass('leaved')
                            @else
                                $('this').children('img').addClass('none')
                            @endif
                        }else{
                            $('this').children('img').removeClass('none');
                        }
                    })
                    .fail((error)=>{
                        console.log(error.statusText)
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
                    <div class="date_string">{{ '締め切り：'.$todo->getFinishDateAssociativeArray()['hour'].':'.$todo->getFinishDateAssociativeArray()['minute'] }}</div>
                </div>

                <div class="hamburger_img">
                    <img src="{{ asset('img/plus.png') }}">
                    <img class="none" src="{{ asset('img/close.png') }}">
                </div>

                <div class="is_completed">
                    <input type="text" id="todo_{{ $todo->getId() }}_is_comleted" class="none" value="{{ $todo->getIsCompleted() }}"/>
                    <img src="{{ asset('img/check.png') }}" class="{{ $todo->getIsCompleted()? '' : 'none' }}">
                </div>
            </div>

            <div class="contents none">
                @foreach ($todo->getContentList() as $content)
                    <div class="content" id="content_{{ $content->getId() }}">
                        <div class="name">{{ $content->getTitle() }}</div>

                        <div class="is_completed" id="#content_{{ $content->getId() }}_is_comleted">
                            <input type="text" id="content_{{ $content->getId() }}_is_comleted" class="none" value="{{ $content->getIsCompleted() }}"/>
                            <img src="{{ asset('img/check.png') }}" class="{{ $content->getIsCompleted()? '' : 'none' }}">
                        </div>
                    </div>
                    <script>
                        $('#content_{{ $content->getId() }}').not('.is_completed').click(function () {
                            window.location.href = "/content/{{ $content->getId() }}";
                        });

                        @if($mySubscriberData === null || $mySubscriberData->hasSuperAuthority())
                            $('#content_{{ $content->getId() }}_is_comleted').click(function () {
                                let newIsCompleted = !$('this').val();
                                
                                $.ajax({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    url: "/content/{{ $content->getId() }}/isCompleted",
                                    type: "post",
                                    data : {
                                        isCompleted : newIsCompleted,
                                    },
                                })
                                .done((res)=>{
                                    $('this').val(newIsCompleted);

                                    if(newIsCompleted){
                                        @if($includeCompleted === null)
                                            $('this').addClass('leaved')
                                        @else
                                            $('this').children('img').addClass('none')
                                        @endif
                                    }else{
                                        $('this').children('img').removeClass('none');
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
            $('#todo_{{ $todo->getId() }}').not('.hamburger_img').not('is_completed').not(contents).click(function () {
                window.location.href = "/todo/{{ $todo->getIsOnProject? 'onProject' : 'onPrivate' }}/{{ $todo->getId() }}";
            });

            @if($mySubscriberData === null || $mySubscriberData->hasSuperAuthority())
                $('#todo_{{ $todo->getId() }}_is_comleted').click(function () {
                    let newIsCompleted = !$('this').val();

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "/todo/{{ $todo->getIsOnProject? 'onProject' : 'onPrivate' }}/{{ $content->getId() }}/isCompleted",
                        type: "post",
                        data : {
                            isCompleted : newIsCompleted,
                        },
                    })
                    .done((res)=>{
                        $('this').val(newIsCompleted);

                        if(newIsCompleted){
                            @if($includeCompleted === null)
                                $('this').addClass('leaved')
                            @else
                                $('this').children('img').addClass('none')
                            @endif
                        }else{
                            $('this').children('img').removeClass('none');
                        }
                    })
                    .fail((error)=>{
                        console.log(error.statusText)
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

                <div class="hamburger_img">
                    <img src="{{ asset('img/plus.png') }}">
                    <img class="none" src="{{ asset('img/close.png') }}">
                </div>

                <div class="is_completed" id="#content_{{ $content->getId() }}_is_comleted">
                    <input type="text" id="content_{{ $content->getId() }}_is_comleted" class="none" value="{{ $content->getIsCompleted() }}"/>
                    <img src="{{ asset('img/check.png') }}" class="{{ $content->getIsCompleted()? '' : 'none' }}">
                </div>
            </div>

            <div class="contents none">
                @foreach ($todo->getContentList() as $content)
                    <div class="content" id="content_{{ $content->getId() }}">
                        <div class="name">{{ $content->getTitle() }}</div>

                        <div class="is_completed" id="#content_{{ $content->getId() }}_is_comleted">
                            <input type="text" id="content_{{ $content->getId() }}_is_comleted" class="none" value="{{ $content->getIsCompleted() }}"/>
                            <img src="{{ asset('img/check.png') }}" class="{{ $content->getIsCompleted()? '' : 'none' }}">
                        </div>
                    </div>
                    <script>
                        $('#content_{{ $content->getId() }}').not('.is_completed').click(function () {
                            window.location.href = "/content/{{ $content->getId() }}";
                        });

                        @if($mySubscriberData === null || $mySubscriberData->hasSuperAuthority())
                            $('#content_{{ $content->getId() }}_is_comleted').click(function () {
                                let newIsCompleted = !$('this').val();
                                
                                $.ajax({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    url: "/content/{{ $content->getId() }}/isCompleted",
                                    type: "post",
                                    data : {
                                        isCompleted : newIsCompleted,
                                    },
                                })
                                .done((res)=>{
                                    $('this').val(newIsCompleted);

                                    if(newIsCompleted){
                                        @if($includeCompleted === null)
                                            $('this').addClass('leaved')
                                        @else
                                            $('this').children('img').addClass('none')
                                        @endif
                                    }else{
                                        $('this').children('img').removeClass('none');
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
            $('#todo_{{ $todo->getId() }}').not('.hamburger_img').not('is_completed').not(contents).click(function () {
                window.location.href = "/todo/{{ $todo->getIsOnProject? 'onProject' : 'onPrivate' }}/{{ $todo->getId() }}";
            });

            @if($mySubscriberData === null || $mySubscriberData->hasSuperAuthority())
                $('#todo_{{ $todo->getId() }}_is_comleted').click(function () {
                    let newIsCompleted = !$('this').val();

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "/todo/{{ $todo->getIsOnProject? 'onProject' : 'onPrivate' }}/{{ $content->getId() }}/isCompleted",
                        type: "post",
                        data : {
                            isCompleted : newIsCompleted,
                        },
                    })
                    .done((res)=>{
                        $('this').val(newIsCompleted);

                        if(newIsCompleted){
                            @if($includeCompleted === null)
                                $('this').addClass('leaved')
                            @else
                                $('this').children('img').addClass('none')
                            @endif
                        }else{
                            $('this').children('img').removeClass('none');
                        }
                    })
                    .fail((error)=>{
                        console.log(error.statusText)
                    })
                });
            </script>
        @endif
    @endforeach

@endsection
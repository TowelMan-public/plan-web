@extends('default_layout')

@section('page_name') 
    @if ($projectData === null)
        一月の自分のやること
    @else
        一月の{{ $projectData->getName() }}のやること
    @endif
@endsection

@section('title_name')
    <div>
        @if ($projectData === null)
            一月の自分のやること
        @else
            一月の{{ $projectData->getName() }}のやること
        @endif
    </div>
@endsection

@section('title_bar_contents')
    <div class="dateStringBar">
        <img src="{{ asset('img/triangle.png') }}" id="back_month">
        <div class="dateString">{{ $dateAssociativeArray['year'].'-'.$dateAssociativeArray['month'] }}</div>
        <img src="{{ asset('img/triangle.png') }}" id="next_month"
            style="transform: rotate(180deg);">
    </div>

    @if ($projectData === null)
        <script>
            $('#back_month').click(function(){
                window.location.href = "/me/todo/month/{{ $dateAssociativeArray['year'] }}/{{ $dateAssociativeArray['month'] }}/back{{ $includeCompleted === null ? '' : '?includeCompleted=1' }}";
            });

            $('#next_month').click(function(){
                window.location.href = "/me/todo/month/{{ $dateAssociativeArray['year'] }}/{{ $dateAssociativeArray['month'] }}/next{{ $includeCompleted === null ? '' : '?includeCompleted=1' }}";
            });
        </script>
    @else
        <script>
            $('#back_month').click(function(){
                window.location.href = "/project/{{ $projectData->getIsPrivate()? 'private' : 'public' }}/todo/" + 
                    "{{ $projectData->getIsPrivate() || $mySubscriberData !== null ? 'onProject' : 'onResponsible' }}/month/{{ $dateAssociativeArray['year'] }}/{{ $dateAssociativeArray['month'] }}/back{{ $includeCompleted === null ? '' : '?includeCompleted=1' }}";
            });

            $('#next_month').click(function(){
                window.location.href = "/project/{{ $projectData->getIsPrivate()? 'private' : 'public' }}/todo" + 
                    "{{ $projectData->getIsPrivate() || $mySubscriberData !== null ? 'onProject' : 'onResponsible' }}/month/{{ $dateAssociativeArray['year'] }}/{{ $dateAssociativeArray['month'] }}/next{{ $includeCompleted === null ? '' : '?includeCompleted=1' }}";
            });
        </script>
    @endif
@endsection

@section('contents_menu')
    @if ($projectData === null)
        <li><a href="/me/todo/month/{{ $dateAssociativeArray['year'] }}/{{ $dateAssociativeArray['month'] }}?{{ $includeCompleted === null ? 'includeCompleted=1' : '' }}">
            {{ $includeCompleted === null ? '完了を表示' : '完了を非表示' }}
        </a></li>
    @else        
        <li><a href="/me/todo/month/{{ $dateAssociativeArray['year'] }}/{{ $dateAssociativeArray['month'] }}?{{ $includeCompleted === null ? 'includeCompleted=1' : '' }}">
            {{ $includeCompleted === null ? '完了を表示' : '完了を非表示' }}
        </a></li>
        <li><a href="/project/{{ $projectData->getIsPrivate()? 'private' : 'public' }}/todo/{{ $projectData->getIsPrivate() || $mySubscriberData !== null ? 'onProject' : 'onResponsible' }}/day/{{ $dateAssociativeArray['year'] }}/{{ $dateAssociativeArray['month'] }}?{{ $includeCompleted === null ? '' : '?includeCompleted=1' }}">
            日間表示に
        </a></li>
        <li><a href="/project/{{ $projectData->getIsPrivate()? 'private' : 'public' }}/$projectData->getId()">
            プロジェクトへ
        </a></li>
    @endif
@endsection

@section('contents')

    <table class="in_month_table" border="0">
        <tr>
            <th>日</th>
            <th>月</th>
            <th>火</th>
            <th>水</th>
            <th>木</th>
            <th>金</th>
            <th>土</th>
        </tr>

        @for($i = 1; (7*$i - 6 - $todoInMonth->getStartWeek()) <= $todoInMonth->getFinishDay(); $i++)
            <tr class="day_list">
                @for($nowDay = 7*$i - 6 - $todoInMonth->getStartWeek(); $nowDay <= 7*$i - $todoInMonth->getStartWeek(); $nowDay++)
                    <td>{{ ($nowDay <= $todoInMonth->getFinishDay() && $nowDay > 0) ? $nowDay : ''}}</td>
                @endfor
            </tr>

            @foreach ($todoInMonth->getTodoDataNodeArray() as $node)
                <tr class="todo_list">
                    @php
                        $finishDay = 7*$i - $projectInMonth->getStartWeek();
                    @endphp
                    @for ($nowDay = 7*$i - 6 - $todoInMonth->getStartWeek(); $nowDay <= $finishDay; $nowDay++)
                        @if ($nowDay <= $todoInMonth->getFinishDay() && $nowDay > 0 && $node !== null)
                            @if ($node->getDayLength() <= 0 || $node->getStartDay() < $nowDay)
                            @php
                                $nowDay--;
                                $node = $node->getNextNode();
                            @endphp
                            @elseif ($node->isEmpty())
                                <td class="single">&nbsp;</td>
                                @php
                                    $node->setDayLength($node->getDayLength() - 1);
                                    $node->setStartDay($node->getStartDay() + 1);
                                @endphp
                            @else
                                @php
                                    $dayLength = 0;
                                    if($finishDay - $nowday + 1 > $node->getDayLength())
                                        $dayLength = $node->getDayLength();
                                    else
                                        $dayLength = $finishDay - $nowday + 1;
                                    
                                    $nowDay += $dayLength - 1;
                                    $node->setDayLength( $node->getDayLength() - $dayLength);
                                    $node->setStartDay( $node->getStartDay() + $dayLength);
                                @endphp
                                <td class="todo_in_month {{ $dayLength === 0 ? 'single' : '' }}" id="todo_{{ $todo->getId() }}"
                                    align="left" colspan="{{ $dayLength }}"
                                    style="background-color: {{ $todoInMonth->getBackGroundCollor($loop->index) }};">
                                    {{ $node->getName() }}
                                </td>
                                <script>
                                    $('#todo_{{ $todo->getId() }}').click(function () {
                                        window.location.href = "/todo/{{ $todo->getIsOnProject? 'onProject' : 'onPrivate' }}/{{ $todo->getId() }}";
                                    });
                                </script>
                            @endif
                        @else
                            <td class="single">&nbsp;</td>
                        @endif
                    @endfor

                </tr>
            @endforeach

        @endfor
        
    </table>

@endsection
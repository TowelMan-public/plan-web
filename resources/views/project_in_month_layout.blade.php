@extends('default_layout')

@section('page_name') 
    今月のプロジェクト
@endsection

@section('title_name')
    <div>今月のプロジェクト</div>
@endsection

@section('title_bar_contents')
    <div class="dateStringBar">
        <img id="back_month" src="{{ asset('img/triangle.png') }}">
        <div class="dateString">{{ $dateAssociativeArray['year'].'-'.$dateAssociativeArray['month'] }}</div>
        <img id="next_month" src="{{ asset('img/triangle.png') }}"
            style="transform: rotate(180deg);">
    </div>
    <script>
        $('#back_month').click(function(){
            window.location.href = "{{ '/me/project/month/'.$dateAssociativeArray['year'].'/'.$dateAssociativeArray['month'].'/back'.($includeCompleted === null ? '' : '?includeCompleted=1') }}";
        });

        $('#next_month').click(function(){
            window.location.href = "{{ '/me/project/month/'. $dateAssociativeArray['year'].'/'.$dateAssociativeArray['month'].'/next'.($includeCompleted === null ? '' : '?includeCompleted=1') }}";
        });
    </script>
@endsection

@section('contents_menu')
    <li><a href="/me/project/list">リストで表示</a></li>
    @if($includeCompleted !== null)
        <li><a href="/me/project/month/{{ $dateAssociativeArray['year'].'/'.$dateAssociativeArray['month'] }}">完了を非表示</a></li>
    @else
        <li><a href="/me/project/month/{{ $dateAssociativeArray['year'].'/'.$dateAssociativeArray['month'] }}?includeCompleted=1">完了を表示</a></li>
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

        @for($i = 1; (7*$i - 6 - $projectInMonth->getStartWeek()) <= $projectInMonth->getFinishDay(); $i++)
            <tr class="day_list">
                @for($nowDay = 7*$i - 6 - $projectInMonth->getStartWeek(); $nowDay <= 7*$i - $projectInMonth->getStartWeek(); $nowDay++)
                    <td>{{ ($nowDay <= $projectInMonth->getFinishDay() && $nowDay > 0) ? $nowDay : ''}}</td>
                @endfor
            </tr>
            @foreach ($projectInMonth->getProjectDataNodeArray() as $node)
                <tr class="todo_list">
                    @php
                        $finishDay = 7*$i - $projectInMonth->getStartWeek();
                    @endphp
                    @for ($nowDay = 7*$i - 6 - $projectInMonth->getStartWeek(); $nowDay <= $finishDay; $nowDay++)
                        @if ($nowDay <= $projectInMonth->getFinishDay() && $nowDay > 0 && $node !== null)                            
                            @if ($node->getDayLength() <= 0 || $node->getStartDay() < $nowDay)
                                @php
                                    $nowDay--;
                                    $node = $node->getNextNode();
                                @endphp
                                
                            @elseif ($node->getIsEmpty())
                                <td class="single">&nbsp;</td>
                                @php
                                    $node->setDayLength($node->getDayLength() - 1);
                                    $node->setStartDay($node->getStartDay() + 1);
                                @endphp
                            @else
                                @php
                                    $dayLength = 0;
                                    if($finishDay - $nowDay + 1 >= $node->getDayLength())
                                        $dayLength = $node->getDayLength();
                                    else
                                        $dayLength = $finishDay - $nowDay + 1;
                                    
                                    $nowDay += $dayLength - 1;
                                    $node->setDayLength( $node->getDayLength() - $dayLength);
                                    $node->setStartDay( $node->getStartDay() + $dayLength);
                                @endphp
                                <td id="{{ 'project_td_'.$node->getId().'-'.$dayLength }}" class="todo_in_month {{ $dayLength === 0 ? 'single' : '' }}" align="left" colspan="{{ $dayLength }}"
                                    style="background-color: {{ $projectInMonth->getBackGroundCollor($loop->index) }};">
                                    {{ $node->getName() }}
                                </td>
                                <script>
                                    $("#project_td_{{ $node->getId() }}-{{ $dayLength }}").click(function () {
                                        window.location.href = "/project/public/{{ $node->getId() }}";
                                    })
                                </script>
                                @php
                                    $node = $node->getNextNode();
                                @endphp
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
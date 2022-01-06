@extends('default_layout')

@section('page_name') 
    今月のプロジェクト
@endsection

@section('title_name')
    <div>今月のプロジェクト</div>
@endsection

@section('title_bar_contents')
    <div class="dateStringBar">
        <img src="{{ asset('img/triangle.png') }}">
        <div class="dateString">{{ $dateAssociativeArray['year'].'-'.$dateAssociativeArray['month'] }}</div>
        <img src="{{ asset('img/triangle.png') }}"
            style="transform: rotate(180deg);">
    </div>
@endsection

@section('contents_menu')
    <li><a href="/me/project/month">リストで表示</a></li>
    <li><a href="#">完了を表示</a></li>
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

                    @for ($nowDay = 7*$i - 6 - $projectInMonth->getStartWeek(), $finishDay = 7*$i - $projectInMonth->getStartWeek(); $nowDay <= $finishDay; $nowDay++)
                        @if ($nowDay <= $projectInMonth->getFinishDay() && $nowDay <= 0)
                            @if ($node->getDayLength() <= 0)
                                @php
                                    $nowDay--;
                                    $projectInMonth->getProjectDataNodeArray()[$loop->index] = $node->getNextNode();
                                @endphp
                            @elseif ($node->isEmpty())
                                <td class="single"></td>
                                @php
                                    $node->setDayLength($node->getDayLength() - 1);
                                @endphp
                            @else
                                @php
                                    $dayLength = 0;
                                    if($finishDay - $nowday > $node->getDayLength())
                                        $dayLength = $node->getDayLength();
                                    else
                                        $dayLength = $finishDay - $nowday;
                                    
                                    $nowday += $dayLength - 1;
                                    $node->setDayLength( $node->getDayLength() -  $dayLength);
                                @endphp
                                <td class="todo_in_month {{ $dayLength === 0 ? 'single' : '' }}" align="left" colspan="$dayLength"
                                    style="background-color: {{ $projectInMonth->getBackGroundCollor($loop->index) }};">
                                    {{ $node->getName() }}
                                </td>
                            @endif
                        @else
                            <td class="single"></td>
                        @endif
                    @endfor

                </tr>
            @endforeach

        @endfor
        
    </table>

@endsection
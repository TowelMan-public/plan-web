@extends('default_layout')

@section('page_name') 
    今月のやること
@endsection

@section('title_name')
    <div>今月のやること</div>
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
    <li><a href="#">完了を非表示</a></li>
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
                                <td class="todo_in_month {{ $dayLength === 0 ? 'single' : '' }}" align="left" colspan="{{ $dayLength }}"
                                    style="background-color: {{ $todoInMonth->getBackGroundCollor($loop->index) }};">
                                    {{ $node->getName() }}
                                </td>
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
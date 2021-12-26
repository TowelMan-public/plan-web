@extends('default_layout')

@section('page_name') 
    骨組み
@endsection

@section('title_name')
    骨組み
@endsection

@section('contents_menu')
    <li><a href="#">HOGE</a></li>
@endsection

@section('contents')
    <div class="todo">
        <div class="inner">
            <div class="name">todo1</div>

            <div class="hamburger_img">
                <img src="{{ asset('img/plus.png') }}">
                <img class="none" src="{{ asset('img/close.png') }}">
            </div>

            <div class="is_completed">
                <img src="{{ asset('img/check.png') }}">
            </div>
        </div>

        <div class="contents none">
            <div class="content">
                <div class="name">・content1</div>

                <div class="is_completed">
                    <img src="{{ asset('img/check.png') }}">
                </div>
            </div>
        </div>
    </div>
@endsection
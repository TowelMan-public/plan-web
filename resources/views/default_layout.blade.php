@extends('base_layout')

@section('page_name') 
    @yield('page_name')
@endsection

@section('header')
    <div class="top_menu menu pc_mode">
        <ul>
            <li><a href="#">HOME</a></li>
            <li><a href="#">ユーザー設定</a></li>

            <li><div class="acd_menu">
                <input id="acd_top_menu_project" type="checkbox">
                <label class="acd_menu_label" for="acd_top_menu_project">
                    <div>プロジェクト</div>
                    <img class="open_img" src="{{ asset('img/plus.png') }}">
                    <img class="close_img" src="{{ asset('img/close.png') }}">
                </label>
                <div class="acd_content menu">
                    <ul>
                        <li><a href="#">作成</a></li>
                        <li><a href="/me/project/list">一覧</a></li>
                    </ul>
                </div>
            </div></li>

            <li><div class="acd_menu">
                <input id="acd_top_menu_my_todo" type="checkbox">
                <label class="acd_menu_label" for="acd_top_menu_my_todo">
                    <div>自分のやること</div>
                    <img class="open_img" src="{{ asset('img/plus.png') }}">
                    <img class="close_img" src="{{ asset('img/close.png') }}">
                </label>
                <div class="acd_content menu">
                    <ul>
                        <li><a href="/me/todo/day">今日</a></li>
                        <li><a href="/me/todo/month">今月</a></li>
                    </ul>
                </div>
            </div></li>      
        </ul>
    </div>
    <div class="top_icons">
        <img class="top_icons_img" src="{{ asset('img/notice.png') }}" alt="" href="#">
        <label for="hamburger_menu_button" class="mobile_mode"><span><img class="top_icons_img" src="{{ asset('img/menu.png') }}"></span></label>
    </div>
@endsection

@section('title_bar')
    <div class="title_bar_inner">
        <div class="title_name">
            <h2>@yield('title_name')</h2>
        </div>

        <div class="title_bar_contents">
            @yield('title_bar_contents')
        </div>
    </div>

    <div class="title_bar_menu pc_mode">
        <label for="hamburger_menu_button" class=""><span><img class="title_bar_menu_img" src="{{ asset('img/menu.png') }}"></span></label>
    </div>

@endsection

@section('outer_contents')
    @if ($__env->yieldContent('contents_menu') !== '')
        <div class="second_menu menu pc_mode">
            <ul>
                <li class="hidden">margin</li>
                @yield('contents_menu')
            </ul>
        </div>
    @endif

    <div class="contents">
        @yield('contents')
    </div>

    <div class="hamburger-menu">
        <input type="checkbox" id="hamburger_menu_button">

        <div class="hamburger_menu_contents_outer hidden_scroll_y">

            <div class="hamburger_menu_contents menu">
                <div class="hamburger_menu_close_button">
                    <label for="hamburger_menu_button" class=""><span><img class="hamburger_menu_close_button_image" src="{{ asset('img/close.png') }}"></span></label>
                </div>

                <ul>
                    @yield('contents_menu')
                </ul>
                <ul>
                    <li><a href="#">HOME</a></li>
                    <li><a href="#">通知</a></li>
                    <li><a href="#">ユーザー設定</a></li>
                    
                    <li><div class="acd_menu">
                        <input id="acd_hamburger_menu_project" type="checkbox">
                        <label class="acd_menu_label" for="acd_hamburger_menu_project">
                            <div>プロジェクト</div>
                            <img class="open_img" src="{{ asset('img/plus.png') }}">
                            <img class="close_img" src="{{ asset('img/close.png') }}">
                        </label>
                        <div class="acd_content menu">
                            <ul>
                                <li><a href="#">作成</a></li>
                                <li><a href="/me/project/list">一覧</a></li>
                            </ul>
                        </div>
                    </div></li>
        
                    <li><div class="acd_menu">
                        <input id="acd_hamburger_menu_my_todo" type="checkbox">
                        <label class="acd_menu_label" for="acd_hamburger_menu_my_todo">
                            <div>自分のやること</div>
                            <img class="open_img" src="{{ asset('img/plus.png') }}">
                            <img class="close_img" src="{{ asset('img/close.png') }}">
                        </label>
                        <div class="acd_content menu">
                            <ul>
                                <li><a href="/me/todo/day">今日</a></li>
                                <li><a href="/me/todo/month">今月</a></li>
                            </ul>
                        </div>
                    </div></li>

                    <li><a href="/logout">ログアウト</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div id="mobile_menu_button" class="mobile_menu_button mobile_mode">
        <label for="hamburger_menu_button" class=""><span><img class="mobile_menu_button_img" src="{{ asset('img/menu.png') }}"></span></label>
    </div>
@endsection
@extends('base_layout')

@section('page_name') 
    @yield('page_name')
@endsection

@section('header')
    <div class="top_menu menu pc_mode">
        <ul>
            <li><a href="/me/todo/day">HOME</a></li>
            <li><a href="/user/config">設定</a></li>

            <li><div class="acd_menu">
                <input id="acd_top_menu_project" type="checkbox">
                <label class="acd_menu_label" for="acd_top_menu_project">
                    <div>プロジェクト</div>
                    <img class="acd_switch_img" src="{{ asset('img/triangle.png') }}">
                </label>
                <div class="acd_content menu">
                    <ul>
                        <li><a href="/me/project/list/invitation">勧誘一覧</a></li>
                        <li><a href="/project/insert">作成</a></li>
                        <li><a href="/me/project/list">一覧</a></li>
                    </ul>
                </div>
            </div></li>

            <li><div class="acd_menu">
                <input id="acd_top_menu_my_todo" type="checkbox">
                <label class="acd_menu_label" for="acd_top_menu_my_todo">
                    <div>自分のやること</div>
                    <img class="acd_switch_img" src="{{ asset('img/triangle.png') }}">
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
        <label for="notice_hamburger_menu_contents_outer_input"><img id="notice_hamburger_menu_img" class="top_icons_img" src="{{ asset('img/notice.png') }}" alt="" href="#"></label>
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

        <div class="hamburger_menu_contents_outer" id="hamburger_menu_contents_outer">

            <div class="hamburger_menu_contents menu hidden_scroll_y" id="hamburger_menu_contents">
                <div class="hamburger_menu_close_button">
                    <label for="hamburger_menu_button" class=""><span><img class="hamburger_menu_close_button_image" src="{{ asset('img/close.png') }}"></span></label>
                </div>

                <ul>
                    @yield('contents_menu')
                </ul>
                <ul>
                    <li><a href="/me/todo/day">HOME</a></li>
                    <li><a href="#">通知</a></li>
                    <li><a href="/user/config">設定</a></li>
                    
                    <li><div class="acd_menu">
                        <input id="acd_hamburger_menu_project" type="checkbox">
                        <label class="acd_menu_label" for="acd_hamburger_menu_project">
                            <div>プロジェクト</div>
                            <img class="acd_switch_img" src="{{ asset('img/triangle.png') }}">
                        </label>
                        <div class="acd_content menu">
                            <ul>
                                <li><a href="/me/project/list/invitation">勧誘一覧</a></li>
                                <li><a href="/project/insert">作成</a></li>
                                <li><a href="/me/project/list">一覧</a></li>
                            </ul>
                        </div>
                    </div></li>
        
                    <li><div class="acd_menu">
                        <input id="acd_hamburger_menu_my_todo" type="checkbox">
                        <label class="acd_menu_label" for="acd_hamburger_menu_my_todo">
                            <div>自分のやること</div>
                            <img class="acd_switch_img" src="{{ asset('img/triangle.png') }}">
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
        <script>
            $('#hamburger_menu_contents_outer').click(function () {
                $('#hamburger_menu_button').removeAttr("checked").prop("checked", false).change();
            });
            $('#hamburger_menu_contents').click(function (e) {
                e.stopPropagation();
            })
        </script>
    </div>

    <div id="mobile_menu_button" class="mobile_menu_button mobile_mode">
        <label for="notice_hamburger_menu_contents_outer_input" class=""><span><img class="mobile_menu_button_img" src="{{ asset('img/menu.png') }}"></span></label>
    </div>

    <div class="hamburger-menu">
        <input type="checkbox" id="notice_hamburger_menu_contents_outer_input">

        <div class="hamburger_menu_contents_outer" id="notice_hamburger_menu_contents_outer">
            <div class="hamburger_menu_contents hidden_scroll_y" id="notice_hamburger_menu_contents">
                <div class="hamburger_menu_close_button">
                    <label for="notice_hamburger_menu_contents_outer_input" class=""><span><img class="hamburger_menu_close_button_image" src="{{ asset('img/close.png') }}"></span></label>
                </div>

                <div id="notice_outer" style="width: 95%; margin-left: auto; margin-right: auto;"></div>
                <script>
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "/notice",
                        type: "get",
                        data : {},
                    })
                    .done((res)=>{
                        if(res === ''){
                            $('#notice_hamburger_menu_contents_outer_input').remove();
                        }else{
                            $('#notice_outer').append(res);
                            $('#notice_hamburger_menu_img').css('background-color', '#f34d00');
                        }
                    })
                    .fail((error)=>{
                        console.log(error.statusText);
                    })
                </script>
            </div>
        </div>

        <script>
            $('#notice_hamburger_menu_contents_outer').click(function () {
                $('#notice_hamburger_menu_contents_outer_input').removeAttr("checked").prop("checked", false).change();
            });
            $('#notice_hamburger_menu_contents').click(function (e) {
                e.stopPropagation();
            })
        </script>
    </div>
@endsection
@extends('base_layout')

@section('page_name') 
    @yield('page_name')
@endsection

@section('title_bar')
    @yield('title_bar')
@endsection

@section('outer_contents')
    <div class="contents">
        @yield('contents')
    </div>
@endsection
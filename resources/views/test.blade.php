@extends('default_layout')

@section('page_name') 
    パブリックプロジェクト
@endsection

@section('title_name')
    パブリックプロジェクト
@endsection

@section('contents_menu')
    <li><a href="#">やること系</a></li>
@endsection

@section('contents')
    
@endsection



.acd_switch_img{
    width: 1em;
    height: 1em;
    transform: rotate(-90deg);
    transition: 1s;
}

.acd_menu>input[type="checkbox"]:checked + .acd_menu_label>.acd_switch_img{
    width: 1em;
    height: 1em;
    transform: rotate(-90deg);
    transition: 1s;
}
@extends('unlogined_layout')

@section('page_name') 
    エラー
@endsection

@section('title_bar')
    <h2>エラー</h2>
@endsection

@section('contents')
    <p style="color: red;">エラーが発生しました。ブラウザバックなどで前のページに戻ってください。</p>
    <form action="{{ url()->previous() }}" method="get">
        <div class="input_label"><input type="submit" value="戻る" class="button"></div>
    </form>
@endsection
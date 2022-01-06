@extends('default_layout')

@section('page_name') 
    機種名一覧
@endsection

@section('title_name')
    機種名一覧
@endsection

@section('contents')

    @foreach ($terminalDataArray as $terminal)
        <div class="terminal" id="{{ 'terminal_'.$terminal->getName() }}">
            <div class="name">{{ $terminal->getName() }}</div>
            <div class="delete_button" id="{{ 'delete_'.$terminal->getName() }}"> 削除 </div>
        </div>
        <script>
            $("{{ '#delete_'.$terminal->getName() }}").click(function (){
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "/terminal/delete",
                    type: "post",
                    data : {
                        terminalName : "{{ $terminal->getName() }}",
                    },
                })
                .done((res)=>{
                    jQuery("{{ '#terminal_'.$terminal->getName() }}").addClass("leaved");
                })
                .fail((error)=>{
                    console.log(error.statusText)
                })
            })
        </script>
    @endforeach

@endsection
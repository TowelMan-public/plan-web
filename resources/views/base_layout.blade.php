<!DOCTYPE html>
<html>
    <head>
        <title>@yield('page_name') - プラン子</title>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <meta name="viewport" content="width=device-width, inital-scale=1">
        <link rel="stylesheet" href="{{ asset('css/base_style.css') }}">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>

    <body>
        
        <header>
            <h1>プラン子♪</h1>
            @yield('header')
        </header>

        <main>
            <div id="title_bar" class="title_bar">
                @yield('title_bar')
            </div>

            <div class="outer_contents">
                @yield('outer_contents')
            </div>
        </main>

        <footer>
            <p>&copy; Towelman. 2021.</p> 
        </footer>
    </body>

    <script src="{{ asset('javascript/base_script.js') }}"></script>
</html>
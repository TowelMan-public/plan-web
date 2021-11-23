<!DOCTYPE html>
<html>
    <head>
        <title>@yield('page_name') - プラン子</title>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <meta name="viewport" content="width=device-width, inital-scale=1">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    </head>

    <body>
        <header>
            <h1>プラン子♪</h1>
        </header>

        <main>
            <div class="title_bar">
                @yield('title_bar')
            </div>

            <div class="contents">
                @yield('contents')
            </div>
        </main>

        <footer>
            <p>&copy; Towelman. 2021.</p> 
        </footer>
    </body>
</html>
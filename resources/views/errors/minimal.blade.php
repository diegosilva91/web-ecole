<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="stylesheet" href="{{ mix('/dist/css/app.css') }}">
        <link rel="stylesheet" href="{{ mix('/dist/css/all.css') }}">

        <script async src="{{ mix('/dist/js/manifest.js') }}" defer></script>
        <script async src="{{ mix('/dist/js/vendor~utils-1.js') }}"></script>
        <script async src="{{ mix('/dist/js/vendor~utils-2.js') }}"></script>
        <script async src="{{ mix('/dist/js/vendor~utils-3.js') }}"></script>
        <script async src="{{ mix('/dist/js/vendor~utils-7.js') }}"></script>
        <script async src="{{ mix('/dist/js/vendor~utils-8.js') }}"></script>
        <!-- Styles -->
        <style>
            .message {
                font-size: 18px;
                text-align: center;
            }
        </style>
    </head>
    <body>
        <div class="content">

                <div id="app">
                    <v-app>
                        @if(Auth::id())
                            <nav-bar class="d-none d-md-flex"
                                    :user_id='@json(Auth::id())'
                                    :user_name='@json(Auth::user()->name)'
                                    :user_avatar='"@image(Auth::user()->avatar)"'
                                    :teacher='@json(Auth::user()->hasRole('teacher'))'
                                    ></nav-bar>
                        @else
                            <nav-bar class="d-none d-md-flex"></nav-bar>
                        @endif
                        <x-navbar-mobile/>
                        <div class="message mt-100" style="padding: 10px;">
                            @yield('custom-message')
                            <a href="{{ route('home') }}">Sigue utilizando nuestros servicios </a>
                            <p>Código del error</p>
                            @yield('code') | @yield('message')
                        </div>
                    </v-app>
                    <footer-new></footer-new>
                </div>
        </div>
        <script>
            function openNav() {
                document.getElementById("mySidebar").style.width = "250px";
// document.getElementById("main").style.marginRight = "250px";
            }

            function closeNav() {
                document.getElementById("mySidebar").style.width = "0";
// document.getElementById("main").style.marginRight = "0";
            }
        </script>
    </body>
</html>

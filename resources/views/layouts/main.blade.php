<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.header-main')
</head>
<body>
<a href="https://wa.me/+34633651856?text=Hola! Estoy interesado en uno de los cursos de Mi-empresa!" class="wpfloat text-light" target="_blank" onclick="sendWPEvent()">
    <i>@php echo Mdi::mdi('whatsapp', null, '30', ['style' => 'margin-top: 11px; fill: #fff']); @endphp</i>
</a>
@if(config('app.env') == 'production')
    <!-- Google Tag Manager (noscript) -->
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id={{config('app.gtm_id')}}"
                height="0" width="0" style="display:none;visibility:hidden"></iframe>
    </noscript>
    <!-- End Google Tag Manager (noscript) -->
@endif

    @section('main_id')<v-app id="app" data-app>@show
        @yield('promo_banner')
        @hasSection('main_content')
        @if(Auth::id())
            <nav-bar
                :user_id='@json(Auth::id())'
                :user_name='@json(Auth::user()->name)'
                :user_avatar='"@image(Auth::user()->avatar)"'
                :teacher='@json(Auth::user()->hasRole('teacher'))'
            ></nav-bar>
        @else
            <nav-bar></nav-bar>
        @endif
        <x-navbar-mobile/>
            @yield('main_content')
        <footer-new></footer-new>
        @endif

        @hasSection('landing_content')
            <div>
            @yield('landing_content')
            </div>
        @endif
        <overlay></overlay>
    </v-app>
@auth
    @if(!Auth::user()->hasRole('teacher')||Auth::user()->hasRole('customer'))
        <div id="auth" >
            <get-member-banner :login="true" :user_id='@json(Auth::id())'></get-member-banner>
        </div>
        <script async src="{{ mix('/dist/js/auth.js') }}"></script>
    @endif
@endauth
@guest
    <div id="guests">
        @section('modals')
            <login-modal :action='@json("Login")'></login-modal>
            <register-modal :action='@json("Register")' :auth='@json(Auth::check())'></register-modal>
            <favorite-message :action='@json("Favorite")'></favorite-message>
        @show
    </div>
    <script async src="{{ mix('/dist/js/guests.js') }}"></script>
@endguest

{{-- NavBar Mobile Script --}}
<script async src="{{ mix('/dist/js/manifest.js') }}" defer></script>
<script async src="{{ mix('/dist/js/vendor~utils-1.js') }}"></script>
<script async src="{{ mix('/dist/js/vendor~utils-2.js') }}"></script>
<script async src="{{ mix('/dist/js/vendor~utils-3.js') }}"></script>
<script async src="{{ mix('/dist/js/vendor~utils-7.js') }}"></script>
<script async src="{{ mix('/dist/js/vendor~utils-8.js') }}"></script>

@stack('scripts')

</body>
</html>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="description" content="@section('description')@isset($seo_description){{$seo_description}}@else{{__('Cursos y extraescolares online con profesores cualificados: Refuerzo de Matemáticas; Iniciación a la Programación y Robótica; Música, Idiomas y mucho más.')}}@endisset @show"/>
<title>@section('title')@isset($seo_title){{$seo_title}}@else{{__('Mi-empresa | Las mejores extraescolares online para niños')}}@endisset @show</title>

<!-- Open Graph meta tags -->
@section('og_tags_image')
<meta property="og:image" content="{{ asset('assets/images/logo/logo_share.jpg') }}"/>
@show
@section('og_tags')
    <meta property="og:title" content="@isset($seo_title){{$seo_title}}@else{{__('Mi-empresa | Las mejores extraescolares online para niños')}}@endisset"/>
    <meta property="og:type" content="article" />
    <meta property="og:site_name" content="{{__('Mi-empresa')}}"/>
    <meta property="og:url" content="{{url()->current()}}"/>
    <meta property="og:locale" content="{{app()->getLocale()}}"/>
@show

<!-- Robots meta tag -->
<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1" />

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Favicon and icons -->
<meta name="apple-mobile-web-app-capable" content="yes">
<link rel="apple-touch-icon" sizes="60x60" href="{{ asset('assets/images/favicon/favicon.png') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/favicon/favicon.png') }}">

@include('feed::links')

<!-- Preconnect, preload and DNS prefetch -->
@section('pre_loads')
<link rel="preconnect" href="https://www.googletagmanager.com" crossorigin>
<link rel="preconnect" href="https://myawsmi-empresa.s3-eu-west-1.amazonaws.com" />
<link rel="dns-prefetch" href="https://myawsmi-empresa.s3-eu-west-1.amazonaws.com" />
<link rel="preconnect" href="https://fonts.gstatic.com"/>
<link rel="dns-prefetch" href="//fonts.gstatic.com">
@show

<!-- Font families -->
<link
    rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
    media="print"
    onload="this.media='all'"
>
<link
    rel="preload"
    href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap"
    as="style"
    onload="this.rel='stylesheet'"
>

<!-- Stylesheets -->
<link rel="stylesheet"  href="{{ mix('/dist/css/external_resources~2.css') }}">
<link rel="stylesheet" href="{{ mix('/dist/css/all.css') }}">
<link rel="stylesheet" href="{{ mix('/dist/css/app.css') }}">

<!-- Google Tag Manager -->
<script async defer>
    window.setTimeout(  function(){
    (function (w, d, s, l, i) {
        w[l] = w[l] || [];
        w[l].push({
            'gtm.start':
                new Date().getTime(), event: 'gtm.js'
        });
        var f = d.getElementsByTagName(s)[0],
            j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
        j.async = true;
        j.src =
            'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
        f.parentNode.insertBefore(j, f);
    })(window, document, 'script', 'dataLayer', '{{config('app.gtm_id')}}');}, 15);
</script>

<!-- Global site tag (gtag.js) - Google Ads: 589803715 -->
<script async type='text/javascript'>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }

    gtag('js', new Date());
    gtag('set', { 'currency': 'EUR' });
    gtag('config', '{{config('app.gtag_id')}}',{'send_page_view': false});
    gtag('config', 'AW-589803715');
    gtag('require', 'ec');
    @section('google_tag_manager')@show
    function sendWPEvent(){
        gtag('event', 'ContactWhats');
    }
</script>

<!-- Production deploy only -->
@if(config('app.env') == 'production')
    <noscript>
        <img height="1" width="1" src="https://www.facebook.com/tr?id=2955856227834662&ev=PageView&noscript=1"/>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" />

        <!-- Material Components web -->
        <link href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css" rel="stylesheet">

        <!-- Vuetify font/icons -->
        <link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">
    </noscript>

    <!-- End Facebook Pixel Code -->
    <script async id="Cookiebot" src="https://consent.cookiebot.com/uc.js" data-cbid="0a8ef051-6461-4256-aac2-dab9d70870d1" data-blockingmode="auto" type="text/javascript"></script>
@endif

@stack('styles')

@preload

@php
    $seo_title = '✓Política de Cookies ⇨ Cursos y extraescolares online ᐅ MI-EMPRESA';
    $seo_description = '✓ MI-EMPRESA Política de Cookies ⇨ Descubre los mejores cursos y extraescolares online con profesores cualificados ᐅ Refuerzo de Matemáticas; Programación y Robótica; Música, Idiomas y más';
@endphp

@extends('layouts.main')
@section('main_id') @parent @endsection

@section('og_tags')
    @parent
    <meta name="robots" content="noindex">
@endsection

@section('main_content')
    <x-text-cookies/>
@endsection

@push('scripts')
    <script id="CookieDeclaration" src="https://consent.cookiebot.com/0a8ef051-6461-4256-aac2-dab9d70870d1/cd.js" type="text/javascript" async></script>
    <script async src="{{ mix('/dist/js/app.js') }}"></script>
@endpush

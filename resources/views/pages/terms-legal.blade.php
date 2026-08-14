@php
    $seo_title = '✓Aviso Legal ⇨ Cursos y extraescolares online ᐅ MI-EMPRESA';
    $seo_description = '✓ MI-EMPRESA Aviso Legal ᐅ Cursos y extraescolares online ⇨ Refuerzo de Matemáticas; Iniciación a la Programación y Robótica; Música, Idiomas y mucho más';
@endphp

@extends('layouts.main')
@section('main_id') @parent @endsection

@section('og_tags')
    @parent
    <meta name="robots" content="noindex">
@endsection

@section('main_content')
    <x-text-legal />
@endsection

@push('scripts')
    <script async src="{{ mix('/dist/js/app.js') }}"></script>
@endpush

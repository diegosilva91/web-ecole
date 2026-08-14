@php
    $seo_title = '✓Política de Privacidad ⇨ Cursos y extraescolares online ᐅ MI-EMPRESA';
    $seo_description = '✓ MI-EMPRESA Política de Privacidad ⇨ Cursos y extraescolares online con profesores cualificados ᐅ Refuerzo de Matemáticas; Programación y Robótica; Música, Idiomas y más';
@endphp

@extends('layouts.main')
@section('main_id') @parent @endsection

@section('og_tags')
    @parent
    <meta name="robots" content="noindex">
@endsection

@section('main_content')
    <x-text-privacy />
@endsection

@push('scripts')
    <script async src="{{ mix('/dist/js/app.js') }}"></script>
@endpush

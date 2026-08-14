@extends('layouts.main')
@section('main_id') @parent @endsection

@section('og_tags')
    @parent
    <meta name="robots" content="noindex">
@endsection

@section('title'){{__('✓Términos y Condiciones ⇨ Cursos y extraescolares online ᐅ MI-EMPRESA')}}@endsection
@section('description'){{__('✓ MI-EMPRESA Condiciones Generales ᐅ Cursos y extraescolares online ⇨ Refuerzo de Matemáticas; Iniciación a la Programación y Robótica; Música, Idiomas y mucho más')}}@endsection

@section('main_content')
    <x-text-conditions/>
@endsection

@push('scripts')
    <script async src="{{ mix('/dist/js/app.js') }}"></script>
@endpush

@php
    $seo_title = __('✓ Sobre nosotros ⇨ Cursos y extraescolares online ᐅ LIFECOLE');
    $seo_description = __('✓LIFECOLE ᐅ Los mejores cursos y extraescolares online ⇨ Refuerzo de Matemáticas; Iniciación a la Programación y Robótica; Música, Idiomas y mucho más');
@endphp

@extends('layouts.main')
@section('main_id') <v-app id="about"> @endsection

@prepend('styles')
    <style type="text/css">
        @media (min-width: 1800px){
        .container{
            max-width: 1185px !important;
        }
    }
    </style>
@endprepend

@section('main_content')
<div>
    <about-header></about-header>
    <about-info class="mt-mob-100 mt-tb-100 mt-dk-100"></about-info>
    <about-cards class="mt-mob-100 mt-tb-100 mt-dk-100"></about-cards>
    <about-team class="mt-mob-100 mt-tb-100 mt-dk-100"></about-team>
    <about-inversor class="mt-mob-100 mt-tb-100 mt-dk-100 mb-mob-100 mb-tb-100 mb-dk-100"></about-inversor>
</div>
@endsection

@push('scripts')
    <script async src="{{ mix('/dist/js/about.js') }}"></script>
@endpush

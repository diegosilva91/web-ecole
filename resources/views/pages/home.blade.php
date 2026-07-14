@php
    $seo_title = __('Mejores Cursos Online y Extraescolares - Lifecole');
    $seo_description = __('Descubre nuestros cursos online y extraescolares ✔️ Profesorado altamente cualificado. ¡Encuentra el curso online que necesitas!');
@endphp

@extends('layouts.main')

@section('pre_loads')
    @parent
    <link rel="preload" as="image" href="{{ asset('assets/images/home/boy_robot.png') }}" />
@endsection

@section('main_id') @parent @endsection

@section('promo_banner')
    @if($topBannerHome['visible'] == true)
        <top-banner :top-banner-home='@json($topBannerHome)'></top-banner>
    @endif
@endsection

@section('main_content')
    <home-page :auth="@json(!Auth::check())"> </home-page>
@endsection

@push('scripts')
    <script async src="{{ mix('/dist/js/app.js') }}"></script>
@endpush

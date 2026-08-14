@extends('layouts.main')
@section('main_id') <v-app id="landingPage"> @endsection

@prepend('styles')
    <style type="text/css">
        @media (min-width: 1800px){
            .container{
                max-width: 1185px !important;
            }
        }
    </style>
@endprepend

@section('landing_content')
    <navbar-landing></navbar-landing>

    <header-landing-tech></header-landing-tech>
    {{-- <tech-header class="mt-100" bg='bg-tech-red' title='Campus de Navidad'
                     description='Estas Navidades regala educación y un futuro a tus hijos con nuestros campus de programación y redes sociales. Inscribe a tus hijos en nuestros campus de Navidad del día 27/12 al 30/12 y descubre todos nuestros horarios.'
                     img='campus' winter='true'></tech-header> --}}
    <banner-courses class="mt-mob-60 mt-100" view-type="" landing-mkt=true></banner-courses>
    <landing-tags></landing-tags>
    <landing-video class="mt-100"></landing-video>
    <landing-banner class="mt-100"></landing-banner>
    <landing-reviews class="mt-100"></landing-reviews>
    <sponsors-baner id="colaboradores" class="mt-100"></sponsors-baner>
    <landing-contact class="mt-100 mb-80 mb-dk-150"></landing-contact>

    <landing-modal-tech></landing-modal-tech>

    <footer-landing></footer-landing>
@endsection

@push('scripts')
    <script async src="{{ mix('/dist/js/landing.js') }}"></script>
    @if(Request::path()!=='es' && env('APP_ENV')==='production')
        <script src="https://cdn.lr-in.com/LogRocket.min.js" crossorigin="anonymous"></script>
        <script>window.LogRocket && window.LogRocket.init('ivavob/leadslf');</script>
    @endif
@endpush

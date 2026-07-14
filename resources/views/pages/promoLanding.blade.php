@php
    $seo_title = __('✓ Descuentos Lifecole ⇨ Cursos y extraescolares online ᐅ LIFECOLE');
    $seo_description = __('✓LIFECOLE ᐅ Los mejores cursos y extraescolares online ⇨ Iniciación a la Programación,Robótica y Videojuegos');
@endphp

@extends('layouts.main')
@section('main_id') <v-app id="promos"> @endsection

@section('main_content')
    <promo-landing view_type="cybermonday"></promo-landing>
@endsection

@push('scripts')
    <script async src="{{ mix('/dist/js/promo.js') }}" defer></script>
@endpush

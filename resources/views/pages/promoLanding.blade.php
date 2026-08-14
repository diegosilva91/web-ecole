@php
    $seo_title = __('✓ Descuentos Mi-empresa ⇨ Cursos y extraescolares online ᐅ MI-EMPRESA');
    $seo_description = __('✓MI-EMPRESA ᐅ Los mejores cursos y extraescolares online ⇨ Iniciación a la Programación,Robótica y Videojuegos');
@endphp

@extends('layouts.main')
@section('main_id') <v-app id="promos"> @endsection

@section('main_content')
    <promo-landing view_type="cybermonday"></promo-landing>
@endsection

@push('scripts')
    <script async src="{{ mix('/dist/js/promo.js') }}" defer></script>
@endpush

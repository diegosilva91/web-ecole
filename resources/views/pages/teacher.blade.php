@php
    $seo_title = __('Empieza a dar clases Online - Genera Ingresos Extra - Mi-empresa ');
    $seo_description = __('Empieza a impartir educación a tu medida y genera ingresos extra ¡Empieza a dar clases Online o grupos reducidos en Mi-empresa!');
@endphp

@extends('layouts.main')
@section('main_id') <v-app id="teacherPage"> @endsection

@section('main_content')
    <div>
        <teacher-header :user_id='@json(Auth::id())' ></teacher-header>
        <teacher-benefits class="mt-mob-100 mt-tb-100 mt-dk-100"></teacher-benefits>
        <teacher-lifecooler class="mt-mob-100 mt-tb-100 mt-dk-100"></teacher-lifecooler>
        <teacher-cards></teacher-cards>
        <teacher-faq class="mt-mob-100 mt-tb-100 mt-dk-100 mb-mob-100 mb-tb-100 mb-dk-100"></teacher-faq>
    </div>
@endsection

@push('scripts')
    <script async src="{{ mix('/dist/js/new-teacher.js') }}"></script>
@endpush

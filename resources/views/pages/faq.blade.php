@extends('layouts.main')
@section('main_id') <v-app id="faq"> @endsection

@section('main_content')
<div>
    <h2 class="home-section-title text-dark mb-20 mt-30 mt-dk-100 mx-auto">Preguntas Frecuentes</h2>
    <frequently-questions class="container mt-30" is-teacher='false' title="FAQ’S ALUMNOS"></frequently-questions>
    <frequently-questions class="container mb-dk-100 mt-30 mb-30" is-teacher='true' title="MODELO ACADÉMICO"></frequently-questions>
</div>
@endsection

@push('scripts')
<script async src="{{ mix('/dist/js/faq.js') }}"></script>
@endpush

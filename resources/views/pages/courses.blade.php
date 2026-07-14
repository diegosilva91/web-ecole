@php
    $seo_title = __('Encuentra Cursos Intensivos Online- Lifecole ');
    $seo_description = __('Descubre Cursos Intensivos Online a medida. ✔️Aprende desde casa ✔ Profesores cualificados. Cursos con grupos reducidos ¡Entra y descúbrelos!');
@endphp

@extends('layouts.main')
@section('main_id') <v-app id="courses"> @endsection

@section('google_tag_manager')
    @if(Request::segment(2)=='cursos')
        dataLayer.push({
            'pageTitle': 'cursos',
            'pageCategory': 'cursos',
        });
    @endif
@endsection

@section('main_content')
<div>
    <filter-courses :tree-filters='@json($treeFilters)'></filter-courses>
</div>
@endsection

@push('scripts')
    <script async src="{{ mix('/dist/js/courses.js') }}"></script>
@endpush

@extends('layouts.main')
@section('main_id') <v-app id="courses"> @endsection

@prepend('styles')
    <style type="text/css">
        @media (min-width: 1800px){
        .container{
            max-width: 1185px !important;
        }
    }
    </style>
@endprepend

@section('description')
    {{__('✓ Los mejores cursos y extraescolares online en vivo ⇨ Refuerzo de Matemáticas; Iniciación a la Programación y Robótica; Música, Idiomas y más ᐅ LIFECOLE')}}
@endsection
@section('og_tags_image') @parent @endsection
@section('og_tags') @parent @endsection
@section('title'){{__('Más de 300 cursos y clases online para niños | Lifecole')}}@endsection
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
        <x-courses-list class="mb-20" :courses="$featuredCourses" :origin="'teachers'" />
	</div>
@endsection

@push('scripts')
    <script async src="{{ mix('/dist/js/courses.js') }}"></script>
@endpush

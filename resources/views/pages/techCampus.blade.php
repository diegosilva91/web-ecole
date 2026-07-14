@php
    $seo_title = __($infoCampus['title'] . ' - Lifecole, cursos online para niños');
    $seo_description = __('✓ '. $infoCampus['title'] .' ᐅ LIFECOLE. Cursos y extraescolares de verano online ⇨ Refuerzo de Matemáticas; Iniciación a la Programación y Robótica; Música, Idiomas y mucho más');
@endphp

@extends('layouts.main')
@section('main_id') <v-app id="course-categories" data-app> @endsection

@prepend('styles')
    <style type="text/css">
        @media (min-width: 1800px){
			.container{
				max-width: 1185px !important;
			}
        }

        @media (max-width: 430px) {
            .h2-txt-sbold {
                font-size: 26px;
            }
        }

        p>span {
            font-weight: 600;
            display: inline;
        }
    </style>
@endprepend

@section('main_content')
	<tech-header bg=@json($infoCampus["bg"]) title=@json($infoCampus["title"])
	             description=@json($infoCampus["description"], JSON_UNESCAPED_SLASHES)
	             img=@json($infoCampus["img"])></tech-header>
	<h2 class="container h2-txt-sbold mt-50" style="text-align: center">{{$infoCampus['title']}}</h2>

    {{--
    @if ($infoCampus['campus'] == 'holy_week')
            <div style="text-align: center; font-weight: 300; font-size: 16px; margin-left: 30px; margin-right: 30px">Todos nuestros cursos al <span style="color: #29c0d3; font-weight: 600; font-size: 18px">10% de descuento</span> hasta el 15/03/22</div>
    @endif
    --}}

    {{-- @if ($infoCampus['campus'] == 'summer')
        <div
            style="text-align: center; font-weight: 300; font-size: 16px; margin-left: 30px; margin-right: 30px"
        >Todos nuestros campus al 
            <span style="color: #29c0d3; font-weight: 600; font-size: 18px">
                10% de descuento
            </span> hasta el 31/05/22
        </div>
    @endif --}}


        <courses-tech type_course='@json(\App\Course::TYPE_CAMPUS)'></courses-tech>
@endsection

@push('scripts')
<script async src="{{ mix('/dist/js/categories-courses.js') }}" defer></script>
@endpush

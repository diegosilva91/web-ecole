@php
    $seo_title = 'Clases de Robótica Online para Iniciarse - Mi-empresa';
    $seo_description = 'Curso de robótica online iniciarse en este mundo ✔️Clases desde casa ✔ Profesores cualificados ✔ Cursos con grupos reducidos ¡Aprende Aquí!';
@endphp

@extends('layouts.main')
@section('main_id') <v-app id="course-categories"> @endsection

@prepend('styles')
    <style type="text/css">
        .subtitle-SEO{
            font-family: 'Poppins', sans-serif;
            font-size: 12px;
            font-weight: 500;
            color: #5b2867;
        }

        p>b, p>a{
            font-weight: 500 !important;
        }

        @media (min-width: 1800px){
			.container{
				max-width: 1185px !important;
			}
        }
    </style>
@endprepend

@section('main_content')
    <tech-header bg='bg-tech-purple' title="Cursos de Robótica" description='Fomentarás en tus hijos la exploración y el ingenio para despertar nuevas inquietudes, les despertarás la  pasión por la ciencia y aprenderán a resolver problemas.' img='robot'></tech-header>
    <h2 class="container h2-txt-sbold mt-50">Cursos de Robótica</h2>
    <courses-tech type_course='@json(\App\Course::TYPE_INTENSIVE)' :options-request-selected='@json($optionsRequestSelected)'></courses-tech>

    {{-- SEO --}}
    <div class="container mt-50 mb-100 text-justify">
        <h2 class="h5-txt-med mb-4">Aprende más…</h2>
        <div class="row">
            <div class="col-12 col-md-6">
                <h2 class="subtitle-SEO mb-3">Cursos de robótica</h2>
                <div class="h8-txt-light">
                    <p>¿Sabías que la mayoría de las profesiones que habrá dentro de 10 años, todavía no se han inventado? Lo que está claro es que la programación está empezando a ser, y seguirá siendo en el futuro un conocimiento básico que vale la pena dominar.</p>
                    <p>Los <b>cursos de robótica para niños</b> son una excelente manera de empezar a introducirlos en este mundo de la programación de forma divertida. De esta forma se van familiarizando con estos conceptos que los acompañaran toda la vida y lo viven como un juego.</p>
                    <p>En <a class="blue-title" href="/es"> Mi-empresa</a> creemos que cuanto antes empiecen mejor, por eso, hemos creado una <b>categoría de cursos de robótica</b> para que, tengan el nivel que tengan, los peques de la casa puedan iniciarse en el mundo de la programación de robots.</p>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <h2 class="subtitle-SEO mb-3">Cursos de robótica para niños</h2>
                <div class="h8-txt-light">
                    <p>Apuntar a los niños a <b>cursos de robótica desde pequeños</b> tiene muchos beneficios; desde <b>fomentar su creatividad y desarrollar la lógica, hasta mejorar su atención y concentración en sus tareas diarias</b>. Además, por su puesto, de prepararlos para su futuro profesional en el que seguramente tendrán que aplicar alguno de estos conocimientos.</p>
                    <p>Una manera fantástica de empezar es con nuestro curso <a class="blue-title" href="/es/cursos/robotica-educativa-y-profesional/robots-y-programacion/aprende-a-programar-con-arduino-y-abre-las-puertas-a-la-robotica">Arduino: Bases de la robótica</a>, en el que de forma amena y divertida empezarán a familiarizarse con los lenguajes de programación.</p>
                    <p>Otro de nuestros <b>cursos de robótica</b> favoritos es el de <a class="blue-title" href="/es/cursos/robotica-educativa-y-profesional/robots-y-programacion/introduccion-a-la-programacion-en-python">Python - Aprende a programar robots</a>, perfecto para niños que quieran empezar con la robótica. Los alumnos
                    aprenderán conceptos de programación, diseño e impresión 3D y circuitos
                    electrónicos.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6">
                <h2 class="subtitle-SEO mb-3">Cursos de robótica online con profesores cualificados</h2>
                <div class="h8-txt-light">
                    <p>En Mi-empresa contamos con profesores expertos en pedagogía infantil y juvenil, que plantean los <b>cursos de robótica orientados 100% a los alumnos</b> y al desarrollo de cada uno de ellos.</p>
                    <p>Además, todos <b>nuestros cursos son online, y están pensados para grupos reducidos</b>, para que el aprendizaje y las habilidades adquiridas <b>en nuestros cursos de robótica sean lo más amenos y divertidos posible</b>.</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script async src="{{ mix('/dist/js/categories-courses.js') }}" defer></script>
@endpush

@php
    $seo_title = 'Cursos de Programación Web Online - Lifecole';
    $seo_description = 'Descubre los mejores cursos de programación web online ✔️Aprende desde casa ✔ Profesores cualificados ✔ Aptos para niños. ¡Entra Aquí! ';
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
    <tech-header bg='bg-tech-blue' title="Cursos Desarrollo web/app" description='Saber desarrollar webs tiene cada vez más, una serie de ventajas sociales y culturales. Tus hijos dominarán las herramientas necesarias para diseñar una página web. Entrenando el ojo en la estética y la organización.' img='web'></tech-header>
    <h2 class="container h2-txt-sbold mt-50">Cursos de Desarrollo Web/App</h2>
    <courses-tech type_course='@json(\App\Course::TYPE_INTENSIVE)' :options-request-selected='@json($optionsRequestSelected)'></courses-tech>

    {{-- SEO --}}
    <div class="container mt-50 mb-100 text-justify h8-txt-light">
        <h2 class="h5-txt-med mb-4">Aprende más…</h2>
        <div class="row">
            <div class="col-12 col-md-6">
                <h2 class="subtitle-SEO mb-3">Cursos de desarrollo web y App</h2>
                <p>La creación de páginas web se ha convertido en un conocimiento de lo más útil en muchísimos campos de la actividad profesional.</p>
                <p>Aunque uno no se dedique a la programación de páginas web o de Apps, tener algunos conocimientos básicos puede marcar la diferencia a la hora de conseguir una posición mejor dentro de una empresa.</p>
                <p>Además, <b>hacer cursos de desarrollo web y App ayuda al desarrollo de la creatividad y potencian la concentración y productividad</b>, a la vez que son amenos y pueden llegar a convertir el desarrollo web en un hobby o incluso una profesión.</p>
            </div>
            <div class="col-12 col-md-6">
                <h2 class="subtitle-SEO mb-3">Cursos de desarrollo web y App con profesores cualificados</h2>
                <p>Tanto si lo que les interesa a tus hijo@s es aprender a crear <a class="blue-title" href="/es/cursos/desarrollo-web-y-cloud/creacion-y-diseno-web/creacion-de-una-pagina-web-con-wordpress">aprender a crear webs con wordpress</a> o prefieren hacerlas con <a class="blue-title" href="/es/cursos/desarrollo-web-y-cloud/creacion-y-diseno-web/crea-y-disena-tu-propia-pagina-web"> HTML5 y CSS</a>, tenemos el curso de desarrollo web y App perfecto.</p>
                <p>Nuestros profesores tienen muchísima experiencia en su campo, pero lo que los hace únicos es que todos <b>se han especializado en el ámbito educativo por lo que están enfocados al alumnado al 100%</b>.</p>
                <p>Su vocación por la pedagogía infantil y juvenil combinada con nuestro método online de motivación durante el aprendizaje, convierten <b>nuestros cursos de desarrollo web y App en una opción fantástica para iniciarse en el mundo de la programación</b>.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6">
                <h2 class="subtitle-SEO mb-3"> Clases personalizadas de desarrollo web y App</h2>
                <p>En <a class="blue-title" href="/es"> Lifecole</a> ofrecemos varios cursos de desarrollo web y <a class="blue-title" href="/es/cursos/desarrollo-apps/apps-faciles/crea-tus-propias-apps-para-android-basico"> App</a> para diversos grupos de edad.</p>
                <p>Crear una página web desde cero puede sonar a tarea titánica cuando uno lo piensa, pero con nuestros cursos de desarrollo web y App será un proceso divertido y ameno.</p>
                <p>Te aseguramos de que tus hij@s no solo aprenderán conceptos básicos de programación y <a class="blue-title" href="/es/cursos/desarrollo-web-y-cloud/creacion-y-diseno-web/crea-y-disena-tu-propia-pagina-web"> crearán su primera página web</a> o <b>App móvil</b>, también desarrollarán habilidades que podrán aplicar a cualquier situación de su vida, ¡incluso en el colegio!</p>
                <p>Aprenderán a:</p>
                <ul>
                    <li>-&nbsp;&nbsp; Hacer una buena organización general</li>
                    <li>-&nbsp;&nbsp; Distribuir la información de forma eficaz y lógica</li>
                    <li>-&nbsp;&nbsp; Desarrollar pensamiento analítico, lógico y estructurado</li>
                    <li>-&nbsp;&nbsp; Potenciar la creatividad</li>
                    <li>-&nbsp;&nbsp; Incrementar la concentración</li>
                </ul>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script async src="{{ mix('/dist/js/categories-courses.js') }}" defer></script>
@endpush

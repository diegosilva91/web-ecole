@php
    $seo_title = 'Cursos de Programación Online - Lifecole';
    $seo_description = 'Curso de programación online. ✔️ Profesores experto en programación ✔ Clases online ✔ Cursos personalizados ✔ Aprende des de casa ¡Apúntate!';
    if(empty($optionsRequestSelected)){
        $optionsRequestSelected= null;
    }
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
    <tech-header bg='bg-tech-darkblue' title="Cursos de Programación" description='Mejora en tus hijos la concentración, el desarrollo de la lógica, las capacidades de planificación y orden. Además estimularás su creatividad, su  imaginación y la originalidad.' img='code'></tech-header>
    <h2 class="container h2-txt-sbold mt-50">Cursos anuales de Programación</h2>
    <search-trajectories-list :filter='@json($filter??'Programación')' :options-request-selected='@json($optionsRequestSelected)'></search-trajectories-list>
    <h2 class="container h2-txt-sbold mt-50">Cursos intensivos de Programación</h2>
    <courses-tech type_course='@json(\App\Course::TYPE_INTENSIVE)' :options-request-selected='@json($optionsRequestSelected)' ></courses-tech>

    {{-- SEO --}}
    <div class="container mt-50 mb-100 text-justify">
        <h2 class="h5-txt-med mb-4">Aprende más…</h2>
        <div class="row">
            <div class="col-12 col-md-6">
                <h2 class="subtitle-SEO mb-3">Cursos de programación</h2>
                <div class="h8-txt-light">
                    <p>A día de hoy, cada vez más se considera <b>la programación como algo imprescindible de dominar, o por lo menos conocer en muchísimos ámbitos profesionales</b>. Hay una gran cantidad de ramas alejadas de la informática en las que se valora y demanda mucho un perfil con conocimientos de programación. </p>
                    <p>En <a class="blue-title" href="/es">Lifecole</a> lo sabemos, por eso hemos creado esta <b>categoría específica para todos nuestros cursos de programación</b>. Aquí encontrarás todos los cursos que podemos ofrecerte para que tus hij@s puedan empezar a sentar las bases de estos conocimientos.</p>
                    <p><b>¡Descubre todo lo que nuestros cursos de programación pueden hacer por el futuro profesional de tus peques!</b></p>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <h2 class="subtitle-SEO mb-3">Cursos de programación para niños sin salir de casa</h2>
                <div class="h8-txt-light">
                    <p>Nuestra metodología de cursos online en vivo permite que los <b>niños y jóvenes de entre 3 y 18 años aprendan de forma segura y desde la comodidad de casa</b>.</p>
                    <p>Ofrecemos <b>gran variedad de cursos de programación de varios niveles</b> para que los alumnos que se matriculen puedan ir avanzando, progresando, y adquiriendo conocimientos y habilidades cada vez más avanzados.</p>
                    <p>Un ejemplo de esto son nuestros <a class="blue-title" href="/es/cursos/programacion/programacion-educativa/programacion-para-nin-at-s-con-scratch"> cursos de programación con Scratch</a>; son perfectos para diversos grupos de edades y ofrecen contenidos de varios niveles para que cada alumno pueda <b>empezar con los cursos de programación sin importar sus conocimientos iniciales</b>.</p>
                    <p>Otro de nuestros cursos de programación favoritos es perfecto para aprender a
                    <a class="blue-title" href="/es/cursos/desarrollo-web-y-cloud/webs-profesionales/programa-con-javascript"> programar con JavaScript</a>, e incluso con <a class="blue-title" href="/es/cursos/programacion/programacion-profesional/inicia-a-la-programacion-para-videojuegos-y-robotica-con-c">Lenguaje C</a>. Aprenderán las bases y
                    particularidades de estos lenguajes, a realizar algoritmos complejos y a gestionar y
                    operar datos.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6">
                <h2 class="subtitle-SEO mb-3">Más de 300 cursos para los genios del futuro</h2>
                <div class="h8-txt-light">
                    <p>En Lifecole tenemos por <b>objetivo ayudar a los alumnos a adoptar y desarrollar nuevas competencias del siglo XXI</b>. Además, nos esforzamos para que en todos nuestros cursos se fomenten y aprendan 3 conceptos básicos para llevar a cabo cualquier tipo de proyecto:</p>
                    <ul>
                        <li>-&nbsp;&nbsp; Pensamiento crítico</li>
                        <li>-&nbsp;&nbsp; Trabajo en equipo</li>
                        <li>-&nbsp;&nbsp; Creatividad</li>
                    </ul>
                    <p class="mt-3">¡Elige de entre nuestros cursos de programación y a aprender se ha dicho!</p>
                </div>
            </div>
        </div>
    </div>
    {{-- end --}}
@endsection

@push('scripts')
    <script async src="{{ mix('/dist/js/categories-courses.js') }}" defer></script>
@endpush

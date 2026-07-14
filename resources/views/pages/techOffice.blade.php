@php
    $seo_title = 'Curso para Microsoft Office Online - Lifecole';
    $seo_description = 'Encuentra el curso de Microsoft Office online que necesitas ✔️ Clases online ✔ Cursos personalizados ✔ Con ejercicios prácticos. ¡Entra Aquí!';
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
    <tech-header bg='bg-tech-blue' title="Microsoft Office" description='Tus hijos aprenderán a dominar el entorno de microsoft office para convertirse en los profesionales del futuro. Desarrollarán nuevas capacidades de comunicación y gestión
    de contenidos.' img='office'></tech-header>
    <h2 class="container h2-txt-sbold mt-50">Cursos de Microsoft Office</h2>
    <courses-tech type_course='@json(\App\Course::TYPE_INTENSIVE)' :options-request-selected='@json($optionsRequestSelected)'></courses-tech>

    {{-- SEO --}}
    <div class="container mt-50 mb-100 text-justify h8-txt-light">
        <h2 class="h5-txt-med mb-4">Aprende más…</h2>
        <div class="row">
            <div class="col-12 col-md-6">
                <h2 class="subtitle-SEO mb-3">Cursos de Microsoft Office</h2>
                <p>Hay pocas habilidades que, a día de hoy, sean realmente un básico para cualquier profesión. Pero dominar las herramientas de Microsoft Office se ha convertido en un imprescindible para prácticamente cualquier trabajo, incluso para poder seguir las clases de educación superior.</p>
                <p>En <a class="blue-title" href="/es"> Lifecole</a> sabemos que <b>es importante que desde pequeños los niños vayan familiarizándose con todas estas herramientas</b> para que, cuando llegue el momento de usarlas ya sea en el colegio, la universidad o el día de mañana cuando empiecen a trabajar, no tengan que preocuparse por la mecánica.</p>
                <p>Por todo esto, hemos creado una categoría únicamente dedicada a agrupar todos <b>nuestros cursos de Microsoft Office</b> para que no te pierdas ninguno.</p>
            </div>
            <div class="col-12 col-md-6">
                <h2 class="subtitle-SEO mb-3">Clases personalizadas sin salir de casa</h2>
                <p>En Lifecole te ofrecemos <b>extraescolares divertidos, educativos y seguros</b>, que tus hij@s podrán hacer desde la comodidad de tu casa.</p>
                <p>Echa un vistazo a nuestros <b>cursos de Microsoft Office</b> y descubre todo lo que podemos hacer por su futuro profesional gracias a la gran variedad de cursos.</p>
                <p>¿A qué esperas para apuntarles?</p>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6">
                <h2 class="subtitle-SEO mb-3">Cursos de Microsoft Office online para niños</h2>
                <p>Si quieres que tus hij@s tengan su primer contacto con el paquete de Microsoft Office la mejor opción sería nuestro <b>Curso para utilizar las </b> <a class="blue-title" href="/es/cursos/informatica-general/ofimatica/introduccion-y-manejo-herramientas-office-365"> herramientas Office365</a>.</p>
                <p>Se trata de uno de nuestros <b>cursos de Microsoft Office más completo</b>, ya que <b>el temario repasa todos los programas de este paquete</b>.</p>
                <p>Por otro lado, uno de los programas que más útiles en todas las profesiones, y que vale la pena dominar, es el Excel. Sabemos que según como, puede ser un programa de lo más confuso, pero tenemos la solución.</p>
                <p>En nuestra categoría de cursos de Microsoft Office, encontrarás <b>cursos de Excel por niveles</b>, para que, tanto si tus hij@s están empezando de cero, como si ya han usado este programa alguna vez, puedan seguir aprendiendo y dominarlo.</p>
{{--                <p>Podrás elegir entre:</p>--}}
{{--                <ul>--}}
{{--                    <li>-&nbsp;&nbsp; <a class="blue-title" href="/es/cursos/informatica-general/ofimatica/microsoft-excel-para-principiantes"> Básico</a> </li>--}}
{{--                </ul>--}}
                <p>Transformarán datos en información útil, y los gestionarán en tablas de datos. En nuestra categoría de <b>cursos de Microsoft Office</b>, encontrarás nuestro curso de <a  class="blue-title" href="/es/cursos/informatica-general/ofimatica/microsoft-excel-para-principiantes">Excel: Nivel básico</a>. Este curso es perfecto para que tus hij@s puedan empezar a familiarizarse con esta herramienta tan importante y a dominar sus funciones y características básicas de forma fácil gracias a los <b>ejercicios prácticos</b>.</p>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script async src="{{ mix('/dist/js/categories-courses.js') }}" defer></script>
@endpush

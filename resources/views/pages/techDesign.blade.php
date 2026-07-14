@php
    $seo_title = 'Cursos de Diseño 3D online Desde Casa - Lifecole';
    $seo_description = 'Cursos de diseño 3D online para iniciarse. Aprende: Indesign, Illustrator, Photoshop y mucho más ✔️ Profesores cualificados. ¡Entra Aquí!';
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
    <tech-header bg='bg-tech-yellow' shadow='true' title="Cursos de Diseño" description='Hoy en día todo lo que vemos está compuesto por un diseño. Con nuestros cursos tus hijos aprenderán a trabajar como un diseñador gráfico y 3D, desarrollando la creatividad, la concentración y dando rienda suelta a su imaginación.' img='design'></tech-header>
    <h2 class="container h2-txt-sbold mt-50">Cursos de Diseño</h2>
    <courses-tech type_course='@json(\App\Course::TYPE_INTENSIVE)' :options-request-selected='@json($optionsRequestSelected)'></courses-tech>

    {{-- SEO --}}
    <div class="container mt-50 mb-100 text-justify h8-txt-light">
        <h2 class="h5-txt-med mb-4">Aprende más…</h2>
        <div class="row">
            <div class="col-12 col-md-6">
                <h2 class="subtitle-SEO mb-3">Cursos de diseño 3D</h2>
                <p>Seguro que más de una vez has oído hablar sobre las impresoras 3D. Estas innovadoras herramientas han llegado para quedarse y estamos seguros de que <b>van a formar parte de las nuevas profesiones que vayan creándose en el futuro</b>.</p>
                <p>En <a class="blue-title" href="/es"> Lifecole</a> creemos que <b>nunca es demasiado pronto para empezar a aprender y adquirir habilidades técnicas</b> que puedan posteriormente puedan aplicarse a otras facetas de la vida de los más pequeños.</p>
                <p>Por eso, hemos creado la <b>categoría de cursos de diseño 3D</b>, donde podrás encontrar todos nuestros cursos relacionados para que tus hij@s aprendan a diseñar en 3D.</p>
            </div>
            <div class="col-12 col-md-6">
                <h2 class="subtitle-SEO mb-3">Clases de diseño 3D con contenido innovador y diferente</h2>
                <p>En Lifecole nos apasiona crear cursos innovadores y diferentes para que los niños puedan desarrollar nuevas habilidades que les resulten útiles en su futuro.</p>
                <p>Con <b>nuestros cursos de diseño 3D</b> os alumnos desarrollarán el razonamiento lógico e intelectual, además de impulsar su desarrollo creativo.</p>
                <p>Si esta va a ser su primera vez usando una herramienta de este tipo, te recomendamos que empiecen por uno de nuestros <b>cursos de diseño 3D con</b> <a class="blue-title" href="/es/cursos/robotica-educativa-y-profesional/robots-y-programacion/diseno-modelado-tinkercard"> Tinkecard</a>. Este programa es perfecto para <b>iniciarse en el desarrollo y modelado de objetos en 3D</b>.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6">
                <h2 class="subtitle-SEO mb-3">Cursos de diseño 3D online para niños</h2>
                <p>Si estás buscando cursos de diseño 3D para los peques de la casa, estás en el sitio indicado. Te ofrecemos <b>cursos online para niños de todas las edades y con diferentes niveles para que puedan aprender en un entorno seguro y de forma personalizada</b>.</p>
                <p>Uno de nuestros <b>cursos de diseño 3D</b> favoritos es el de <a class="blue-title" href="/es/cursos/modelado-3d-y-escultura-digital/modelado-3d/disena-el-mundo-de-pokemon-con-blender">diseño en 3D con Blender</a>. Además de introducir a los alumnos a la programación de forma divertida y sencilla, aprenderán a cooperar, lógica y creatividad. Descubrirán otras herramientas de diseño del paquete de Adobe como <a class="blue-title" href="/es/cursos/ilustracion-pintura-y-diseno-grafico-digital/dibujo-ilustracion-y-diseno-grafico/aprende-a-utilizar-photoshop-nivel-basico">Photoshop</a>, <a class="blue-title" href="/es/cursos/ilustracion-pintura-y-diseno-grafico-digital/dibujo-ilustracion-y-diseno-grafico/aprende-illustrator-nivel-basico">Illustrator</a> o <a class="blue-title" href="/es/cursos/ilustracion-pintura-y-diseno-grafico-digital/dibujo-ilustracion-y-diseno-grafico/introduccion-al-adobe-indesign">Indesign</a>.</p>
                <p>¿Lo mejor de todo? Tenemos un nivel básico para que sea cual sea el nivel de partida, los alumnos puedan seguir aprendiendo y mejorando.</p>
                <p>En los cursos de esta categoría los alumnos no solo podrán aprender diseño gráfico; si tus peques están más interesados en el diseño 3D, te recomendamos que empiecen por uno de nuestros cursos de diseño con Tinkecard. Este programa es perfecto para iniciarse en el desarrollo y modelado de objetos en 3D, además ofrecemos diversos niveles para que puedan avanzar y mejorar.</p>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script async src="{{ mix('/dist/js/categories-courses.js') }}" defer></script>
@endpush

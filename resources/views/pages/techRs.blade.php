@php
    $seo_title = 'Cursos para Redes Sociales 100% Online - Mi-empresa ';
    $seo_description = 'Domina las redes sociales, con alguno de nuestros cursos para redes sociales totalmente online ✔️ Profesores cualificados ¡Descúbrelos!';
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
    <tech-header bg='bg-tech-yellow' shadow='true' title="Redes Sociales" description='Tus hijos aprenderán a explorar y navegar por internet trabajando sus habilidades sociales de manera segura. Aprenderán a comunicarse en público de manera fluida y a planificar sus propios contenidos.' img='rs'></tech-header>
    <h2 class="container h2-txt-sbold mt-50">Cursos de Redes Sociales</h2>
    <courses-tech type_course='@json(\App\Course::TYPE_INTENSIVE)' :options-request-selected='@json($optionsRequestSelected)'></courses-tech>

    {{-- SEO --}}
    <div class="container mt-50 mb-100 text-justify h8-txt-light">
        <h2 class="h5-txt-med mb-4">Aprende más…</h2>
        <div class="row">
            <div class="col-12 col-md-6">
                <h2 class="subtitle-SEO mb-3">Cursos de redes sociales</h2>
                <p>Las <b>redes sociales se han convertido en un auténtico básico en nuestro día a día</b>, las usamos desde para mantener el contacto con amigos a los que hace tiempo que no vemos hasta para estar al día de las noticias más importantes.</p>
                <p>Y si son tan importantes, ¿<b>porqué nadie está enseñando a los más pequeños a sacarles el máximo partido con toda la seguridad</b>?</p>
                <p>En <a class="blue-title" href="/es"> Mi-empresa</a> creemos que las redes han llegado para quedarse, y es nuestro deber educar a nuestros hij@s para que sean auténticos nativos del mundo digital, ya que esta es la dirección en la que va el mundo.</p>
                <p>Por todo esto, te presentamos esta categoría con <b>todos nuestros cursos de redes sociales</b>, para que tus hij@s puedan elegir el que más les guste y <b>¡empezar a sacar partido a las redes sociales!</b></p>
            </div>
            <div class="col-12 col-md-6">
                <h2 class="subtitle-SEO mb-3">Clases extraescolares de redes sociales</h2>
                <p>Nuestros cursos de redes sociales son de lo más variados, pero lo que todos tienen en común es que <b>ponen la seguridad del alumno en el centro</b>, a la vez que ofrecen un contenido de gran calidad para <b>convertir las redes sociales en una herramienta positiva para el futuro de los niños</b>.</p>
                <p>Y es que parece que no, pero <b>hay muchísimas redes sociales y cada una ofrece miles de posibilidades que vale la pena explorar</b>, eso es lo que queremos conseguir con nuestros cursos de redes sociales.</p>
                <p>¿<b>Alguna vez te has preguntado que hay que hacer para </b> <a class="blue-title" href="/es/cursos/streaming-y-podcast/youtuber/crea-tu-propio-canal-de-youtube"> ser Youtuber</a>? Con este curso de redes sociales los niños de entre 8 y 18 años aprenderán todo lo que hay que saber para crear una comunidad y mantenerla activa de la forma más segura.</p>
                <p>Si lo que les va es <a class="blue-title" href="/es/cursos/influencer-tendencias-y-comunidad/multimedia-y-vlogging/saca-todo-el-partido-a-instagram"> Instagram</a>, te recomendamos que los apuntes a alguno de nuestros <b>cursos de redes sociales para aprender a sacarles partido</b>. ¡Incluso podrán aprender a crear su propia <a class="blue-title" href="/es/cursos/gaming-y-streaming/gamers-y-streaming/crea-tu-propia-comunidad-de-gaming"> comunidad de Gaming</a>!</p>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6">
                <h2 class="subtitle-SEO mb-3">Mi-empresa, clases extraescolares online y en vivo para niños de 3 a 18 años</h2>
                <p>En Mi-empresa tenemos el objetivo de ofrecer clases extraescolares online y en vivo de la más alta calidad para niños de entre 3 y 18 años.</p>
                <p>Nuestras disciplinas son innovadoras y diferentes, porque <b>queremos formar parte del desarrollo de las nuevas competencias del siglo XXI de nuestros alumnos</b>.</p>
                <p>El mejor ejemplo son nuestros cursos de redes sociales, ¡<b>descúbrelos todos en nuestro </b> <a class="blue-title" href="/es/cursos"> buscador de cursos</a>!</p>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script async src="{{ mix('/dist/js/categories-courses.js') }}" defer></script>
@endpush

@php
    $seo_title = 'Cursos de Idiomas Online ¡Aprende desde casa! - Mi-empresa ';
    $seo_description = 'Aprende inglés o francés desde casa. con nuestros cursos de idiomas online ✔️Profesorado cualificado ✔ Cursos de refuerzo ¡Descúbrelos!';
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
    <tech-header bg='bg-tech-darkblue' title="Cursos de Refuerzo e idiomas" description='Gracias a nuestros cursos de refuerzo e idiomas nunca fue tan divertido aprender. ¡Domina cualquier idioma o mejora en tus asignaturas de forma fácil
    y entretenida!' img='lang'></tech-header>
    <h2 class="container h2-txt-sbold mt-50">Cursos de Refuerzo e Idiomas</h2>
    <courses-tech type_course='@json(\App\Course::TYPE_INTENSIVE)' :options-request-selected='@json($optionsRequestSelected)'></courses-tech>

    {{-- SEO --}}
    <div class="container mt-50 mb-100 text-justify h8-txt-light">
        <h2 class="h5-txt-med mb-4">Aprende más…</h2>
        <div class="row">
            <div class="col-12 col-md-6">
                <h2 class="subtitle-SEO mb-3">Descubre los cursos de idiomas y refuerzo de Mi-empresa</h2>
                <p>Tus hijos pasan la mayor parte de la semana estudiando de clase en clase, pero algunas
                veces, ni siquiera esto es suficiente. Si crees que necesitan un <b>empujón con alguna de
                sus asignaturas</b> para que sus resultados sean todavía mejores, en <a class="blue-title" href="/es">Mi-empresa</a> tenemos la solución <b>¡Elige nuestros cursos de idiomas y de refuerzo!</b></p>
                <p>¿Aún no has visto nuestro catálogo de <b>cursos de idiomas y cursos de refuerzo</b>? En él
                se esconden cientos de oportunidades que están esperando a ser descubiertas. Tanto
                si preferís clases <a class="blue-title" href="/es/cursos/apoyo-escolar/lengua/refuerzo-en-lenguaje-y-comunicacion-clases-individuales">particulares</a> como <a class="blue-title" href="/es/cursos/apoyo-escolar/lengua/refuerzo-en-lenguaje-y-comunicacion-clases-en-grupo">grupales</a>, harán una inmensa contribución al aprendizaje de tus hijos. ¡No esperes a que ellos se queden detrás!</p>
            </div>
            <div class="col-12 col-md-6">
                <h2 class="subtitle-SEO mb-3">Cursos de refuerzo de Lengua y Matemáticas</h2>
                <p>Las matemáticas no son una asignatura fácil, y si a tus peques tiran más hacia las
                letras, puede ser que necesiten algo de <a class="blue-title" href="/es/cursos/apoyo-escolar/matematicas/mejora-en-matematicas-clases-individuales">ayuda extra con los números</a>. Sabemos que
                todas las asignaturas son igual de importantes y que es importante que adquieran
                todos esos conocimientos, por eso, hemos creado nuestros <b>cursos de refuerzo en
                matemáticas</b>.</p>
                <p>
                Tanto si necesitan <b>apoyo en lengua o en matemáticas o si quieren mejorar en inglés
                y/o francés</b>, los cursos de idiomas y los cursos de refuerzo de Mi-empresa serán su mejor
                aliado para recuperar la marcha y <b>ponerse al día con sus clases</b>.
                </p>
                <p class="mt-3"><b>¿A qué esperas para apuntarlos a los cursos de idiomas o cursos de refuerzo?</b></p>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6">
                <h2 class="subtitle-SEO mb-3">¡Aprender inglés y francés es fácil con nuestros cursos de idiomas!</h2>
                <p>No es un secreto que hay cursos y asignaturas en las que los más peques pueden
                quedarse algo rezagados. Los motivos de esto pueden ser de lo más variados, pero lo
                importante es que <b>podemos ayudarles a volver a coger el ritmo</b>. ¡Elige entre nuestros
                <b>cursos de refuerzo</b> y enseguida notarás la mejora en sus notas!</p>
                <p>Como todos sabemos, en un mundo globalizado como el nuestro, el inglés es un
                básico. Por eso, entre nuestros cursos de idiomas, te recomendamos las <a class="blue-title" href="/es/cursos/idiomas/ingles/aprende-ingles-clases-en-grupo">clases en grupo</a>.</p>
                <p>Por otro lado, si tus hijos muestran un interés especial en aprender francés, la mejor
                manera para empezar o de <b>mejorar su nivel es con los cursos de idiomas</b> en forma de
                <a class="blue-title" href="/es/cursos/idiomas/frances/aprende-frances-clases-individuales">clases individuales</a>.</p>
                <p>Aprender <a class="blue-title" href="/es/cursos/idiomas/ingles/aprende-ingles-clases-individuales">otro idioma</a> no es una tarea fácil, eso está claro; pero las oportunidades que
                se abrirán ante tus hij@s al dominar otra lengua son innumerables. <b>¡Descubre todos
                nuestros cursos de idiomas!</b></p>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script async src="{{ mix('/dist/js/categories-courses.js') }}" defer></script>
@endpush

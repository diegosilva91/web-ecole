@php
    $seo_title = 'Curso de Programación de Videojuegos Online - Mi-empresa';
    $seo_description = 'Curso de programación de videojuegos online. ✔️ Ideales de 3 a 18 años ✔ Clases desde casa ✔ Profesorado altamente cualificado. ¡Apúntate!';
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
    <tech-header bg='bg-tech-purple' title="Creación de videojuegos" description='Ayudarás a tus hijos a afrontar retos y problemas de manera lógica y estructurada. Les enseñarás a pensar en conceptos y flujos de trabajo de manera divertida y práctica.' img='game'></tech-header>
    <h2 class="container h2-txt-sbold mt-50">Cursos anuales de Creación de Videojuegos</h2>
    <search-trajectories-list :filter='@json($filter??'Videojuegos')' :options-request-selected='@json($optionsRequestSelected)'></search-trajectories-list>
    <h2 class="container h2-txt-sbold mt-50">Cursos intensivos de Creación de Videojuegos</h2>
    <courses-tech type_course='@json(\App\Course::TYPE_INTENSIVE)' :options-request-selected='@json($optionsRequestSelected)'></courses-tech>


    {{-- SEO --}}
    <div class="container mt-50 mb-100 text-justify h8-txt-light">
        <h2 class="h5-txt-med mb-4">Aprende más…</h2>
        <div class="row">
            <div class="col-12 col-md-6">
                <h2 class="subtitle-SEO mb-3">Cursos de videojuegos</h2>
                <p>Si a tu hij@ le enloquecen los videojuegos y aprovecha cualquier ocasión para aprender más sobre cómo programarlos, <b>tenemos los cursos de videojuegos perfectos</b>.</p>
                <p>Los <b>cursos de videojuegos de </b><a class="blue-title" href="/es"> Mi-empresa</a> son la manera perfecta de empezar a sumergirse en el mundo de la programación y aprender los básicos. Con nuestro método de clases online, los peques y no tan peques de la casa (nuestros cursos son aptos para niños de 3 a 18 años) podrán empezar a crear sus primeros videojuegos.</p>
                <p>¿Quieres saber más sobre el método Mi-empresa?</p>
            </div>
            <div class="col-12 col-md-6">
                <h2 class="subtitle-SEO mb-3">Cursos de videojuegos para niños</h2>
                <p>Al apuntar a tu hijo a algunos de nuestros cursos de videojuegos, obtendrás <b>acceso directo a los profesores</b>. Todos ellos son expertos en pedagogía infantil y juvenil con todos los recursos necesarios para conseguir que los alumnos adquieran todas las habilidades y capacidades de forma lúdica y amena.</p>
                <p>Con nuestros <b>cursos de videojuegos no tendrás que preocuparte por los conocimientos previos</b> de tus hij@s, tenemos cursos de todos los niveles desde niveles de iniciación hasta cursos avanzados.</p>
                <p>Si es la primera vez que tu peque va a programar, te recomendamos que empiece por nuestro curso de videojuegos <a class="blue-title" href="/es/cursos/creacion-de-videojuegos/videojuegos-profesionales/iniciacion-a-unity-crea-tus-primeros-paisajes-y-videojuegos-en-3d">Iniciación a Unity: Tus primeros videojuegos en 3D</a>. Otra muy buena opción para empezar sería nuestro <a class="blue-title" href="/es/cursos/creacion-de-videojuegos/programacion-y-videojuegos/crea-videojuegos-en-3d-con-kodu-basico">curso básico de Kodu</a>.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6">
                <h2 class="subtitle-SEO mb-3">Clases de videojuegos con contenido innovador y diferente</h2>
                <p>En Mi-empresa trabajamos para que tus hijos puedan acceder a <b>los mejores cursos de videojuegos para aprender desde casa</b>.</p>
                <p>Descubre nuestra gran variedad de cursos de videojuegos; ofrecemos los temarios más innovadores para que tus hij@s aprendan a programarlos de forma original y desde la comodidad de casa.</p>
                <p>Uno de nuestros <b>cursos de videojuegos</b> favoritos es <a class="blue-title" href="/es/cursos/creacion-de-videojuegos/videojuegos-profesionales/iniciacion-a-unity-crea-tus-primeros-paisajes-y-videojuegos-en-3d">C# y Unity: desarrolla tus videojuegos.</a>, se trata del curso perfecto para introducirse de lleno en el actual lenguaje más importante de Microsoft, #C. Se trata, por lo tanto, del curso perfecto para empezar a descubrir el mundo de la programación, la informática y el desarrollo profesional de videojuegos.</p>
                <p>Y si son fans de Roblox, el curso <a class="blue-title" href="/es/cursos/creacion-de-videojuegos/programacion-y-roblox/crea-tus-primeros-videojuegos-roblox">para crear tus primeros videojuegos con Roblox</a> les encantará. Es la manera perfecta de iniciarse en la ingeniería informática, el desarrollo de videojuegos y la programación, además de aprender los conceptos básicos del modelado 3D.</p>
            </div>
            <div class="col-12 col-md-6">
                <h2 class="subtitle-SEO mb-3">Cursos de Minecraft</h2>
                <p>Seguro que alguna vez tus peques te han hablado de Minecraft el juego de moda. Pero, ¿sabías que existen <b>cursos de Minecraft que pueden ayudar a tus hij@s a dominar conceptos matemáticos a la vez que desarrollan su creatividad</b>?</p>
                <p>Minecraft es, ante todo, un juego creativo que despertará el espíritu de superación personal de los más pequeños. ¿Y qué mejor manera puede haber de aprender disciplina y determinación que con su juego favorito?</p>
                <p>¡Apúntalos a los <b>cursos de Minecraft de </b> <a class="blue-title" href="/es"> Mi-empresa</a> y descubrid todos los beneficios!</p>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6">
                <h2 class="subtitle-SEO mb-3">Clases personalizadas de Minecraft</h2>
                <p>Una de las ventajas principales de apuntar a tus peques a <b>cursos de Minecraft</b> es que a través de algo que les gusta, aprenderán muchísimas otras cosas que les serán de gran utilidad en su día a día.</p>
                <p>Por ejemplo, <b>con uno de nuestros cursos de Minecraft favoritos</b>, <a class="blue-title" href="/es/cursos/creacion-de-videojuegos/programacion-y-minecraft/aprende-a-programar-con-minecraft-nivel-2"> Mejora la capacidad de resolución de problemas con Minecraft</a>, no solo aprenderán a resolver conflictos, sino que también descubrirán las diferencias entre electricidad y electrónica y sus fundamentos básicos entre muchísimas otras cosas.</p>
                <p>Los <b>cursos de Minecraft también son geniales para desarrollar la creatividad</b> de los más pequeños; <a class="blue-title" href="/es/cursos/creacion-de-videojuegos/programacion-y-minecraft/protege-tu-minecraft-con-una-contrasena-iniciacion"> Despierta tu creatividad con Minecraft</a> es perfecto para entender los conceptos básicos de diseño de videojuegos y sus fases de desarrollo.</p>
                <p>Además, con estos cursos de Minecraft, tus hij@s también podrán aprender a <a class="blue-title" href="/es/tech/programacion">programar</a>, a la vez que <b>dominan conceptos matemáticos como longitud, volumen so superficie</b>.</p>
            </div>
            <div class="col-12 col-md-6">
                <h2 class="subtitle-SEO mb-3"> Mi-empresa, cursos extraescolares online y en vivo para niñ@s de 3 a 18 años</h2>
                <p>Nuestros cursos de Minecraft se imparten siempre online en grupos reducidos para asegurar que los niñ@s aprendan de forma amena y divertida y adquieran e internalicen los conocimientos y habilidades planteados en el curso.</p>
                <p>En <a class="blue-title" href="/es"> Mi-empresa</a> pretendemos que los más pequeños aprendan a trabajar en equipo, desarrollando su creatividad y espíritu crítico en un entorno digital y seguro.</p>
                <p>Descubre todo lo que podemos hacer por el desarrollo de tus hij@s, <b>¡Apúntalos a nuestros cursos de Minecraft y ayúdalos a desarrollar todo su potencial!</b></p>
            </div>
        </div>
    </div>
    {{-- end --}}
@endsection

@push('scripts')
    <script async src="{{ mix('/dist/js/categories-courses.js') }}" defer></script>
@endpush

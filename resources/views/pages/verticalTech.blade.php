@php
    $seo_title = 'Aprender con Nuestros Cursos de Tecnología Online - Mi-empresa';
    $seo_description = 'Cursos de tecnología online: ✔️Clases personalizadas ✔ Personal cualificado en nuevas tecnologías ✔ Desde casa. Entra Aquí y... ¡Apúntate!';
    if(empty($optionsRequestSelected)){
        $optionsRequestSelected= null;
    }
@endphp

@extends('layouts.main')
@section('main_id') <v-app id="courses"> @endsection

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
    <tech-header bg='bg-tech-darkblue' title="Cursos de programación y tecnología" description='Iniciarse en la programación permite desarrollar habilidades y resulta especialmente eficiente cuando se comienza a edades tempranas.
    ¡Descubre los beneficios!' img='vertical_tech'></tech-header>
    {{-- Desktop --}}
    <div class="d-none d-lg-block">
        <h2 class="container h2-txt-sbold mt-50">Cursos de Programación y Tecnología</h2>

        <search-list-courses :searchquery='@json(request()->get('search',null))' :options-request-selected='@json($optionsRequestSelected)' class="mb-20"></search-list-courses>

        <x-tech-cards title1="Programación" link1="/es/tech/programacion"
                      p1="A través de la programación tus hijos trabajarán la creatividad y la capacidad de enfrentar nuevos retos. Aprendiendo nuevos lenguajes que les permitirá comprender los entresijos de las nuevas tecnologías. El pensamiento computacional les ayudará a ser creativos, a razonar y a resolver problemas."
                      img1="/assets/images/tech_vector/code.svg"
                      title2="Desarrollo Web/App" link2="/es/tech/web"
                      p2="Los desarrolladores web son como duendes con poderes: nunca los ves, pero son los que hacen que toda la web esté bien y funcione correctamente. Con nuestros cursos tus hijos aprenderán a crear una web, un blog o una app. Y desarrollarán  habilidades como la comunicación, el trabajo en equipo, la lógica y la creatividad."
                      img2="/assets/images/tech_vector/web.svg"
                      title3="Robótica" link3="/es/tech/robotica"
                      p3="La robótica es la base de la ingeniería, la construcción y la operación de robots. Diseñarás máquinas robotizadas que sean capaces de realizar tareas automatizadas. Enseña a tus hijos desde temprana edad para desarrollar aptitudes y capacidades computacionales para los pequeños retos diarios, aplicando la tecnología."
                      img3="/assets/images/tech_vector/robot.svg" hiddenTitle=""/>
        <x-tech-banner bg="bg-banner" colortxt="text-light" title="Creación de Videojuegos" link="/es/tech/videojuegos"
                       p="En la creación de un videojuego aprenderán desde el concepto inicial hasta el videojuego en su versión final. Es una actividad multidisciplinaria, que inbolucra campos de la programación, diseño gráfico, animación, sonido, música, actuación, etc. Crear un videojuego es el inicio para el desarrollo creativo y pensamiento lógico de manera rápida y creativa."
                       img="/assets/images/tech_vector/game.svg"/>
        <div class="mb-100">
            <x-tech-cards title1="Microsoft Office" link1="/es/tech/microsoft_office"
                          p1="Dominar el entorno Office hoy en día es fundamental para que los estudiantes sean más productivos y se introduzcan en un conjunto de herramientas ofimáticas que van a necesitar tanto para su vida personal como profesional. Con nuestros cursos tus hijos dominarán las herramientas necesarias para desarrollar proyectos y trabajos de forma segura y exitosa."
                          img1="/assets/images/tech_vector/office.svg"
                          title2="Diseño" link2="/es/tech/diseno"
                          p2="El diseño gráfico y el diseño 3D es otra de las profesiones del futuro, además de que es una de las áreas que fomenta el desarrollo de la creatividad, la capacidad de expresión en el medio visual e incrementa la concentración. Podrás ver como se materializa tu resultado final a través de la creatividad invertida en los diferentes proyectos."
                          img2="/assets/images/tech_vector/design.svg"
                          title3="Redes Sociales" link3="/es/tech/redes_sociales"
                          p3="La generación Z nace en un entorno digital y social donde se desarrollan habilidades interpersonales. Enseñamos a tus hijos a saber gestionar las redes sociales para sacar el máximo provecho de estas en un entorno profesional y seguro, convirtiéndote en el siguiente comunity manager del s.XXI"
                          img3="/assets/images/tech_vector/rs.svg" hiddenTitle="d-none"/>
        </div>
    </div>

    {{-- Mobile --}}
    <div class="d-block d-lg-none">
        <h2 class="container h3-txt-sbold mt-30">Cursos de Programación y Tecnología</h2>

        <search-list-courses :searchquery='@json(request()->get('search',null))' :options-request-selected='@json($optionsRequestSelected)' class="mb-20"></search-list-courses>

        <x-tech-cards-mob title1="Programación" link1="/es/tech/programacion"
                          p1="A través de la programación tus hijos trabajarán la creatividad y la capacidad de enfrentar nuevos retos. Aprendiendo nuevos lenguajes que les permitirá comprender los entresijos de las nuevas tecnologías. El pensamiento computacional les ayudará a ser creativos, a razonar y a resolver problemas."
                          img1="/assets/images/tech_vector/code.svg"
                          title2="Desarrollo Web/App" link2="/es/tech/web"
                          p2="Los desarrolladores web son como duendes con poderes: nunca los ves, pero son los que hacen que toda la web esté bien y funcione correctamente. Con nuestros cursos tus hijos aprenderán a crear una web, un blog o una app. Y desarrollarán  habilidades como la comunicación, el trabajo en equipo, la lógica y la creatividad."
                          img2="/assets/images/tech_vector/web.svg"
                          title3="Robótica" link3="/es/tech/robotica"
                          p3="La robótica es la base de la ingeniería, la construcción y la operación de robots. Diseñarás máquinas robotizadas que sean capaces de realizar tareas automatizadas. Enseña a tus hijos desde temprana edad para desarrollar aptitudes y capacidades computacionales para los pequeños retos diarios, aplicando la tecnología."
                          img3="/assets/images/tech_vector/robot.svg" hiddenTitle=""/>
        <x-tech-banner-mob bg="bg-banner" colortxt="text-light" title="Creación de Videojuegos"
                           link="/es/tech/videojuegos"
                           p="En la creación de un videojuego aprenderán desde el concepto inicial hasta el videojuego en su versión final. Es una actividad multidisciplinaria, que inbolucra campos de la programación, diseño gráfico, animación, sonido, música, actuación, etc. Crear un videojuego es el inicio para el desarrollo creativo y pensamiento lógico de manera rápida y creativa."
                           img="/assets/images/tech_vector/game.svg"/>
        <div class="mb-100">
            <x-tech-cards-mob title1="Microsoft Office" link1="/es/tech/microsoft_office"
                              p1="Dominar el entorno Office hoy en día es fundamental para que los estudiantes sean más productivos y se introduzcan en un conjunto de herramientas ofimáticas que van a necesitar tanto para su vida personal como profesional. Con nuestros cursos tus hijos dominarán las herramientas necesarias para desarrollar proyectos y trabajos de forma segura y exitosa."
                              img1="/assets/images/tech_vector/office.svg"
                              title2="Diseño" link2="/es/tech/diseno"
                              p2="El diseño gráfico y el diseño 3D es otra de las profesiones del futuro, además de que es una de las áreas que fomenta el desarrollo de la creatividad, la capacidad de expresión en el medio visual e incrementa la concentración. Podrás ver como se materializa tu resultado final a través de la creatividad invertida en los diferentes proyectos."
                              img2="/assets/images/tech_vector/design.svg"
                              title3="Redes Sociales" link3="/es/tech/redes_sociales"
                              p3="La generación Z nace en un entorno digital y social donde se desarrollan habilidades interpersonales. Enseñamos a tus hijos a saber gestionar las redes sociales para sacar el máximo provecho de estas en un entorno profesional y seguro, convirtiéndote en el siguiente comunity manager del s.XXI"
                              img3="/assets/images/tech_vector/rs.svg" hiddenTitle="d-none"/>
        </div>
    </div>


    {{-- SEO --}}
    <div class="container mt-50 mb-100 text-justify h8-txt-light">
        <h2 class="h5-txt-med mb-4">Aprende más…</h2>
        <div class="row">
            <div class="col-12 col-md-6">
                <h2 class="subtitle-SEO mb-3">Cursos de programación y tecnología</h2>
                <p>Actualmente las clases online están a la orden del día, y la verdad es que ofrecen muchísimas posibilidades y
                    oportunidades tanto para los alumnos como para los profesores y los padres. </p>
                <p>Por eso, si a tu hij@ le apasionan las nuevas tecnologías y se muere de ganas de aprender aún más, en <a
                        class="blue-title" href="/es"> Mi-empresa</a> tenemos la solución perfecta.</p>
                <p>Descubre todos nuestros <b>cursos de programación para niños</b> y elige el que sea perfecto para el peque de
                    la casa, y que mejor encaje con tu horario.</p>
                <p>Si ninguna de las horas encaja con vuestro ritmo de vida, ¡no te preocupes! <b>Solicita un nuevo horario para
                        vuestros cursos de programación favoritos</b>.</p>
            </div>
            <div class="col-12 col-md-6">
                <h2 class="subtitle-SEO mb-3 mt-5">Clases online de programación con profesores cualificados</h2>
                <p>Todos los profesores de nuestros cursos de programación son <b>expertos en pedagogía infantil y juvenil</b>.
                </p>
                <p>Gracias a nuestro formato, los docentes podrán dedicarse al 100% a la evolución de todos los alumnos, para
                    que desarrollen al máximo sus capacidades y habilidades.</p>
                <p>Nuestra metodología online en grupos reducidos hará que los cursos de programación sean más amenos para los
                    niños, y que puedan adquirir todos los conocimientos a la vez que se divierten.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6">
                <h2 class="subtitle-SEO mb-3">Cursos de programación online para niños</h2>
                <p>Nuestros cursos de programación online para niños ofrecen muchísimas posibilidades. Y es que en Mi-empresa
                    ofrecemos cursos de todo tipo para que todos los peques apasionados de la programación y la tecnología
                    puedan potenciar su pasión.</p>
                <p>¿No sabes qué elegir? Echa un vistazo a algunas de nuestras categorías de cursos de programación:</p>
                <ul>
                    <li>-&nbsp;&nbsp; <a class="blue-title" href="/es/tech/videojuegos"> Cursos de videojuegos</a> ¿Quieres
                        aprender a programar videojuegos? Tanto si eres un apasionado del <b>Minecraft</b> como si tu sueño es
                        crear videojuegos de Realidad Aumentada, aquí encontrarás <b>tus cursos de programación perfectos</b>.
                    </li>
                    <li>-&nbsp;&nbsp; <a class="blue-title" href="/es/tech/web"> Cursos de desarrollo web y App</a> Aprende a
                        crear tus propias Apps desde 0 y desarrolla tus páginas web con estos cursos de programación.
                    </li>
                    <li>-&nbsp;&nbsp; <a class="blue-title" href="/es/tech/robotica"> Cursos de robótica</a> Apréndelo todo
                        sobre robótica e inteligencia artificial con nuestros cursos de programación de robots.
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script async src="{{ mix('/dist/js/courses.js') }}"></script>
@endpush

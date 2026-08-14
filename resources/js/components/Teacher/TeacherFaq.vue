<template>
<div class="container">
    <h2 class="h2-txt-med text-center mb-15">
        Preguntas frecuentes
    </h2>
    <v-expansion-panels class="container">
      <div class="row">
      <v-expansion-panel v-for="i in faqTeacher" :key="i.question">
        <v-expansion-panel-header class="question">
          {{i.question}}
          <template v-slot:actions>
            <v-icon color="#29c0d3">$expand</v-icon>
          </template>
        </v-expansion-panel-header>
        <v-expansion-panel-content class="answer">
          {{i.answer}}
          <div v-html="i.html"></div>
        </v-expansion-panel-content>
      </v-expansion-panel>
      </div>
    </v-expansion-panels>
</div>
</template>

<script>
export default {
  data() {
      return {

        faqTeacher: [
        {
          question: '¿Cómo funcionan las clases?',
          answer: 'Las clases se realizan a través de Google Meet. Google Meet nos permite visualizar cómodamente sus pantallas, gestionar la comunicación adecuadamente, y también viene con muchas herramientas útiles de gestión del aula para que las clases funcionen agradablemente.',
        },
        {
          question: '¿Cuál es la duración de las clases?',
          answer: 'Según el programa académico la duración varía. Puedes ojear nuestra Web y ver los tiempos de los distintos programas académicos. Verás que todos siguen una estructura estándar similar.',
          html:"<p class='mt-2'>Resumen de los tiempos de los programas académicos habituales:</p><ul><li>• Cursos intensivos: 1 hora/sesión.</li><li>• Trayectorias educativas: 1 hora 15min/ sesión.</li><li>• Campus: 75, 90 o 115 min/ sesión.</li></ul>"
        },
        {
          question: '¿Cuánto voy a cobrar?',
          answer: 'Mi-empresa dispone un sistema de rangos en el que valoramos el nivel, experiencia vuestra evolución con nosotros.',
          html:"<p class='mt-2'>Según tu rango de educador podrás ganar entre 15€ y 30€ por hora de clase impartida.</p>"
        },
        {
          question: '¿Qué perfil profesional debo tener para ser elegible en la Escuela de Educadores?',
          answer: 'Desde Mi-empresa tenemos en cuenta tanto tu trayectoria académica como tu experiencia profesional. Si realmente quieres dar clase de alguna materia que conoces, intentaremos darte la oportunidad de que con nosotros puedas evolucionar hasta donde desees llegar.',
        },
        {
          question: '¿Puedo compaginar otro trabajo con dar clases con vosotros?',
          answer: 'Sí puedes, ¡y hasta nos aporta un gran valor! En muchas ocasiones los mejores educadores son quienes desarrollan una actividad profesional determinada y la comparten posteriormente con sus alumnos.',
        },
        {
          question: '¿Cómo sé si mi disponibilidad es adecuada y coincide con vuestros horarios, o no?',
          answer: 'Impartimos clases en distintos momentos del día. Hay franjas de mayor actividad donde necesitamos a más educadores impartiendo concurrentemente. Lo que necesitamos es que dispongas de días semanales con huecos horarios constantes para que puedas impartir una clase, semana a semana, el día de la semana que toque, siempre a la misma hora.',
          html:"<p class='mt-2'><b>Nota:</b> Si solo puedes confirmarnos disponibilidad a 2 meses vista, también tenemos programas intensivos cortos en los que te podríamos asignar.</p>"
        },
        {
          question: '¿Qué contenidos se imparten exactamente?',
          answer: 'Según tu disciplina profesional te asociaremos a los programas académicos que estén creados relacionados con la misma. Te indicaremos cuál es la estructura de estos programas, y cómo trabajar con la trayectoria de los alumnos desde ellos.',
        },
        {
          question: '¿Puedo proponer la creación de nuevos contenidos o programas?',
          answer: '¡Desde luego! Recoger vuestras inquietudes y darle forma es parte de nuestra diversión constante dentro de nuestra Escuela de Educadores. Puedes participar como autor de actividades específicas, ¡y además puedes generarte ingresos extra con ello!',
        },
        {
          question: '¿Cómo puedo acceder a ser autor de contenidos o tutor de otros educadores?',
          answer: 'Inscríbete en nuestro programa de Lanzadera 360 para ser educador con nosotros y en un punto específico te lo preguntaremos y te informaremos más sobre ello.',
        },
        {
          question: '¿Puedo crear contenidos sin impartir clases?',
          answer: 'Mi-empresa da apoyo a los educadores de forma integral de todas las formas que vemos posible. Por tanto, nos gusta que sean nuestros educadores quienes participan en el resto de los procesos creativos o académicos cuando surgen oportunidades. ',
          html:"<p class='mt-2'>Dicho esto, si crees que puedes aportar un valor especial de cualquier forma, más allá de dar clases, ponte en contacto con nosotros desde la página de contacto para analizar tu propuesta y analizar las posibilidades.</p>"
        },
        {
          question: '¿Puedo crear mis propios programas e incluirlos en la oferta educativa de Mi-empresa?',
          answer: 'Inscríbete en nuestro programa de Lanzadera 360 para ser educador con nosotros y en un punto específico te lo preguntaremos y te informaremos más sobre ello.',
        },
        {
          question: '¿Puedo impartir clases durante solo algunas épocas específicas del año?',
          answer: '¡Desde luego! Disponemos de distintos periodos para impartir clases: El curso escolar, Navidad, Semana Santa y verano. Cada educador puede elegir en qué momentos desea impartir clases con nosotros, y cuándo darse un descanso (sin dejar programas académicos activos en el aire).',
          html:"<p class='mt-2'>Antes de comenzar cualquier programa académico te notificaremos todos los detalles sobre el mismo a partir de las elecciones que nos hayas indicado, y siempre esperaremos aparte una confirmación específica de tu parte.</p>"
        },
        {
          question: '¿Las clases son para particulares o también para colegios?',
          answer: 'Impartimos clases tanto para particulares como en colaboración con otros colectivos o entidades sociales y/o educativas.',
          html:"<p class='mt-2'>Te indicaremos en cada momento para quién serán las clases, y qué características específicas tener en cuenta para casos específicos. Te lo daremos todo preparado.</p>"
        },
        {
          question: '¿Qué sucede si hay algún alumno con dificultades de adaptación de cualquier tipo?',
          answer: 'Nuestro sistema educativo dispone de procesos académicos internos para poder adaptarnos a una gran variedad de perfiles de alumnos. Cuando surjan casos específicos te pondremos al día con toda la información que vayas a necesitar para que puedas impartir las clases adecuadamente.',
        },
        {
          question: '¿Qué sucede si un alumno no encajara en un grupo?',
          answer: 'Desde Mi-empresa nos comprometemos a que en los grupos participen alumnos serios, motivados y con ganas de aprender. Si algún alumno no encaja por cualquier aspecto, analizaremos el caso en particular para adaptarlo adecuadamente.',
        },
          ]
      }
  },

}
</script>

<style scoped>
.question{
  font-family: 'Poppins';
  font-size: 16px;
  font-weight: 500;
  color: #343a40;
}

.answer{
  font-family: 'Poppins';
  font-size: 16px;
  font-weight: normal;
  color: #343a40;
  padding-right: 10px !important;
}

i{
    font-size: 36px !important;
}

.btn-registrate {
  width: 176px;
  height: 40px;
  border-radius: 4px;
  box-shadow: 0 2px 5px 0 rgba(41, 192, 211, 0.3);
  border: solid 1px #29c0d3;
  background-color: #29c0d3;
  color: white;
  font-family: 'Poppins';
  font-size: 16px;
  font-weight: 600;
}

a:hover{
    color: white !important;
}


</style>

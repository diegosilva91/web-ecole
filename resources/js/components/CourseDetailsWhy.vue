<template>
  <div class="container">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-8">
            <h2 class="h2-txt text-left mt-lg-40 mb-8">{{title}}</h2>
            <v-expansion-panels focusable>
              <div class="container row" v-if= "isDetails === 'true'">
                <v-expansion-panel v-for="i in details" :key="i.question">
                  <v-expansion-panel-header v-show="!trajectory" class="p1-txt line-15">
                    {{i.question}}
                    <template v-slot:actions>
                      <v-icon color="#29c0d3">$expand</v-icon>
                    </template>
                  </v-expansion-panel-header>
                  <v-expansion-panel-header v-show="trajectory" class="p1-txt line-15">
                    {{i.tquestion}}
                    <template v-slot:actions>
                      <v-icon color="#29c0d3">$expand</v-icon>
                    </template>
                  </v-expansion-panel-header>
                  <v-expansion-panel-content class="p2-txt text-left mb-3 mr-5 mt-4">
                    <div v-html="i.answer"></div>
                  </v-expansion-panel-content>
                </v-expansion-panel>
              </div>
              <div class="container row" v-else>
                <v-expansion-panel v-for="i in faq" :key="i.question">
                  <v-expansion-panel-header class="p1-txt line-15">
                    {{i.question}}
                    <template v-slot:actions>
                      <v-icon color="#29c0d3">$expand</v-icon>
                    </template>
                  </v-expansion-panel-header>
                  <v-expansion-panel-content class="p2-txt text-left mb-3 mr-5 mt-4">
                    <div v-html="i.answer"></div>
                  </v-expansion-panel-content>
                </v-expansion-panel>
              </div>
            </v-expansion-panels>
      <div v-show="seoText" v-html="course.seo_information"></div>
      </div> 
    </div>
</div>
</template>

<script>
export default {
    props: ['isDetails', 'title','course','trajectory','seoText'],
    
    data() {
      return {
        details: [
        {
          tquestion: 'Tecnologías que utilizarás',
          question: '¿Qué voy a ver en el curso?',
          answer: 'Las clases se realizan a través de Google Meet. La cuenta de Meet de Mi-empresa se encarga de conectar a los alumnos a la reunión.',
        },
        {
          tquestion: '¿Qué beneficios tiene?',
          question: '¿Qué beneficios tiene?',
          answer: 'Mi-empresa se enfoca en clases en línea, interactivas, en vivo y en grupos reducidos, para poder brindar excelentes experiencias de aprendizaje. Encontrarás cursos de infinidades de temáticas, desde Fortnite hasta cursos de Matemáticas. Ofrecemos una diversidad incomparable en cuanto a profesores y materias. Y además promovemos un alto grado de interacción social entre estudiantes, profesores y padres.',
        },
        {
          tquestion: 'Temario',
          question: '¿Qué aprenderé en el curso?',
          answer: 'El registro es gratuito, solo pagarás cuando decidas comprar un curso. Cada curso tiene un precio diferente, el promedio que pagarás por un curso de más de 4 sesiones, está en torno a los 60€.',
        }
        ],
        faq: [
        {
          question: '¿Cómo funcionan las clases?',
          answer: 'Las clases se realizan a través de Google Meet. La cuenta de Meet de Mi-empresa se encarga de conectar a los alumnos a la reunión. No hay límite de tiempo y no es necesario que el profesor comparta el link. ¡Solo debes preocuparte por crear una excelente experiencia de clase! Google Meet también viene con muchas herramientas útiles de gestión del aula para que las clases funcionen sin problemas.',
        },
        {
          question: '¿Qué sucede si no puedo asistir a una clase?',
          answer: 'Estate tranquilo. Recibirás la grabación de la clase a la que no has podido asistir para ponerte al día. Además, puedes contactar con tu profesor para resolver cualquier duda que puedas tener.',
        },
        {
          question: '¿Qué sucede si tengo cualquier problema técnico o de acceso o conexión?',
          answer: "Si surgen dificultades excepcionales de cualquier tipo puedes contactar con nuetro área de Coordinación académica, a través de nuestra página de <a href='/es/contacto' style='font-weight: 500;color: #29c0d3 !important;text-decoration: underline !important;'>contacto</a>.",
        },
        {
          question: '¿Qué pasa si no se consolida un grupo en mi horario?',
          answer: "<p>Una vez recibimos vuestra suscripción, analizamos vuestras necesidades (horarios, edad, ritmo, nivel...) aproximadamente una semana antes del comienzo de tu curso. Tan pronto como consolidemos tu grupo recibirás una confirmación respecto al comienzo del mismo, y te enviaremos los últimos detalles entre 24-48 horas antes del inicio.</p><p>Habitualmente cuadramos exitosamente nuestros grupos con vuestra disponibilidad, pero si en el horario que eliges no conseguimos consolidar un grupo, podrás beneficiarte de una integración con el comienzo de nuestros programas de suscripción (donde abordamos el mismo contenido), con una mayor duración de las clases sin coste adicional. Además, en este caso, si decides que tu hijo decida seguir evolucionando, lo podrá hacer manteniendo a su profesor y compañeros en ese mismo grupo.</p><p>Si aún así no surgiera esta posibilidad, te daremos la alternativa de esperar entre 2 y 4 semanas para la consolidación del grupo, y tras este periodo de tu elección, arrancarlo de forma particular por el mismo precio de grupo hasta que podamos reagrupar a tu hijo con otros compañeros.</p><p>Si se realizan clases particulares, el programa del curso intensivo se realizará de forma intensiva en menos sesiones de las necesarias para un ritmo de grupo.</p><p>En definitiva, haremos todo lo necesario para que tu hijo pueda comenzar e integrarse a un grupo de su nivel tan rápido como sea posible.</p>",
        }
        ],
      }
    },

    mounted(){
      if(this.course){
          this.details[0].answer=this.course.description?this.course.description:''
          this.details[1].answer=this.course?this.course.objectives:''
          this.details[2].answer=this.course.will_learn?this.course.will_learn:''
          this.faq= this.faq.concat(this.course.faqs);
          
      }
    },
}
</script>

<style>
.subtitle-SEO{
    font-family: 'Poppins', sans-serif;
    font-size: 12px;
    font-weight: 500;
    color: #5b2867;
}

p>b, p>a, li>b, li>a{
    font-weight: 500 !important;
}

</style>

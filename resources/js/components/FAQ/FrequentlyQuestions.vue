<template>
    <div>
        <v-expansion-panels class="container">
            <h2 class="home-section-title mb-5 mr-auto">{{ title }}</h2>
            <div class="row" v-if="isTeacher === 'true'">
                <v-expansion-panel v-for="i in faqTeacher" :key="i.question">
                    <v-expansion-panel-header>
                        {{ i.question }}
                        <template v-slot:actions>
                            <v-icon color="#29c0d3">$expand</v-icon>
                        </template>
                    </v-expansion-panel-header>
                    <v-expansion-panel-content class="font-weight-light text-body-2">
                        {{ i.answer }}
                        <ul v-html="i.list"></ul>
                    </v-expansion-panel-content>
                </v-expansion-panel>
            </div>

            <div class="row" v-else>
                <v-expansion-panel v-for="i in faq" :key="i.question">
                    <v-expansion-panel-header>
                        {{ i.question }}
                        <template v-slot:actions>
                            <v-icon color="#29c0d3">$expand</v-icon>
                        </template>
                    </v-expansion-panel-header>
                    <v-expansion-panel-content class="font-weight-light text-body-2">
                        <p v-html="i.answer"></p>
                    </v-expansion-panel-content>
                </v-expansion-panel>
            </div>
        </v-expansion-panels>
    </div>
</template>

<script>
export default {
    props: ['isTeacher', 'title'],
    data() {
        return {
            faq: [
                {
                    question: '¿Cómo funcionan las clases?',
                    answer: 'Las clases se realizan a través de Google Meet. La cuenta de Meet de Lifecole se encarga de conectar a los alumnos a la reunión.',
                },
                {
                    question: '¿Cuales son los beneficios de Lifecole en comparación con otros programas de aprendizaje online?',
                    answer: 'Lifecole da clases en línea, interactivas, en vivo y en grupos reducidos, para poder brindar excelentes experiencias de aprendizaje. Encontrarás cursos enfocados al desarrollo de las habilidades y competencias que el niño va a necesitar en su futuro, programación, desarrollo de videojuegos, robótica o diseño digital son algunas de las temáticas más representativas. Y además promovemos un alto grado de interacción social entre estudiantes, profesores y padres.',
                },
                {
                    question: '¿Cuánto cuesta?',
                    answer: 'El registro es gratuito, solo pagarás cuando decidas comprar un curso. Cada curso tiene un precio diferente, el promedio que pagarás por un curso de 4 sesiones, está en torno a los 60€. Los cursos anuales tienen un precio mensual de 55€.',
                },
                {
                    question: '¿Qué tipo de tecnología y materiales se necesitan para las clases?',
                    answer: 'Para nuestras clases en vivo alentamos a nuestros alumnos a participar en su entorno de aprendizaje natural, utilizando el dispositivo de su elección. Lifecole funciona en los principales navegadores web y usamos Google Meet para las clases en vivo. Pueden prepararse para su primera clase descargando Google Meet con anticipación. Necesitará una cámara web y un micrófono y conexión a Internet. En caso de que el curso requiera material extra, el profesor lo indicará en requisitos de la ficha del curso.',
                },
                {
                    question: '¿Es obligatorio el uso de la videocámara en la asistencia a la clase?',
                    answer: 'No, es opcional. Debido a que la  Ley de Protección jurídica de menores (Ley Orgánica 1/1996, de 15 de enero, de protección jurídica del menor, de modificación del Código Civil y de la Ley de Enjuiciamiento Civil) establece que: Los menores tienen derecho al honor, a la intimidad personal y familiar y a la propia imagen. Este derecho comprende también la inviolabilidad del domicilio familiar y de la correspondencia, así como del secreto de las comunicaciones.',
                },
                {
                    question: '¿Cómo acceder a la clase online del curso que he comprado?',
                    answer: 'Desde organización académica se pondrán en contacto contigo unos días antes de iniciar el curso para explicaros todas las instrucciones de conexión al curso.',
                },
                {
                    question: '¿Qué sucede si no hay el mínimo de alumn@s requeridos inscritos en el curso?',
                    answer: 'En caso de que no haya el mínimo de alumnos, Lifecole se pondrá en contacto con los alumnos inscritos al curso para proponer una fecha alternativa.',
                },
                {
                    question: '¿Qué sucede si no puedo asistir a una sesión?',
                    answer: 'Los alumnos podrán incorporarse a la clase con un máximo de 10 minutos de retraso sobre la hora esperada, pasados los 10 minutos, el profesor decidirá si de forma excepcional el alumno se puede incorporar. Si el alumno no asiste a la clase sin previo aviso, la clase se considerará como dada y por tanto no recuperable',
                },
                {
                    question: '¿Puedo darme de baja de un curso ya empezado?',
                    answer: 'Si un alumno decide de forma unilateral no continuar con el curso, no se devolverá el importe correspondiente a las clases restantes. Si estás inscrito en una trayectoria anual, debes comunicar tu baja, 10 días antes de que se pase la siguiente cuota (entre el 28-31 de cada mes).',
                },
                {
                    question: '¿Qué pasa si la clase cae en un festivo?',
                    answer: 'En Lifecole, serán días no lectivos los festivos nacionales y fiestas puntuales como por ejemplo, semana santa. Podéis consultar el calendario <a target="_blank" href="https://myawslifecole.s3.eu-west-1.amazonaws.com/public/pdfs/Calendar-2021-2022(small).pdf">aquí:</a>',
                }
            ],

            faqTeacher: [
                {
                    question: '¿Qué ofrece Lifecole a los profesores?',
                    answer: 'Lifecole ofrece la posibilidad de vincularse a un proyecto en el que a través de la tecnología y la práctica, los profesores desarrollan habilidades y competencias en los niños que refuerzan su formación de una forma integral. Lifecole ofrece cursos cortos y cursos anuales con lo que busca también una larga vinculación con los profesores.',
                },
                {
                    question: '¿Cómo funcionan las clases?',
                    answer: 'Las clases se realizan a través de Google Meet. La cuenta de Meet de Lifecole se encarga de conectar a los alumnos a la reunión.¡Solo debes preocuparte por crear una excelente experiencia de clase! Google Meet también viene con muchas herramientas útiles de gestión del aula para que las clases funcionen sin problemas.',
                },
                {
                    question: '¿Cuánto dinero recibiré por mi curso? ',
                    answer: 'Los profesores de Lifecole reciben el importe integro de los cursos descontando un 30% (más IVA) que corresponde a la tarifa de servicio de Lifecole.',
                },
                {
                    question: '¿Cuándo recibiré el pago?',
                    answer: 'Una vez se haya realizado el curso, se facturará a Lifecole los servicios prestados y se tramitará el pago. El pago se hará efectivo en la última semana del mes en que se ha finalizado el curso.',
                },
                {
                    question: '¿Cual es el tiempo medio por sesión?',
                    answer: 'Las sesiones en Lifecole suelen durar entre 60 minutos y 75 minutos dependiendo si se trata de un curso intensivo o un curso anual.',
                },
                {
                    question: '¿Cual es el número óptimo de alumn@s por sesión?',
                    answer: 'Por tal de crear clases interactivas recomendamos no crear clases de más de 8 alum@s.',
                },
                {
                    question: '¿Puedo usar Lifecole para promover cursos que se venden en otros lugares?',
                    answer: 'No. Desde Lifecole controlamos el flujo de comunicación para evitar cualquier comunicación no indebida.',
                },
                {
                    question: '¿Qué sucede si no hay el mínimo de alumn@s requeridos inscritos en mi curso?',
                    answer: 'En este caso, Lifecole se ocupará de llamar a los alumnos para informar que la clase no se puede llevar a cabo y buscará una fecha alternativa en la que haya los alumnos suficientes. ',
                },
                {
                    question: '¿Qué pasa si un profesor no puede asistir a una sesión?',
                    answer: 'El profesor debe comunicarlo a Lifecole con un mínimo de 48 horas hábiles antes del inicio de la sesión y Lifecole buscará un día alternativo para hacer la sesión perdida.',
                },
                {
                    question: '¿Qué pasa si un profesor decide no continuar con un curso?',
                    answer: 'Si no hay un motivo razonable que explique este hecho, el profesor no percibirá ningún ingreso por este curso y Lifecole decidirá su continuidad como profesor de Lifecole.',
                }
            ]
        }
    },

}
</script>

<style>

</style>

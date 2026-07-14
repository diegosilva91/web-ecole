<template>
  <v-dialog
        max-width="562px"
        v-model="dialog"
        id="trajectoryModal"
    >
        <v-list class="pt-0 pb-0">
            <div class="d-flex">
                <v-btn class="ml-auto mt-3 mr-4" icon @click="dialog = false;" >
                    <v-icon>{{ mdiClose }}</v-icon>
                </v-btn>
            </div>
            <v-list-item>
                <h4 class="md-title mx-auto">{{title}}</h4>
            </v-list-item>
            <v-list-item>
                <p v-html="info" class="md-info text-center mb-10"></p>
            </v-list-item>
        </v-list>
    </v-dialog>
</template>

<script>
import { mdiClose } from '@mdi/js';
import Event from "../../event";

export default {
    data() {
      return {
        dialog: false,
        title:"",
        info:"",
        mdiClose
       }
    },
    mounted() {
      Event.$on("openModalTrajectory",()=>{
          this.dialog= true;
          this.title= "¿Qué son las trayectorias educativas?";
          this.info= "Nuestros programas estrella para que nuestros alumnos desarrollen su máximo potencial. Los cursos anuales se realizan a lo largo del ciclo escolar. Puedes incorporarte en cualquier momento del año, con previa evaluación del nivel, seguimiento y evaluación personalizada."
      });
      Event.$on("openModalCourse",()=>{
          this.dialog= true;
          this.title= "¿Qué son los cursos intensivos?";
          this.info= "Te presentamos cursos altamente especializados online y diseñados para que los alumnos tengan un acercamiento a una temática de su interés. Iniciamos cursos intensivos cada mes, con una duración de 5 sesiones y un feedback al finalizar el curso.<br>Durante Julio y Agosto no tenemos disponibles estos cursos. Te recordamos que durante Julio y Agosto puedes cursar nuestros campus de verano."
      });
      Event.$on("openModalCampus",()=>{
          this.dialog= true;
          this.title= "¿Qué son los campus?";
          this.info= "Con nuestros campus temáticos la diversión y el aprendizaje están asegurados. Diseñados para que los participantes conozcan desde dentro una temática específica y puedan decantarse por evolucionar educativamente con nuestros cursos anuales… ¡o solo para divertirse! "
      });
  },
}
</script>

<style scoped>
.md-title {
    font-size: 16px;
    font-weight: 500;
}

.md-info {
  opacity: 0.7;
  font-family: 'Poppins';
  font-size: 14px;
  color: #343a40;
}
</style>
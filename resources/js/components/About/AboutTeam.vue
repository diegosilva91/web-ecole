<template>
  <div class="container text-dark">
      <h3 class="text-center">El equipo Lifecoolers</h3>
      <div class="row mt-mob-20 mt-tb-20 mt-dk-40">
        <div :class="{'d-none':card}" class="col-9 col-md-4 col-lg-3 m-4 mx-auto">
          <img @click="showInfo('1')" src="/assets/images/about/belen.png" alt="">
          <div class="ml-9">
            <h5>Belén Cabido</h5>
            <h6 class="mt-2">Co-Fundadora & CEO</h6>
            <button class="btn-more mt-2" @click="showInfo('1')">
              <v-icon small>{{ mdiArrowRight }}</v-icon>
              VER MÁS
            </button>
          </div>
        </div>
        <div v-if="card" class="box-info info-2 col-9 col-md-4 col-lg-3 m-4 mx-auto">
          <v-list-item class="pl-0 pr-0">
            <h5>Belén Cabido</h5>
            <v-btn class="close-position" icon @click="card = false">
                <v-icon>{{ mdiClose }}</v-icon>
            </v-btn>
          </v-list-item>
          <p>Co-Fundadora de GoTrendier, el marketplace de ropa de segunda mano más grande de Latinioamerica. Con más de siete años de experiencia en desarrollo de negocios de retail, e-commerce y Marketplace. Graduada en Publicidad y Relaciones Públicas, Marketing y Administración de Empresas.</p>
        </div>
        <div :class="{'d-none':card2}" class="col-9 col-md-4 col-lg-3 m-4 mx-auto">
          <img @click="showInfo('2')" src="/assets/images/about/antonio.webp" alt="">
          <div class="ml-9">
            <h5>Antonio Buenosvinos</h5>
            <h6 class="mt-2">CTO</h6>
            <button class="btn-more mt-2" @click="showInfo('2')">
              <v-icon small>{{ mdiArrowRight }}</v-icon>
              VER MÁS
            </button>
          </div>
        </div>
        <div v-if="card2" class="box-info col-9 col-md-4 col-lg-3 m-4 mx-auto">
          <v-list-item class="pl-0 pr-0">
            <h5>Antonio Buenosvinos</h5>
            <v-btn class="close-position" icon @click="card2 = false">
                <v-icon>{{ mdiClose }}</v-icon>
            </v-btn>
          </v-list-item>
          <p>Ingeniero técnico de sistemas. Lleva 20 años vinculado al desarrollo de software y la gestión de equipos donde ha podido participar en gran diversidad de proyectos y empresas. Disfruta los emocionantes retos de su profesión con curiosidad y pasión.</p>
        </div>
        <div :class="{'d-none':card3}" class="col-9 col-md-4 col-lg-3 m-4 mx-auto">
          <img @click="showInfo('3')" src="/assets/images/about/oscar.webp" alt="">
          <div class="ml-9">
            <h5>Óscar Hernández</h5>
            <h6 class="mt-2">Co-founder & Academic</h6>
            <button class="btn-more mt-2" @click="showInfo('3')">
              <v-icon small>{{ mdiArrowRight }}</v-icon>
              VER MÁS
            </button>
          </div>
        </div>
        <div v-if="card3" class="box-info info-3 col-9 col-md-4 col-lg-3 m-4 mx-auto">
          <v-list-item class="pl-0 pr-0">
            <h5>Óscar Hernández</h5>
            <v-btn class="close-position" icon @click="card3 = false">
                <v-icon>{{ mdiClose }}</v-icon>
            </v-btn>
          </v-list-item>
          <p>Ingeniero y graduado informático con más de 15 años de experiencia como emprendedor y fundador de startups nacionales y europeas para eventos, videojuegos y educación, especializado en innovación educativa y el desarrollo de ecosistemas que favorezcan una mejora social.</p>
        </div>
      </div>
      <div class="row">
        <div :class="{'d-none':card4}" class="col-9 col-md-4 col-lg-3 m-4 mx-auto">
          <img @click="showInfo('4')" src="/assets/images/about/pablo.png" alt="">
          <div class="ml-9">
          <h5>Pablo Hermoso</h5>
          <h6 class="mt-2">Head Designer & PO</h6>
          <button class="btn-more mt-2" @click="showInfo('4')">
            <v-icon small>{{ mdiArrowRight }}</v-icon>
            VER MÁS
          </button>
          </div>
        </div>
        <div v-if="card4" class="box-info col-9 col-md-4 col-lg-3 m-4 mx-auto">
          <v-list-item class="pl-0 pr-0">
            <h5>Pablo Hermoso</h5>
            <v-btn class="close-position" icon @click="card4 = false">
                <v-icon>{{ mdiClose }}</v-icon>
            </v-btn>
          </v-list-item>
          <p>Pablo es el encargado del Diseño UX/UI y toda la parte visual de la web. Graduado en la doble licenciatura de Diseño y Publicidad, especializado en Diseño de Interacción. Ha trabajado para diferentes clientes como Airbus y McDonald's entre otros.</p>
        </div>
        <div :class="{'d-none':card5}" class="col-9 col-md-4 col-lg-3 m-4 mx-auto">
          <img @click="showInfo('5')" src="/assets/images/about/fran.png" alt="">
          <div class="ml-9">
          <h5>Francisco José Godoy</h5>
          <h6 class="mt-2">Frontend Developer</h6>
          <button class="btn-more mt-2" @click="showInfo('5')">
            <v-icon small>{{ mdiArrowRight }}</v-icon>
            VER MÁS
          </button>
          </div>
        </div>
        <div v-if="card5" class="box-info info-3 col-9 col-md-4 col-lg-3 m-4 mx-auto">
          <v-list-item class="pl-0 pr-0">
            <h5>Francisco José Godoy</h5>
            <v-btn class="close-position" icon @click="card5 = false">
                <v-icon>{{ mdiClose }}</v-icon>
            </v-btn>
          </v-list-item>
          <p>Responsable del Frontend. HTML, CSS y JavaScript son la base de su trabajo y no hay novedades y técnicas sobre estos lenguajes que se le escapen. Con más de 13 años de experiencia ha trabajado en importantes proyectos para los más variados sectores empresariales.</p>
        </div>
        <div :class="{'d-none':card6}" class="col-9 col-md-4 col-lg-3 m-4 mx-auto">
          <img @click="showInfo('6')" src="/assets/images/about/diego.png" alt="">
          <div class="ml-9">
          <h5>Diego Silva</h5>
          <h6 class="mt-2">Backend Developer</h6>
          <button class="btn-more mt-2" @click="showInfo('6')">
            <v-icon small>{{ mdiArrowRight }}</v-icon>
            VER MÁS
          </button>
          </div>
        </div>
        <div v-if="card6" class="box-info info-2 col-9 col-md-4 col-lg-3 m-4 mx-auto">
          <v-list-item class="pl-0 pr-0">
            <h5>Diego Silva</h5>
            <v-btn class="close-position" icon @click="card6 = false">
                <v-icon>{{ mdiClose }}</v-icon>
            </v-btn>
          </v-list-item>
          <p>Diego es responsable del Backend. Licenciado en Programación Informática y Química. Apasionado de la informática, ha participado en grandes proyectos en Colombia y España para empresas como Eurocontrol y la ANHidrocarburos.</p>
        </div>
      </div>
      <div class="row">
        <div :class="{'d-none':card7}" class="col-9 col-md-4 col-lg-3 m-4 mx-auto">
          <img @click="showInfo('7')" src="/assets/images/about/paula.png" alt="">
          <div class="ml-9">
          <h5>Paula Minguillón</h5>
          <h6 class="mt-2">Social Media Manager</h6>
          <button class="btn-more mt-2" @click="showInfo('7')">
            <v-icon small>{{ mdiArrowRight }}</v-icon>
            VER MÁS
          </button>
          </div>
        </div>
        <div v-if="card7" class="box-info info-3 col-9 col-md-4 col-lg-3 m-4 mx-auto">
          <v-list-item class="pl-0 pr-0">
            <h5>Paula Minguillón</h5>
            <v-btn class="close-position" icon @click="card7 = false">
                <v-icon>{{ mdiClose }}</v-icon>
            </v-btn>
          </v-list-item>
          <p>Paula trabaja en el área de Marketing. Encargada de introducir la estrategia de la empresa en las redes sociales. Hace un año descubrió trabajando en GoTrendier su pasión por el Marketing Digital y los negocios online. Estudiante de Administración y Dirección de empresas.</p>
        </div>
        <div :class="{'d-none':card8}" class="col-9 col-md-4 col-lg-3 m-4 mx-auto">
          <img @click="showInfo('8')" src="/assets/images/about/eva.webp" alt="">
          <div class="ml-9">
          <h5>Eva</h5>
          <h6 class="mt-2">Responsable cor. académica</h6>
          <button class="btn-more mt-2" @click="showInfo('8')">
            <v-icon small>{{ mdiArrowRight }}</v-icon>
            VER MÁS
          </button>
          </div>
        </div>
        <div v-if="card8" class="box-info col-9 col-md-4 col-lg-3 m-4 mx-auto">
          <v-list-item class="pl-0 pr-0">
            <h5>Eva</h5>
            <v-btn class="close-position" icon @click="card8 = false">
                <v-icon>{{ mdiClose }}</v-icon>
            </v-btn>
          </v-list-item>
          <p>Eva es la encargada del área de atención al cliente.
Con un Grado formativo en administración y finanzas, ha trabajado más de 15 años en departamentos de administración y customer service en el sector de la climatización. También en empresas del sector médico y dental como Back Office.</p>
        </div>
        <div :class="{'d-none':card9}" class="col-9 col-md-4 col-lg-3 m-4 mx-auto">
          <img @click="showInfo('9')" src="/assets/images/about/katty.webp" alt="">
          <div class="ml-9">
          <h5>Katty Flores G</h5>
          <h6 class="mt-2">Asesora educativa</h6>
          <button class="btn-more mt-2" @click="showInfo('9')">
            <v-icon small>{{ mdiArrowRight }}</v-icon>
            VER MÁS
          </button>
          </div>
        </div>
        <div v-if="card9" class="box-info info-3 col-9 col-md-4 col-lg-3 m-4 mx-auto">
          <v-list-item class="pl-0 pr-0">
            <h5>Katty Flores G</h5>
            <v-btn class="close-position" icon @click="card9 = false">
                <v-icon>{{ mdiClose }}</v-icon>
            </v-btn>
          </v-list-item>
          <p>Máster en Dirección Internacional y Gestión de la Innovación Tecnológica (MBA) y Técnica en Computación e Informática. Más de 14 años de experiencia en diversos sectores empresariales y áreas funcionales; con especial interés por la educación y la gestión comercial.</p>
        </div>
      </div>
      <div class="row">
        <div :class="{'d-none':card10}" class="col-9 col-md-4 col-lg-3 m-4 mx-auto">
          <img @click="showInfo('10')" src="/assets/images/about/marta.png" alt="">
          <div class="ml-9">
          <h5>Marta Petit</h5>
          <h6 class="mt-2">Coordinación académica</h6>
          <button class="btn-more mt-2" @click="showInfo('10')">
            <v-icon small>{{ mdiArrowRight }}</v-icon>
            VER MÁS
          </button>
          </div>
        </div>
        <div v-if="card10" class="box-info info-3 col-9 col-md-4 col-lg-3 m-4 mx-auto">
          <v-list-item class="pl-0 pr-0">
            <h5>Marta Petit</h5>
            <v-btn class="close-position" icon @click="card10 = false">
                <v-icon>{{ mdiClose }}</v-icon>
            </v-btn>
          </v-list-item>
          <p>Coordinadora académica de Mi-empresa. Graduada en Magisterio de Educación Infantil. Experiencia con más de 10 años en colegios, como profesora en educación infantil , además, de organizadora y coordinadora de campamentos y fiestas infantiles. Apasionada por el mundo educativo.</p>
        </div>
        <div class="col-9 col-md-4 col-lg-3 m-4 mx-auto d-none d-sm-block"></div>
        <div class="col-9 col-md-4 col-lg-3 m-4 mx-auto d-none d-sm-block"></div>
      </div>
  </div>
</template>

<script>
import { mdiArrowRight, mdiClose } from '@mdi/js';

export default {
  data() {
    return {
      card:false,
      card2:false,
      card3:false,
      card4:false,
      card5:false,
      card6:false,
      card7:false,
      card8:false,
      card9:false,
      card10:false,
      mdiArrowRight,
      mdiClose
    }
  },

  methods: {
    showInfo(card) {
      switch(card) {
        case '1':
          this.card = true;
          this.card2 = false;
          this.card3 = false;
          this.card4 = false;
          this.card5 = false;
          this.card6 = false;
          this.card7 = false;
          this.card8 = false;
          this.card9 = false;
          this.card10 = false;
          break;
        case '2':
          this.card = false;
          this.card2 = true;
          this.card3 = false;
          this.card4 = false;
          this.card5 = false;
          this.card6 = false;
          this.card7 = false;
          this.card8 = false;
          this.card9 = false;
          this.card10 = false;
          break;
        case '3':
          this.card = false;
          this.card2 = false;
          this.card3 = true;
          this.card4 = false;
          this.card5 = false;
          this.card6 = false;
          this.card7 = false;
          this.card8 = false;
          this.card9 = false;
          this.card10 = false;
          break;
        case '4':
          this.card = false;
          this.card2 = false;
          this.card3 = false;
          this.card4 = true;
          this.card5 = false;
          this.card6 = false;
          this.card7 = false;
          this.card8 = false;
          this.card9 = false;
          this.card10 = false;
          break;
        case '5':
          this.card = false;
          this.card2 = false;
          this.card3 = false;
          this.card4 = false;
          this.card5 = true;
          this.card6 = false;
          this.card7 = false;
          this.card8 = false;
          this.card9 = false;
          this.card10 = false;
          break;
        case '6':
          this.card = false;
          this.card2 = false;
          this.card3 = false;
          this.card4 = false;
          this.card5 = false;
          this.card6 = true;
          this.card7 = false;
          this.card8 = false;
          this.card9 = false;
          this.card10 = false;
          break;
        case '7':
          this.card = false;
          this.card2 = false;
          this.card3 = false;
          this.card4 = false;
          this.card5 = false;
          this.card6 = false;
          this.card7 = true;
          this.card8 = false;
          this.card9 = false;
          this.card10 = false;
          break;
        case '8':
          this.card = false;
          this.card2 = false;
          this.card3 = false;
          this.card4 = false;
          this.card5 = false;
          this.card6 = false;
          this.card7 = false;
          this.card8 = true;
          this.card9 = false;
          this.card10 = false;
          break;
        case '9':
          this.card = false;
          this.card2 = false;
          this.card3 = false;
          this.card4 = false;
          this.card5 = false;
          this.card6 = false;
          this.card7 = false;
          this.card8 = false;
          this.card9 = true;
          this.card10 = false;
          break;
        case '10':
          this.card = false;
          this.card2 = false;
          this.card3 = false;
          this.card4 = false;
          this.card5 = false;
          this.card6 = false;
          this.card7 = false;
          this.card8 = false;
          this.card9 = false;
          this.card10 = true;
      }
    }
  }
}
</script>

<style scoped>
h5 {
  font-weight: 600;
}

h6 {
  font-size: 16px;
  font-weight: 400;
}

p {
  opacity: 0.75;
  font-family: 'Poppins';
  font-size: 15px;
  color: #343a40;
}

.box-info {
  width: 100%;
  height: 356px;
  padding: 0px 30px 25px 30px;
  object-fit: contain;
  border-radius: 7px;
  box-shadow: 0 4px 18px 0 rgba(253, 177, 0, 0.3);
  border: solid 2px #fdb100;
  background-color: #ffffff;
}

.box-info.info-2 {
  box-shadow: 0 4px 18px 0 rgba(40, 191, 210, 0.31);
  border: solid 2px #28bfd2;
}

.box-info.info-3 {
  box-shadow: 0 4px 18px 0 rgba(128, 58, 145, 0.3);
  border: solid 2px #803a91;
}

.btn-more {
  opacity: 0.75;
  font-family: 'Poppins';
  font-size: 11px;
  font-weight: 500;
}

.close-position {
  position: absolute;
  right: -20px;
}

button::before {
   background-color: transparent !important;
}

img {
  height: 257px;
  max-width: none !important;
  cursor: pointer;
}

@media  (max-width: 767.98px) {
  img {
    width:100%;
    max-width: 250px !important;
  }
}

@media (min-width: 750px) and (max-width: 1000px) {
  p {
    font-size: 13px;
  }
}

</style>

<template>
<div>
  <h2 class="title-section">¿Qué ofrecemos?</h2>
  <div :class="viewType?'bg-banner-bf':'bg-banner-courses'" class="pt-35 pb-35">
      <div class="container">
          <div class="row">
              <div class=" col-10 col-md-6 mx-auto"> 
                <div :class="[{'bf-card':viewType==='blackfriday'},{'cm-card':viewType==='cybermonday'}]" class="box-card text-center mx-auto">
                    <!-- Tag BlackFriday -->
                    <div v-show="viewType==='blackfriday'">
                        <img class="posit-tag-bf" src="/assets/images/promos/bf_tag_white.png" alt="">
                    </div>
                    <!-- Tag CyberMonday -->
                    <div v-show="viewType==='cybermonday'">
                        <img class="posit-tag-bf" src="/assets/images/promos/cm_tag_white.png" alt="">
                    </div>
                    <!-- end -->

                    <img v-show="!viewType" class="mb-25" src="/assets/images/home/kid_trajectory.svg" alt="">
                    <img v-show="viewType" class="mb-25" src="/assets/images/home/kid_course_bf.svg" alt="">
                    <div class="h6-txt">
                        <h2 :class="[{'bf-title':viewType==='blackfriday'},{'cm-title':viewType==='cybermonday'}]" class="mb-3">{{viewType==='cybermonday'?'Cursos de Navidad':'Trayectorias Educativas'}}</h2>
                        <p v-show="!viewType">Con formato de actividad extraescolar,<br class="d-none d-lg-block"> ofrecen un camino de <span>diversión</span> y <span>aprendizaje</span><br class="d-none d-lg-block"> que, a través de 8 niveles, les guía desde sus <span>pasiones</span> hasta el mundo <span>profesional</span>.</p>
                        
                        <!-- BlackFriday -->
                        <p class="subtitle-bf text-light ml-5 mr-5" v-show="viewType==='blackfriday'">¡Todos nuestros cursos <br class="d-block d-lg-none"> intensivos con un <span>20%</span> de DTO.!</p>
                        <p class="text-light ml-4 mr-4" v-show="viewType==='blackfriday'">Desarrollarán nuevas habilidades en cursos de 5 sesiones con aprendizaje personalizado y en grupos reducidos.</p>
                        <!-- end -->

                        <!-- CyberMonday -->
                        <p class="subtitle-cm text-light ml-5 mr-5" v-show="viewType==='cybermonday'">¡Todos nuestros cursos del campus de Navidad al <span>20%</span> de DTO. !</p>
                        <p class="text-light ml-4 mr-4" v-show="viewType==='cybermonday'">Regalale educación estas navidades. Aprenderán y se divertirán en cursos semanales de 5 sesiones.</p>
                        <!-- end -->
                    </div>
                    <button v-show="landingMkt" @click="openForm()" :class="{'btn-bf':viewType==='blackfriday'}"  class="btn-course-info mt-2">descubrir</button>
                    <a v-show="!landingMkt" href="/es/cursos-anuales"><button :class="{'btn-bf':viewType==='blackfriday'}" class="btn-course-info mt-2">descubrir</button></a> 
                    <div v-show="viewType==='blackfriday'" class="info-promo-bf mt-4">Promoción válida del 22 al 28 de Noviembre</div>
                    <div v-show="viewType==='cybermonday'" class="info-promo-cm mt-4">¡Promoción válida solo hoy!</div>
                </div>    
              </div>
              <div class="col-10 col-md-6 mx-auto">
                <div :class="[{'bf-card':viewType==='blackfriday'},{'cm-card':viewType==='cybermonday'}]" class="box-card text-center mx-auto mt-mob-30">
                    <!-- Tag BlackFriday -->
                    <div v-show="viewType==='blackfriday'">
                        <img class="posit-tag-bf" src="/assets/images/promos/bf_tag_white.png" alt="">
                    </div>

                    <!-- Tag CyberMonday -->
                    <div v-show="viewType==='cybermonday'">
                        <img class="posit-tag-bf" src="/assets/images/promos/cm_tag_white.png" alt="">
                    </div>
                    <!-- end -->

                    <img v-show="!viewType" class="mb-25" src="/assets/images/home/kid_course.svg" alt="">
                    <img v-show="viewType" class="mb-25" src="/assets/images/home/kid_trajectory_bf.svg" alt="">
                    <div class="h6-txt">
                        <h2 :class="[{'bf-title':viewType==='blackfriday'},{'cm-title':viewType==='cybermonday'}]" class="mb-3">{{viewType==='cybermonday'?'Cursos Anuales':'Cursos originales'}}</h2>
                        <p v-show="!viewType">En tan solo 5 sesiones permiten <br class="d-none d-lg-block"> descubrir a tu hij@ una <span>temática </span><br class="d-none d-lg-block"> <span>concreta</span> para ver si le gusta realmente <br class="d-none d-lg-block"> y querer seguir aprendiendo.</p>
                        
                        <!-- BlackFriday -->
                        <!-- <p :class="{'subtitle-cm':viewType==='cybermonday'}" class="subtitle-bf text-light ml-3 mr-3" >¡Inscríbete con Matrícula <span>GRATIS</span> y obtendrás un <span>20%</span> dto en tu <br class="d-block d-lg-none"> primera cuota!</p> -->
                        <!-- <p class="text-light ml-4 mr-4">Pueden inscribirse en cualquier momento del año, se realizará previa evaluación de nivel. ¡Una oportunidad única!</p> -->
                    </div>
                    <button v-show="landingMkt" @click="openForm()" :class="{'btn-bf':viewType==='blackfriday'}"  class="btn-course-info mt-2">descubrir</button>
                    <a v-show="!landingMkt" href="/es/cursos"><button :class="{'btn-bf':viewType==='blackfriday'}"  class="btn-course-info mt-2">descubrir</button></a> 
                    <div v-show="viewType==='blackfriday'" class="info-promo-bf mt-4">Promoción válida del 22 al 28 de Noviembre</div>
                    <div v-show="viewType==='cybermonday'" class="info-promo-cm mt-4">¡Promoción válida solo hoy!</div>
                </div>   
              </div>
          </div>
      </div>
  </div>
</div>
</template>

<script>
import Event from '../../event.js';

export default {
    props:['viewType', 'landingMkt'],
    methods: {
      openForm(){
          Event.$emit('show-modal-card');
        }
    }
}
</script>

<style scoped>

.title-section{
  font-family: 'Poppins';
  font-size: 28px;
  font-weight: 500;
  text-align: center;
}

.box-card{
  max-width: 531px;
  height: auto;
  padding: 30px 70px;
  border-radius: 20px;
  box-shadow: 2px 4px 9px 0 rgba(176, 212, 217, 0.44);
  background-color: #f2feff;   
}

.box-card.bf-card{
  box-shadow: 2px 4px 9px 0 rgba(255, 179, 0, 0.1);
  background-color: #343a40;   
}

.box-card.cm-card{
  box-shadow: 2px 4px 9px 0 rgba(41, 192, 211, 0.1);
  background-color: #343a40;  
}

.bf-title{
    color: #ffb300;
}

.cm-title{
    color: #29c0d3;
}

.h6-txt>h2{
    font-size: 22px;
    font-weight: 600;
}

.h6-txt>p{
  font-weight: 300;
}

.h6-txt>p>span{
    font-weight: 500;
}

.h6-txt>p.subtitle-bf{
    font-size: 16px;
    font-weight: 600;
}

.h6-txt>p.subtitle-cm{
    font-size: 16px;
    font-weight: 600;
}

.h6-txt>p.subtitle-bf>span{
    font-weight: 700;
    color: #ffb300;
}

.h6-txt>p.subtitle-cm>span{
    font-weight: 700;
    color: #00c3d6;
}

.btn-course-info {
  width: 135px;
  height: 31px;
  border-radius: 8px;
  box-shadow: 0 2px 8px 0 rgba(35, 158, 173, 0.5);
  background-color: #29c0d3;
  text-transform: uppercase;
  color: white;
  font-family: 'Poppins';
  font-size: 14px;
  font-weight: 600;
}

.btn-course-info.btn-bf{
  box-shadow: 0 2px 8px 0 rgba(255, 179, 0, 0.18);
  background-color: #ffb300;
  color: #343a40;
}

.bg-banner-courses{
    background-color: #fff;
    width: 100%;
    background-image: url('/assets/images/landing_mkt/bg_plants_light.svg');
    background-repeat: no-repeat;
    background-position: center;
}

.bg-banner-bf{
    background-color: #1a1d1f;
    width: 100%;
    background-image: url('/assets/images/backgrounds/bg_plants_black.svg');
    background-repeat: no-repeat;
    background-position: center;
}

.info-promo-bf{
  font-family: 'Poppins';
  font-size: 12px;
  color: #ffb300;
}

.info-promo-cm{
  font-family: 'Poppins';
  font-size: 12px;
  color: #3ed6e9;
}

.posit-tag-bf{
  position: absolute;
  top: 12px;
  left: 30px;
}

@media  (max-width: 1260px) {
  .box-card{
    max-width: none;
  }

  .posit-tag-bf{
    left: 13px;
  }
}

@media  (max-width: 668px) {
    .bg-banner-courses{
      background-image: url('/assets/images/landing_mkt/bg_plants_light_mob.svg');
      background-size: cover;
    }

    .bg-banner-bf{
      background-image: url('/assets/images/backgrounds/bg_plants_black_mob.svg');
      background-size: cover;
    }

    .box-card{
      padding: 30px 20px; 
    }
}

@media  (min-width: 669px) and (max-width: 970px) {
    .bg-banner-courses{
    background-image: none;
    }
}

</style>
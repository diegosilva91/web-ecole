<template>
<div class="bg-landing-banner"> 
  <div class="pt-10 pb-10">
    <h2><span>¡Arrancamos nuevos cursos y trayectorias cada mes!</span><br>
    ¿Te guiamos para que tu hijo evolucione con nosotros?
    </h2>
    <div class="d-flex">
        <button @click="openForm()" class="btn-course-info mx-auto mt-4">me interesa</button>
    </div>
  </div>
</div> 
</template>

<script>
import Event from '../../event.js';
export default {
  methods: {
      openForm(){
        Event.$emit('show-modal-card');
      }
  }
}
</script>

<style scoped>
h2{
  font-size: 14px;
  font-weight: 300;
  text-align: center;
  color: #2f2f2f;
  letter-spacing: 0.09px;
}

h2>span{
  font-weight: 500;
}

.bg-landing-banner{
    width: 100%;
    height: auto;
    background-image: url('/assets/images/landing_mkt/bg_landing_banner.svg');
    background-size: cover;
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

@media  (max-width: 668px) {
    .bg-landing-banner {
      background-image: none;
      background-color: #dbf4f7;
    } 
    
    h2{
      padding: 0 65px;
      line-height: 1.5;
    }
}

@media  (max-width: 1440px) {
    .bg-landing-banner {
      background-repeat: no-repeat;
      background-position: center;
    }    
}
</style>
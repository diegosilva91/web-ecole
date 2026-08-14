<template>
<div class="container">
  <h2 class="section-title mb-40">¿Cómo continuamos?</h2>
  <div class="row flex-column-reverse flex-md-row">
      <div class="col-12 col-md-6 text-center text-md-left">
          <img src="/assets/images/landing_mkt/contact_landing.svg" alt="">
      </div>
      <div class="col-12 col-md-6 my-auto">
          <h3 class="mb-30 mb-mob-15 ml-mob-20 mr-mob-20"><span>Solicítanos información</span> o asiste a una <span>sesión informativa</span> con tu <br class="d-none d-md-block"> hij@ para conocer tus posibilidades y preguntarnos en directo.</h3>
          <div class="d-none d-md-block">
            <div class="d-flex">
                <div class="d-flex">
                    <img src="/assets/images/landing_mkt/phone.svg" alt=""><h6 class="h7-txt-light my-auto ml-2 mr-10">+34 622 452 383</h6>
                </div>
                <div class="d-flex">
                    <img src="/assets/images/landing_mkt/email.svg" alt=""><h6 class="h7-txt-light my-auto ml-2">ventas@mi-empresa.com</h6>
                </div>
            </div>
            <p class="h7-txt-light mt-30">Pídenos más información</p>
            <button @click="openForm()" class="btn-course-info">me interesa</button>
          </div>
      </div>
  </div>
  <div class="d-block d-md-none">
        <div class="d-flex justify-content-center mt-35">
            <div class="d-flex">
                <img src="/assets/images/landing_mkt/phone.svg" alt=""><h6 class="h7-txt-light my-auto ml-2 mr-10">+34 622 452 383</h6>
            </div>
            <div class="d-flex">
                <img src="/assets/images/landing_mkt/email.svg" alt=""><h6 class="h7-txt-light my-auto ml-2">ventas@mi-empresa.com</h6>
            </div>
        </div>
        <p class="h7-txt-light mt-35 text-center">Pídenos más información</p>
        <div class="d-flex">
            <button @click="openForm()" class="btn-course-info mx-auto">me interesa</button>
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
.section-title{
  font-size: 28px;
  font-weight: 500;
  text-align: center;
}

h3 {
  font-size: 16px;
  font-weight: 300;
}

h3>span {
    font-weight: 500;
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
</style>
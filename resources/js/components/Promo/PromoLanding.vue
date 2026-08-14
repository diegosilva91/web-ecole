<template>
<div class="container mb-100">  
  <div class="text-center">
        <h1 v-show="view_type==='blackfriday'" class="pop25 mt-40"><span class="pop30">Black Week</span>, tu oportunidad <br class="d-none d-lg-block"> 
            para regalar educación </h1>
        <h1 v-show="view_type==='cybermonday'" class="pop25 mt-40">Aprovecha el <span class="pop30">Cyber Monday</span> para regalarles<br class="d-none d-lg-block"> conocimiento estas Navidades.</h1>
        <h2 v-show="view_type==='blackfriday'" class="pop21 mt-4">Aprovecha ahora. Todo lo bueno se acaba.</h2>
        <h6 v-show="view_type==='blackfriday'" class="pop14 mt-3">Promociones válidas desde el <span>22</span> al <span>28</span> de Noviembre</h6>
        <h6 v-show="view_type==='cybermonday'" class="pop14 mt-3">Promociones válidas sólo durante el día de hoy</h6>
  </div> 
  <div class="card-promo mt-5">
    <div class="row">
      <div :class="{'cm-tag':view_type!='blackfriday'}" class="tag-courses ml-3 mt-2">{{view_type==='blackfriday'?'Cursos intensivos':'Cursos de navidad'}}</div>
    </div>
    <div class="row">
      <div class="col-12 col-lg-6 text-light mt-4 text-center text-md-left">
        <h2 class="fs-23 text-light"><span :class="{'font-cm':view_type!='blackfriday'}" class="font-bf">20% <span class="dto-size">dto</span></span> <br class="mb-3"> en todos los {{view_type==='blackfriday'?'cursos intensivos':'cursos del Campus de Navidad'}}</h2>
        <p v-show="view_type==='blackfriday'" class="mt-2 pop16">¡Regala conocimiento y diversión! Invierte en su futuro.</p>
      </div>
      <div class="row col-6 col-lg-4 ml-lg-0 mr-lg-0 ml-auto mr-auto justify-content-center">
        <img :src="view_type==='blackfriday'?'/assets/images/promos/robot_promo.svg':'/assets/images/promos/campus_navidad.svg'" alt="">
      </div>
      <p v-show="view_type==='cybermonday'" class="col-12 text-light pop16">Con la compra de un curso intensivo, te enviaremos un cupón descuento válido para comprar otro <span>GRATIS</span>.</p>
    </div>
      <div class="row flex-column-reverse flex-lg-row">
        <p class="col-12 col-lg-10 pop12 mb-0 text-center text-md-left">* El descuento aparece aplicado directamente en el precio final de  la compra. No aplica en cursos anuales o cursos de campus de navidad.</p>
        <div class="row col-12 col-lg-2 justify-content-center mx-auto">
            <a href="/es/campus-de-navidad"><button :class="{'cm-btn':view_type!='blackfriday'}" class="btn-promo mt-3 mb-3 mr-md-3 mt-lg-0 mb-lg-0">descubre más</button></a>
        </div>
      </div>
  </div>
  <div class="card-promo mt-5">
    <div class="row">
      <div :class="{'cm-tag2':view_type!='blackfriday'}" class="tag-courses tag-width ml-3 mt-2">Cursos anuales</div>
    </div>
    <div class="row">
      <div class="col-12 col-lg-6 text-light mt-4 text-center text-md-left">
        <div class="row">
          <div class="col-12 col-md-5">
            <h2 class="fs-23 text-light">Matrícula <br class="d-block d-md-none"><span :class="{'font-cm':view_type!='blackfriday'}" class="font-bf">Gratis</span></h2>
          </div>
          <div class="mx-auto my-auto col-md-1 pop39">+</div>
          <div class="col-12 col-md-6 pl-lg-4">
            <h2 class="fs-23 text-light">en la primera cuota<span :class="{'font-cm':view_type!='blackfriday'}" class="font-bf">20% <span class="dto-size">dto</span></span></h2>
          </div>
        </div>
        <p class="mt-2 pop16">¡Nunca es tarde para apuntarse a los cursos anuales!</p>
      </div>
      <div class="row col-6 col-lg-4 ml-lg-0 mr-lg-0 ml-auto mr-auto justify-content-center">
        <img src="/assets/images/promos/kids.svg" alt="">
      </div>
    </div>
      <div class="row flex-column-reverse flex-lg-row">
        <p class="col-12 col-lg-10 pop12 mb-0 text-center text-md-left">*Una vez hayas realizado la compra, ponte en contacto en educacion@mi-empresa.com para recibir tu cupón. Tendrá un solo uso, válido para cursos intensivos y de navidad. Sujeto a las 100 primeras personas. Canjeable durante el mes de Noviembre.</p>
        <div class="row col-12 col-lg-2 justify-content-center mx-auto">
            <a href="/es/cursos-anuales"><button :class="{'cm-btn':view_type!='blackfriday'}" class="btn-promo mt-3 mb-3 mr-md-3 mt-lg-0 mb-lg-0">descubre más</button></a>
        </div>
      </div>
  </div>
  <div v-show="view_type==='blackfriday'" class="card-promo mt-5">
    <div class="row">
      <div class="tag-courses tag-lw ml-3 mt-2">Cursos de navidad</div>
    </div>
    <div class="row">
      <div class="col-12 col-lg-6 text-light mt-4 text-center text-md-left">
        <h2 class="fs-23 text-light"><span class="font-bf">20% <span class="dto-size">dto</span></span> <br class="mb-3"> en todos los cursos del Campus de Navidad</h2>
      </div>
      <div class="row col-6 col-lg-4 ml-lg-0 mr-lg-0 ml-auto mr-auto justify-content-center">
        <img src="/assets/images/promos/campus_navidad.svg" alt="">
      </div>
      <p class="col-12 text-light pop16 text-center text-md-left">Con la compra de un curso intensivo, te enviaremos un cupón descuento válido para comprar otro <span class="yellow">GRATIS</span>.</p>
    </div>
      <div class="row flex-column-reverse flex-lg-row">
        <p class="col-12 col-lg-10 pop12 mb-0 text-center text-md-left">* El descuento aparece aplicado directamente en el precio final de  la compra. No aplica en cursos anuales o cursos de campus de navidad.</p>
        <div class="row col-12 col-lg-2 justify-content-center mx-auto">
            <a href="/es/campus-de-navidad"><button class="btn-promo mt-3 mb-3 mr-md-3 mt-lg-0 mb-lg-0">descubre más</button></a>
        </div>
      </div>
  </div>
  <div v-show="view_type==='cybermonday'" class="card-promo mt-5">
    <div class="row">
      <div :class="{'cm-tag':view_type!='blackfriday'}" class="tag-courses ml-3 mt-2">Cursos intensivos</div>
    </div>
    <div class="row">
      <div class="col-12 col-lg-6 text-light mt-4 text-center text-md-left">
        <h2 class="fs-23 text-light"><span :class="{'font-cm':view_type!='blackfriday'}" class="font-bf">20% <span class="dto-size">dto</span></span> <br class="mb-3"> en todos los cursos intensivos</h2>
        <p class="mt-2 pop16">¡Regala conocimiento y diversión! Invierte en su futuro.</p>
      </div>
      <div class="row col-6 col-lg-4 ml-lg-0 mr-lg-0 ml-auto mr-auto justify-content-center">
        <img src="/assets/images/promos/robot_promo.svg" alt="">
      </div>
    </div>
      <div class="row flex-column-reverse flex-lg-row">
        <p class="col-12 col-lg-10 pop12 mb-0 text-center text-md-left">* El descuento aparece aplicado directamente en el precio final de  la compra. No aplica en cursos anuales o cursos de campus de navidad.</p>
        <div class="row col-12 col-lg-2 justify-content-center mx-auto">
            <a href="/es/cursos"><button :class="{'cm-btn':view_type!='blackfriday'}" class="btn-promo mt-3 mb-3 mr-md-3 mt-lg-0 mb-lg-0">descubre más</button></a>
        </div>
      </div>
  </div>
</div>
</template>

<script>
export default {
  props: ['view_type'],
  data: ()=>({
  })
}
</script>

<style scoped>
.card-promo {
  max-width: 1114px;
  height: auto;
  padding: 20px 20px 16px;
  border-radius: 10px;
  box-shadow: 0 0 8px 4px rgba(255, 179, 0, 0.21);
  background-color: #1a1d1f;
}

.tag-courses {
  width: 147px;
  height: 32px;
  padding: 4px 8px;
  border-radius: 4px;
  border: solid 1px #ffb300;
  font-family: 'Poppins';
  font-size: 14px;
  font-weight: 600;
  color: #ffb300;
}

.tag-lw{
  width: 155px !important;
}

.tag-width{
  width: 131px !important;
}

.cm-tag{
  width: 155px !important;
  border: solid 1px #29c0d3 !important;
  color: #29c0d3;
}

.cm-tag2{
  border: solid 1px #29c0d3 !important;
  color: #29c0d3;
}

.fs-23{
  font-size: 23px;
}

.pop39{
  font-family: 'Poppins';
  font-size: 39px;
  font-weight: 500;
  color: #fff;
}

.pop25{
  font-size: 25px;
  font-weight: 500;
}

.pop30{
  font-size: 30px;
  font-weight: 700;
}

.pop21{
  font-size: 21px;
  font-weight: 300;
}

.pop16{
  font-family: 'Poppins';
  font-size: 16px;
  font-weight: 300;
}

.pop16>span{
  font-size: 18px;
  font-weight: 600;
  color: #29c0d3;
}

.pop16>span.yellow{
  color: #ffb300;
}

.pop14{
  font-size: 14px;
  font-weight: 300;
}

.pop14>span{
  font-weight: 500;
}

.pop12{
  font-family: 'Poppins';
  font-size: 12px;
  font-weight: 300;
  color: #8c9093;
}  

.font-bf{
  font-size: 61px;
  font-weight: 600;
  color: #ffb300;
}

.font-bf.font-cm{
  color: #29c0d3 !important;
}

.dto-size{
  font-size: 30px;
}

.btn-promo {
  width: 148px;
  height: 32px;
  padding: 6px 20px;
  border-radius: 3px;
  box-shadow: 0 2px 5px 0 rgba(255, 179, 0, 0.18);
  background-color: #ffb300;
  font-family: 'Poppins';
  font-size: 14px;
  font-weight: bold;
  color: #1a1d1f;
  text-transform: uppercase;
}

.cm-btn{
  box-shadow: 0 2px 5px 0 rgba(52, 58, 64, 0.25) !important;
  background-color: #29c0d3 !important;
}

</style>
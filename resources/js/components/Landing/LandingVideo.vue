<template>
<div class="container">
  <h2 class="section-title mb-10">¿Qué nos hace únicos?</h2>
  <div class="row">
      <div class="col-12 col-lg-6 my-auto">
          <ul>
              <li><span>Clases online</span> en grupo muy reducidas.</li>
              <li>Adaptación a tu <span>nivel</span>, ritmo y conocimientos previos.</li>
              <li><span>Seguimiento</span> integral de avance y trayectoria <span>individualizada</span>.</li>
              <li>Contenidos altamente <span>especializados</span> a vuestra medida.</li>
              <li>Acceso a <span>comunidad</span> e iniciativas sociales y profesionales.</li>
          </ul>
      </div>
      <div class="col-12 col-lg-6 text-center">
          <img src="/assets/images/landing_mkt/minecraft_kids.jpg" alt="">
      </div>
  </div>
</div>  
</template>

<script>
export default {

}
</script>

<style scoped>
.section-title{
  font-family: 'Poppins';
  font-size: 28px;
  font-weight: 500;
  text-align: center;
}

ul li::before {
  content: "\2022";
  color: #793e87;
  font-weight: bold;
  display: inline-block; 
  font-size: 26px;
  margin-right: 15px;
  vertical-align: middle;
}

li{
  margin-bottom: 20px;
  font-family: 'Poppins';
  font-size: 16px;
  font-weight: 300;
  color: #343a40;
}

li>span{
    font-weight: 500;
}

</style>
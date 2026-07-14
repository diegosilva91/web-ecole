<template>
<div>
<h3 class="text-center mb-60">¿Qué nos hace únicos?</h3>
<div class="col-11 col-sm-6 mx-auto mb-30" style="max-width:574px !important;">
  <iframe width="100%" height="331" src="https://www.youtube.com/embed/yH36-XxkLy0" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> 
</div>
<div class="bg-details pb-20"> 
  <div class="box">
      <div class="row text-center text-sm-left">
          <div class="col-12 col-sm-6 col-lg-3">
            <h2 class="title-future mt-3 mb-3"><span>1.</span><br class="d-block d-lg-none"> Profesores cualificados</h2>
            <ul class="ml-25 text-left ml-mob-100">
                <li>Control de calidad</li>
                <li>Proceso de admisión</li>
                <li>Contenidos curriculares</li>
            </ul>
          </div>
          <div class="col-12 col-sm-6 col-lg-3">
            <h2 class="title-future mt-3 mb-3"><span>2.</span><br class="d-block d-lg-none"> Aprendizaje personalizado</h2>
            <ul class="ml-35 text-left ml-mob-100">
                <li>Pruebas de nivel</li>
                <li>Programas adaptados</li>
                <li>Certificación de cursos</li>
            </ul>
          </div>
          <div class="col-12 col-sm-6 col-lg-3">
            <h2 class="title-future mt-3 mb-3"><span>3.</span><br class="d-block d-lg-none"> Aula virtual</h2>
            <ul class="ml-35 text-left ml-mob-100">
                <li>Tecnología propia</li>
                <li>Material exclusivo</li>
                <li>Comunicación interna</li>
            </ul>
          </div>
          <div class="col-12 col-sm-6 col-lg-3">
            <h2 class="title-future mt-3 mb-3"><span>4.</span><br class="d-block d-lg-none"> Plataforma segura</h2>
            <ul class="ml-35 text-left ml-mob-100">
                <li>Precios competitivos</li>
                <li>Opciones de pago</li>
                <li>Privacidad de datos</li>
            </ul>
          </div>
      </div>
  </div>
</div>
</div>
</template>

<script>
export default {

}
</script>

<style scoped>
.box {
  margin-left: 10%;
  margin-right: 2%;
}

h3 {
    font-weight: 500;
}

.title-future {
    font-size: 18px;
    font-weight: 600;
}

.title-future>span {
  font-size: 38px;
  font-weight: 300;
  color: #793e87;
}

li {
  font-family: 'Poppins';
  font-size: 14px;
  font-weight: 300;
  line-height: 1.86;
  color: #343a40;;
}

ul {
  list-style-type: disc;
}

.bg-details {
    background-color: #f2feff;
}

@media (max-width: 430px) {
  .box {
    margin-right: 10%;
  }
}
</style>
<template>
<div :class="font">
  <div class="container">
      <div class="row mt-50 mt-mob-10">
          <div class="col-12 col-md-7 my-auto ml-mob-20">
              <h1 class="title">La educación del mundo real</h1>
              <ul class="pl-0">
                  <li><img class="mr-2" src="/assets/images/icons/checked_purple.svg" alt=""> Clases online y en vivo.</li>
                  <li><img class="mr-2" src="/assets/images/icons/checked_purple.svg" alt=""> En grupos reducidos de 75 minutos.</li>
                  <li><img class="mr-2" src="/assets/images/icons/checked_purple.svg" alt=""> Plan personalizado para cada estudiante.</li>
                  <li><img class="mr-2" src="/assets/images/icons/checked_purple.svg" alt=""> Cursos de programación, robótica, videojuegos…</li>
              </ul>
              <button data-toggle="modal" data-target="#leadsModal">SESIÓN INFORMATIVA GRATIS</button>
          </div>
          <div class="col-11 col-md-5 mx-auto">
              <img src="/assets/images/home/boy_robot.png" alt="" width="442">
          </div>
      </div>
  </div>
  <div class="bg-info-home">
  <div class="box row justify-content-center ml-mob-20 ml-tb-15 mr-tb-5 mt-50">
            <div class="col-12 col-sm-6 col-md-4 mx-auto">
                <div class="d-flex">
                    <div class="mr-3 my-auto" style="width:37px;">
                        <img src="/assets/images/landing_mkt/info_edu.svg" alt="">
                    </div>
                    <div>
                        <h5>Somos Educación</h5>
                        <h6>
                            Apostamos por una nueva educación<br class="d-block d-sm-none d-lg-block"> necesaria en la sociedad actual.
                        </h6>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4 mx-auto">
                <div class="d-flex">
                    <div class="mr-3 my-auto" style="width:37px;">
                        <img src="/assets/images/landing_mkt/info_future.svg" alt="">
                    </div>
                    <div>
                        <h5>Somos Trayectoria</h5>
                        <h6>
                            Guiamos a cada alumno hacia su máximo<br class="d-block d-sm-none d-lg-block"> potencial a través de sus pasiones.
                        </h6>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4 mx-auto">
                <div class="d-flex">
                    <img class="mr-3" src="/assets/images/landing_mkt/info_safety.svg" alt="">
                    <div>
                        <h5>Somos Innovación</h5>
                        <h6>
                            Programas innovadores, visionarios,<br class="d-block d-sm-none d-lg-block"> actuales y creativos.
                        </h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    data() {
        return {
            font:'',
        }
    },
    mounted() {
        this.$nextTick(()=>{
            setTimeout(() =>{
                this.font="lazyload";
                this.$emit('loadFont');
            },50)
        })
    },
}
</script>

<style scoped>
.box {
  margin-left: 12%;
  margin-right: 2%;
}

.title {
    font-size: 33px !important;
    font-weight: 700;
}

li {
  font-family: 'Poppins';
  font-size: 14px;
  line-height: 2.14;
  color: #343a40;
}

ul {
    margin-top: 10px;
    margin-bottom: 20px;
}

button {
  width: 230px;
  height: 43px;
  border-radius: 6px;
  background-color: #29c0d3;
  font-family: 'Open Sans';
  font-size: 14px;
  font-weight: bold;
  color: #fff;
}

h5 {
    font-weight: 600;
}

.bg-info-home {
     background-color: #f2feff;
}

@media (min-width: 1264px) {
    .pr-lg-10 {
        padding-right: 40px !important;
    }
}

</style>
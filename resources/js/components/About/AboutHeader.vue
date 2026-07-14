<template>
  <div class="row align-items-center bg-about-header">
    <div class="text-dark">
        <div class="row align-items-center">
            <div class="col-12 col-md-12 col-lg-5 p5 pr-lg-0 ">
                <h1>Sobre nosotros</h1>
                <p class="mt-4">Somos la primera plataforma digital de nuevas tecnologías en ofrecer cursos online en vivo con disciplinas innovadoras y diferentes para alumnos de entre 6 y 16 años. Un lugar donde los niños podrán descubrir nuevas aficiones, desarrollar conocimientos de materias escolares y pasárselo bien durante su aprendizaje de una forma segura.</p>
            </div>
            <div class="col-12 col-md-12 col-lg-7 mb-mob-60 pr-sm-0 mx-auto pb-0"> 
              <div class="video-responsive">
                <img class="img-dk" src="/assets/images/about/monitor_header.png" alt=""> 
                <img class="img-mob" src="/assets/images/about/monitor_header_mob.png" alt=""> 
                <iframe style="z-index:0;"  src="https://www.youtube.com/embed/yH36-XxkLy0" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> 
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
  .img-mob {
    display: none;
  }

  .img-dk {
    display: block;
  }
  
  h1 {
    font-weight: 700;
  }

  p {
    font-family: 'Poppins';
    font-size: 18px;
    font-weight: 300;
  }

  .p5 {
    padding-left: 100px;
  }

  .video-responsive {
    height: 0;
    overflow: hidden;
    padding-bottom: 56.25%;
    padding-top: 2.76%;
    position: relative;
  }

  .video-responsive iframe, .video-responsive object, .video-responsive embed {
      height: 65.3%;
      left: 22.96%;
      position: absolute;
      top: 11.7%;
      width: 68.2%;
  }

  .video-responsive img {
    height: 100%;
    left: -1%;
    position: absolute;
    width: 100%;
  }  

  @media  (max-width: 1000px) {
    h1 {
      font-size: 42px;
    }

    .p5 {
      padding: 4.5rem;
      padding-bottom: 2rem;
    }


  }
  
  @media  (max-width: 414px) {
    .img-mob {
      display: block;
    }

    .img-dk {
      display: none;
    }
    
    .video-responsive iframe, .video-responsive object, .video-responsive embed {
      height: 62.4%;
      left: 8.3%;
      position: absolute;
      top: 9.2%;
      width: 82.7%;
    }
    .video-responsive img {
      left: 0;
      top: 0;
    }
  }  

</style>
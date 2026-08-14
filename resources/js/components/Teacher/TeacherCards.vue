<template>
<div class="container">
    <h2 class="h2-txt-med text-center mb-15 mt-12">
        ¿Qué nos hace diferentes?
    </h2>
    <div class="row">
        <div class="col-12 col-md-6">
          <div class="teacher-card d-flex mr-lg-1">
            <div class="left-line"></div>
            <div class="d-block">
                <h3>Tu evolución como profesional <br> es parte de nuestra base</h3>
                <p>La mejor forma de ofrecer una educación puntera y de <span>calidad</span> es asegurando formar a los mejores profesionales. Nos encantaría que tú fueras uno de ellos.</p>
            </div>
          </div>  
        </div>
        <div class="col-12 col-md-6">
          <div class="teacher-card d-flex ml-lg-1">
            <div class="left-line"></div>
            <div class="d-block">
                <h3>Lo más importante: Acompañar <br> a nuestros alumnos en sus trayectorias</h3> 
                <p>Conociendo los contenidos de base a impartir, tendrás <span>flexibilidad</span> y tus propias posibilidades creativas para desarrollar sus trayectorias educativas a su medida.</p> 
            </div> 
          </div>  
        </div>
        <div class="col-12 col-md-6">
          <div class="teacher-card d-flex mr-lg-1">
            <div class="left-line"></div>
            <div class="d-block">
                <h3>Soporte educativo</h3>
                <p>Disponemos de varios recursos para darte <span>apoyo</span> y tener capacidad de ayudar y guiar a toda clase de alumnos.</p>
            </div>  
          </div>  
        </div>
        <div class="col-12 col-md-6">
          <div class="teacher-card d-flex ml-lg-1">
            <div class="left-line"></div>
            <div class="d-block">
                <h3>Crecimiento internacional</h3>  
                <p>Mi-empresa es una startup joven en plena fase de crecimiento donde surgen constantemente nuevas <span>oportunidades</span> profesionales.</p>
            </div>
          </div>  
        </div>
    </div>
    <teacher-modal-form btnTxt='¡Quiero ser educador!' class="mb-10 mt-9"></teacher-modal-form>
</div>
</template>

<script>
export default {

}
</script>

<style scoped>
.teacher-card {
  max-width: 477px;
  height: auto;
  padding: 20px 60px 20px 20px;
  border-radius: 12px;
  box-shadow: 0 4px 18px 0 rgba(0, 0, 0, 0.1);
  margin-left: auto;
  margin-right: auto;
  margin-bottom: 20px;
}

h3 {
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 12px;
}

p {
    font-family: 'Poppins';
    font-size: 16px;
    font-weight: 300;
    margin-bottom: 0px;
}

p>span {
    font-weight: 500;
}

.left-line {
  padding-right: 4px;
  margin-right: 20px;
  height: auto;
  border-radius: 2.5px;
  background-image: linear-gradient(to top, #954fa0 , #29c0d3 );
}

@media  (max-width: 450px) {
    .teacher-card {
        padding-right: 30px;
    }    
}
</style>
<template>
<div class="container">
  <h2 class="section-title mb-60">Nuestros Lifecoolers</h2>
  <div class="row justify-content-center">
      <div v-for="(review, i) in reviews" :key="i">
        <div class="col">
            <div class="card-reviews">
                <div class="d-flex">
                    <div class="">
                        <img :src="'/assets/images/landing_mkt/' + review.img" alt="">
                    </div>
                    <div class="my-auto">
                        <h4>{{review.name}}</h4>
                        <h5>{{review.subtitle}}</h5>
                    </div>
                </div>
                <hr class="line-card mt-0">
                <p>{{review.description}}</p>
            </div>
        </div>
      </div>
  </div>
  <div class="d-flex col-11 ml-80">
    <h5 class="mt-3 ml-auto">Opiniones de usuarios reales*</h5>
  </div>
</div>
</template>

<script>
export default {
     data: ()=>({
        reviews:[
            {img:'avatar_1.svg',name:'Fernando',subtitle:'Padre Lifecooler',description:'“Mi hijo se ha convertido en un auténtico fan de las clases de Lifecole. Ha sido un acierto de regalo de cumpleaños. Repetiremos con el de continuación.”'},
            {img:'avatar_2.svg',name:'Ana Belén',subtitle:'Madre Lifecooler',description:'“Mi peque es súper tímida, siempre observaba a Youtubers jugando a Minecraft y me enteré que es una puerta al inicio de la programación. El asesoramiento y atención de Lifecole ofrecieron el curso perfecto (...)”'},
            {img:'avatar_3.svg',name:'María Moreno',subtitle:'Madre Lifecooler',description:'“Mi peque está feliz con sus clases. Hay muy buen equipo detrás. Los profesores tienen mucha pasión en lo que hacen y lo transmiten. Ahora más que nunca, necesitamos apoyo con la educación de nuestros hijos.”'},
            {img:'avatar_4.svg',name:'Rebeca',subtitle:'Madre Lifecooler',description:'“Experiencia inmejorable. Profes profesionales y didácticos, el resto del equipo ofrece una excelente atención individualizada y resolutiva..”'}
        ]
    })
}
</script>

<style scoped>
.section-title{
  font-family: 'Poppins';
  font-size: 28px;
  font-weight: 500;
  text-align: center;
}

.card-reviews {
  max-width: 256px;
  height: 313px;
  border-radius: 10px;
  box-shadow: 0 4px 18px 0 rgba(0, 0, 0, 0.11);
  padding: 30px 18px 10px 18px;
}

h4 {
  font-size: 12px;
  font-weight: 500;
  color: #5c2767;
}

h5 {
  font-size: 12px;
  font-weight: 300; 
}

p {
  opacity: 0.85;
  font-family: 'Poppins';
  font-size: 14px;
  font-style: italic;
  color: #343a40;
  margin-top: 12px;
}

img {
  margin-left: -10px;
}

.line-card {
  background-image: linear-gradient(to left, #954fa0 , #29c0d3 );
  height: 2px;

}

@media  (max-width: 430px) {
  .card-reviews {
    max-width: 290px;
  }

  .ml-80 {
    margin-left: 0px;
    padding-right: 20px;
  }
}

@media  (min-width: 1788px) {
  .ml-80 {
    margin-left: 0px;
    padding-right: 25px;
  }
}
</style>
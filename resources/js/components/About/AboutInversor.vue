<template>
<div> 
  <div class="container">
      <h3 class="text-center mb-9">Nuestros Inversores</h3>
  </div>
  <div class="row bg-inversor align-items-center justify-content-center">
      <div class="container row ml-dk-140">
          <div class="col-12 col-lg-4 ml-6 ml-sm-0 mt-mob-30 mt-tb-30">
              <h5>Jesus Monleón</h5>
              <div class="line"></div>
              <button class="btn-more" @click="showInfo('1')">
                <v-icon small>{{ arrow ? mdiArrowDown : mdiArrowUp }}</v-icon>
                &nbsp;{{btnLabel?'Ver Más':'Ver Menos'}}
              </button>
              <p v-if="card">Mentor de Mi-empresa. En 2001 cofundó eMagister.com, el mayor portal de formación de España y la Asociación de Formación Online de España (AEFOL). Además, es business angel y participa en muchos proyectos de formación para niños y adolescentes (Openwebinars, UnProfesor, IEBS, etc.)</p>
          </div>
          <div class="col-12 col-lg-4 ml-6 ml-sm-0 mt-mob-30 mt-tb-30">
              <h5>Miguel Vicente</h5>
              <div class="line line-purple"></div>
              <button class="btn-more" @click="showInfo('2')">
                <v-icon small>{{ arrow2 ? mdiArrowDown : mdiArrowUp }}</v-icon>
                &nbsp;{{btnLabel2?'Ver Más':'Ver Menos'}}
              </button>
              <p v-if="card2">Miguel co-fundó Antai Venture Builder en 2012. Desde entonces,   co-fundo a través de Antai múltiples emprendimientos como Wallapop, Justbell (Glovo), Prontopiso, Elma, Nemuru y Singular Cover entre otros. También preside y es fundador y seguidor del clúster Barcelona Tech City compuesto por más de 800 empresas digitales.</p>
          </div>
          <div class="col-12 col-lg-4 ml-6 ml-sm-0 mt-mob-30 mt-tb-30">
              <h5>Gerard Olivé</h5>
              <div class="line line-blue"></div>
              <button class="btn-more" @click="showInfo('3')">
                <v-icon small>{{ arrow3 ? mdiArrowDown : mdiArrowUp }}</v-icon>
                &nbsp;{{btnLabel3?'Ver Más':'Ver Menos'}}
              </button>
              <p v-if="card3">Fundador y Chairman de BeRepublic y BeAgency. Cofundador y Co CEO de Antai Venture Builder. En 2005 fundó el holding de negocios digitales Garapa donde crean negocios e intervienen en ideas disruptivas. Cofundador de Wallapop, Glovo, Mascoteros, Marmota, Havet, Prontopiso, Medox o Trendier.</p>
          </div>
      </div>
      <div class="container row ml-dk-140">
          <div class="col-12 col-lg-4 ml-6 ml-sm-0">
              <h5>Jan Frey</h5>
              <div class="line line-purple"></div>
              <button class="btn-more" @click="showInfo('4')">
                <v-icon small>{{ arrow4 ? mdiArrowDown : mdiArrowUp }}</v-icon>
                &nbsp;{{btnLabel4?'Ver Más':'Ver Menos'}}
              </button>
              <p v-if="card4">Miembro de la junta de accionistas del Grupo Henkel. Miembro de la junta directiva de Antai</p>
          </div>
          <div class="col-12 col-lg-4 ml-6 ml-sm-0 mt-mob-30 mt-tb-30">
              <h5>Javier Nuche</h5>
              <div class="line line-blue"></div>
              <button class="btn-more" @click="showInfo('5')">
                <v-icon small>{{ arrow5 ? mdiArrowDown : mdiArrowUp }}</v-icon>
                &nbsp;{{btnLabel5?'Ver Más':'Ver Menos'}}
              </button>
              <p v-if="card5">Director General de Atresmedia Diversificación. Miembro del comité de dirección de Atresmedia. Lidera un equipo de más de 34 profesionales. Con experiencia en auditoria en Altadis y Deloitte.</p>
          </div>
          <div class="col-12 col-lg-4 ml-6 ml-sm-0 mt-mob-30 mt-tb-30 mb-mob-50 mb-tb-50">
              <h5>Javier Cebrián</h5>
              <div class="line"></div>
              <button class="btn-more" @click="showInfo('6')">
                <v-icon small>{{ arrow6 ? mdiArrowDown : mdiArrowUp }}</v-icon>
                &nbsp;{{btnLabel6?'Ver Más':'Ver Menos'}}
              </button>
              <p v-if="card6">CEO y fundador Bonsai Venture Capital. Suelen invertir en startups del sector e-health, games, payments, security y travel. Como inversiones destacan Wedding Wire, Wallapop, LinktoMedia, Gigas, Glovo,<br> Paack, Cornerjob, Emagister y Yournewself.</p>
          </div>
      </div>
  </div>
</div>   
</template>

<script>
import { mdiArrowDown, mdiArrowUp } from '@mdi/js';

export default {
  data() {
    return {
      arrow:true,
      btnLabel:true,
      arrow2:true,
      btnLabel2:true,
      arrow3:true,
      btnLabel3:true,
      arrow4:true,
      btnLabel4:true,
      arrow5:true,
      btnLabel5:true,
      arrow6:true,
      btnLabel6:true,
      card:false,
      card2:false,
      card3:false,
      card4:false,
      card5:false,
      card6:false,
      mdiArrowDown,
      mdiArrowUp
    }
  },

  methods: {
    showInfo(card) {
      switch(card) {
        case '1' :
          this.arrow = !this.arrow;
          this.btnLabel = !this.btnLabel;
          this.card = !this.card;
          this.card2 = false;
          this.card3 = false;
          this.card4 = false;
          this.card5 = false;
          this.card6 = false;
          this.arrow2=this.btnLabel2=this.arrow3=this.btnLabel3=this.arrow4=this.btnLabel4=this.arrow5=this.btnLabel5=this.arrow6=this.btnLabel6= true;
          break;
        case '2':
          this.arrow2 = !this.arrow2;
          this.btnLabel2 = !this.btnLabel2;
          this.card = false;
          this.card2 = !this.card2;
          this.card3 = false;
          this.card4 = false;
          this.card5 = false;
          this.card6 = false;
          this.arrow=this.btnLabel=this.arrow3=this.btnLabel3=this.arrow4=this.btnLabel4=this.arrow5=this.btnLabel5=this.arrow6=this.btnLabel6= true;
          break;
        case '3':
          this.arrow3 = !this.arrow3;
          this.btnLabel3 = !this.btnLabel3;
          this.card = false;
          this.card2 = false;
          this.card3 = !this.card3;
          this.card4 = false;
          this.card5 = false;
          this.card6 = false;
          this.arrow=this.btnLabel=this.arrow2=this.btnLabel2=this.arrow4=this.btnLabel4=this.arrow5=this.btnLabel5=this.arrow6=this.btnLabel6= true;
          break;
        case '4':
          this.arrow4 = !this.arrow4;
          this.btnLabel4 = !this.btnLabel4;
          this.card = false;
          this.card2 = false;
          this.card3 = false;
          this.card4 = !this.card4;
          this.card5 = false;
          this.card6 = false;
          this.arrow=this.btnLabel=this.arrow3=this.btnLabel3=this.arrow2=this.btnLabel2=this.arrow5=this.btnLabel5=this.arrow6=this.btnLabel6= true;
          break;
        case '5':
          this.arrow5 = !this.arrow5;
          this.btnLabel5 = !this.btnLabel5;
          this.card = false;
          this.card2 = false;
          this.card3 = false;
          this.card4 = false;
          this.card5 = !this.card5;
          this.card6 = false;
          this.arrow=this.btnLabel=this.arrow3=this.btnLabel3=this.arrow4=this.btnLabel4=this.arrow2=this.btnLabel2=this.arrow6=this.btnLabel6= true;
          break;
        case '6':
          this.arrow6 = !this.arrow6;
          this.btnLabel6 = !this.btnLabel6;
          this.card = false;
          this.card2 = false;
          this.card3 = false;
          this.card4 = false;
          this.card5 = false;
          this.card6 = !this.card6;
          this.arrow=this.btnLabel=this.arrow3=this.btnLabel3=this.arrow4=this.btnLabel4=this.arrow5=this.btnLabel5=this.arrow2=this.btnLabel2= true;
      } 
    },
  }
}
</script>

<style scoped>
.bg-inversor {
    min-height: 272px;
    background-color: rgba(193, 199, 211, 0.27);
}

h5 {
    font-weight: 600;
}

p {
    opacity: 0.75;
    font-family: 'Poppins';
    font-size: 15px;
    color: #343a40;
    margin-top: 20px;
    padding-right: 50px;
}

.btn-more {
    opacity: 0.75;
    font-family: 'Poppins';
    font-size: 11px;
    font-weight: 500;
    text-transform: uppercase;
}

.line {
  max-width: 171px;
  height: 5px;
  margin: 5px 0;
  background-color: #ffb300;
}

.line.line-purple {
    background-color: #803a91;
} 

.line.line-blue {
    background-color: #28bfd2;
} 

</style>
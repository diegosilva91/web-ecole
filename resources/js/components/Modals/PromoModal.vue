<template>
<div v-show="modal">
<div class="modal fade" id="modalBF" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div :class="{'modal-cyber':viewType==='cybermonday'}" class="modal-dialog modal-dialog-centered modal-bf" role="document">
    <div :class="{'cyber':viewType==='cybermonday'}" class="modal-content">
      <div class="modal-header pb-0">
        <button @click="closeModal()" type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"> <img src="/assets/images/icons/close_white.svg" alt=""></span>
        </button>
      </div>
      <div class="modal-body row justify-content-center pt-0">
        <img :src="viewType==='cybermonday'?'/assets/images/modals/modal_cybermonday.png':'/assets/images/modals/modal_bf.png'" alt="">
         <h4 v-show="viewType=='blackfriday'" class="pop16-light text-center mt-3">Disfruta de estos descuentos utilizando <br class="d-block d-md-none"> el cupón <br class="d-none d-md-block"> <span>BLACK20</span></h4>
      </div>
      <div class="modal-footer justify-content-center">
        <a :href="viewType==='cybermonday'?'/es/campus-de-navidad':'/es/cursos-anuales'"><button type="button" :class="{'btn-cyber':viewType==='cybermonday'}" class="btn-bf mb-3">descubre más</button></a>
      </div>
    </div>
  </div>
</div>
</div>
</template>

<script>
export default {
    props: ['viewType'],
    data: ()=>({
      modal:true,
    }),

    mounted(){
      let promoModal=this.$cookies.get('modalPromo');
      if(promoModal){
        this.modal=false;
        $('.modal-backdrop').remove();
      } else {
        $('#modalBF').modal('show');
      }
    },

    methods:{
      closeModal(){
      this.modal=false;
      let promoModal = this.$cookies.set("modalPromo", promoModal, "1d");
      } 
    }
}
</script>

<style scoped>
.modal-header{
  border-bottom: none !important;
}

.modal-content {
  background-color: #1a1d1f;
  box-shadow: 0 0 8px 4px rgba(255, 179, 0, 0.21);
  border-radius: 10px;
}

.modal-content.cyber{
  box-shadow: 0 0 8px 4px rgba(41, 192, 211, 0.21);
}

.modal-bf{
  width:625px; 
  box-shadow:none !important;
}

.modal-bf.modal-cyber{
  width: 482px;
}

.btn-bf{
  width: 148px;
  height: 32px;
  border-radius: 3px;
  box-shadow: 0 2px 5px 0 rgba(255, 179, 0, 0.18);
  background-color: #ffb300;
  color: #1a1d1f;
  text-transform: uppercase;
  font-family: 'Poppins';
  font-size: 14px;
  font-weight: bold;
}

.btn-bf.btn-cyber{
  background-color: #29c0d3;
  color: #fff;
}

.modal-footer{
  border-top: none !important;
}

.pop16-light{
  font-size: 16px;
  font-weight: 300;
  color: #fff;
}

.pop16-light>span{
  font-size: 21px;
  font-weight: 700;
  color: #ffb300;
}

@media  (max-width: 767.98px) {
  .modal-bf{
    width: 96%;
  }

  .modal-bf.modal-cyber{
    width: 96%;
  }
}
</style>
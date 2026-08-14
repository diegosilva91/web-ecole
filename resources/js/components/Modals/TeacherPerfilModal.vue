<template>
  <v-dialog max-width="560" height="200" v-model="modalCash">
    <v-list>
      <v-list-item>
        <h5 class="ml-4">¡Recuerda!</h5>
      </v-list-item>
      <v-list-item>
        <h6 class="ml-4 mt-5 mb-8">Debe aceptar el contrato de intermediación y responsabilidad <br /> con Mi-empresa, para guardar sus datos correctamente.</h6>
      </v-list-item>
      <v-list-item>
        <button class="btn-confirm mx-auto mb-5" @click="confirmContract()">
          Aceptar
        </button>
      </v-list-item>
    </v-list>
  </v-dialog>
</template>

<script>
import Event from "../../event";

export default {
  data() {
    return{
      modalCash: false,
    }
  },
  mounted() {
      Event.$on("openModalCash",()=>{
          this.modalCash= true;
      });
  },

  methods: {
    confirmContract() {
      Event.$emit('confirmContract');
      this.modalCash=false;
    }
  }
};
</script>

<style scoped>
h5{
    font-weight: 600;
    margin-top: 30px;
    text-transform: uppercase;
}

h6{
    font-size: 16px;
}

.btn-confirm {
    width: 150px;
    height: 40px;
    padding: 0px 15px;
    border-radius: 12px;
    box-shadow: 0 2px 5px 0 rgba(41, 192, 211, 0.3);
    border: solid 1px #29c0d3;
    background-color: #29c0d3;
    color: white;
    font-family: 'Poppins';
    font-size: 16px;
    font-weight: 600;
}
</style>

<style>
  .v-dialog {
    border-radius: 12px !important;
  }
</style>
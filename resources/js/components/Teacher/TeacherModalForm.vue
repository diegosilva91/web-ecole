<template>
<div>
    <div class="d-flex justify-content-center">
        <button @click="modal = true" class="btn-registrate mt-6">{{btnTxt}}</button>
    </div>
        <v-dialog scrollable max-width="406" v-model="modal">
            <register-teacher-form id="Modal"></register-teacher-form>
        </v-dialog>
</div>
</template>

<script>
import Event from '../../event.js';
export default {
    props:['btnTxt'],
    data() {
        return {
            modal: false
        };
    },
    mounted(){
        Event.$on('closeModal', () => {this.modal=false;});
    }

};
</script>

<style scoped>

.btn-registrate {
  width: 208px;
  height: 40px;
  border-radius: 4px;
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

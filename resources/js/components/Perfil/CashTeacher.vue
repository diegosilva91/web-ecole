<template>
<div>
    <div class="box-cash">
      <div class="d-flex ml-8">
        <h5>Datos Facturación</h5>
        <button @click="editCash()" class="ml-auto mr-5">{{btnTxt?'Editar':'Guardar'}}</button>
      </div>
      <hr class="w-100">
      <div v-show="btnTxt">
        <div class="row mt-5 ml-8">
          <div class="col-12 col-lg-4 pl-0">
            <h6>Nombre y Apellidos / Razón Social</h6>
            <input class="mb-4 w-inp-mob" :value="rs" type="text" readonly>
          </div>
          <div class="col-12 col-lg-4 pl-0">
            <h6>NIF / CIF</h6>
            <input class="mb-4 w-inp-mob" :value="nif" type="text" readonly>
          </div>
          <div class="col-12 col-lg-4 pl-0">
            <h6>Email</h6>
            <input class="mb-4 w-inp-mob" :value="email" type="text" readonly>
          </div>
        </div>
        <div class="row mt-lg-2 ml-8">
          <div class="col-12 col-lg-4 pl-0">
            <h6>IBAN</h6>
            <input class="mb-4 w-inp-mob" :value="iban" type="text" readonly>
          </div>
          <div class="col-12 col-lg-4 pl-0">
            <h6>Dirección</h6>
            <input class="mb-4 w-inp-mob" :value="address" type="text" readonly>
          </div>
          <div class="col-12 col-lg-4 pl-0">
            <h6>Código Postal</h6>
            <input class="mb-4 w-inp-mob" :value="cp" type="text" readonly>
          </div>
        </div>
        <div class="row mt-lg-2 ml-8">
          <div class="col-12 col-lg-4 pl-0">
            <h6>Localidad</h6>
            <input class="mb-4 w-inp-mob" :value="local" type="text" readonly>
          </div>
          <div class="col-12 col-lg-4 pl-0">
            <h6>Provincia</h6>
            <input class="mb-4 w-inp-mob" :value="city" type="text" readonly>
          </div>
          <div class="col-12 col-lg-4 pl-0">
            <h6>País</h6>
            <input class="mb-4 w-inp-mob" :value="country" type="text" readonly>
          </div>
        </div>
      </div>
      <div :class="{'d-none':btnTxt}">
        <div class="row mt-5 ml-8">
          <div class="col-12 col-lg-4 pl-0">
            <h6>Nombre y Apellidos / Razón Social</h6>
            <input class="mb-4 w-inp-mob" v-model="rs" type="text" name="rs" id="18">
          </div>
          <div class="col-12 col-lg-4 pl-0">
            <h6>NIF / CIF</h6>
            <input class="mb-4 w-inp-mob" v-model="nif" type="text" name="nif" id="17">
          </div>
          <div class="col-12 col-lg-4 pl-0">
            <h6>Email</h6>
            <input class="mb-4 w-inp-mob" v-model="email" type="text" name="email" id="16" readonly>
          </div>
        </div>
        <div class="row mt-lg-2 ml-8">
          <div class="col-12 col-lg-4 pl-0">
            <h6>IBAN</h6>
            <input class="mb-4 w-inp-mob" v-model="iban" type="text" name="iban" id="15">
          </div>
          <div class="col-12 col-lg-4 pl-0">
            <h6>Dirección</h6>
            <input class="mb-4 w-inp-mob" v-model="address" type="text" name="address" id="14">
          </div>
          <div class="col-12 col-lg-4 pl-0">
            <h6>Código Postal</h6>
            <input class="mb-4 w-inp-mob" v-model="cp" type="text" name="cp" id="13">
          </div>
        </div>
        <div class="row mt-lg-2 ml-8">
          <div class="col-12 col-lg-4 pl-0">
            <h6>Localidad</h6>
            <input class="mb-4 w-inp-mob" v-model="local" type="text" name="local" id="12">
          </div>
          <div class="col-12 col-lg-4 pl-0">
            <h6>Provincia</h6>
            <input class="mb-4 w-inp-mob" v-model="city" type="text" name="city" id="10">
          </div>
          <div class="col-12 col-lg-4 pl-0">
            <h6>País</h6>
            <input class="w-inp-mob" v-model="country" type="text" name="country" id="11">
          </div>
        </div>
        <div class="mt-2 d-flex justify-content-end mr-5 ml-8">
          <v-checkbox
              v-model="checkbox"
              color="#793e87"
              value=""
              label="Acepto contrato de intermediación y responsabilidad con Lifecole"
          ></v-checkbox>
        </div>
      </div>
    </div>
    <v-alert
      dense
      :icon="mdiInformationOutline"
      type="info"
      class="w-75 mb-100"
    >
      El Profesor deberá cumplir con sus obligaciones fiscales o de otra índole, derivadas de la venta de sus cursos
    </v-alert>
    <CashModal />
</div>
</template>

<script>
import { mdiInformationOutline } from "@mdi/js";
import CashModal from '../Modals/TeacherPerfilModal'
import Event from '../../event.js';
import {UpdateObjectApi} from "../../axios-services";
export default {
   components: {
     CashModal,
   },
   data(){
       return {
          btnTxt: true,
          rs:'',
          nif:'',
          email:'',
          iban:'',
          address:'',
          cp:'',
          local:'',
          city:'',
          country:'',
          checkbox:true,
          mdiInformationOutline
       }
   },
   mounted() {
       let vm=this
       Event.$on('aboutActive' ,()=> {if(this.checkbox){this.btnTxt=true;}else{this.btnTxt=false;Event.$emit('openModalCash')}})
       Event.$on('perfil-teacher' ,({user,url})=>{
           vm.email=user.email
           vm.rs=user.teacher.business_name
           vm.nif=user.teacher.nif_cif
           vm.iban=user.teacher.iban
           vm.address=user.teacher.address
           vm.cp=user.teacher.postal_code
           vm.local=user.teacher.location
           vm.city=user.teacher.province
           vm.country=user.teacher.country
       }),
       Event.$on('confirmContract',()=> {this.checkbox= true;this.btnTxt=true;})
   },
    computed: {
        formCashTeacher() {
            return {
                business_name : this.rs,
                nif_cif : this.nif,
                iban : this.iban,
                address : this.address,
                postal_code : this.cp,
                location : this.local,
                province : this.city,
                country : this.country,
            }
        },
    },
   methods: {
       editCash() {
         if(this.checkbox){
             console.log(this.btnTxt)
             if (this.btnTxt === false) {
                 UpdateObjectApi(`teachers/${this.$route.params.id}`, this.formCashTeacher, (error, data) => {
                     if(data){

                     }
                 })
             }
           this.btnTxt=!this.btnTxt;

         } else{
           Event.$emit('openModalCash');
         }
       },
   }
}
</script>

<style scoped>
.box-cash {
  min-width: 350px;
  height: 453px;
  margin-top: 50px;
  margin-bottom: 25px;
  margin-right: 10%;
  padding: 26px 0;
  border-radius: 12px;
  box-shadow: 0 4px 18px 0 rgba(0, 0, 0, 0.15);
  background-color: #ffffff;
}

h5 {
  font-weight: 600;
  text-transform: uppercase;
}

button {
  font-family: 'Poppins';
  font-size: 14px;
  font-weight: 600;
  color: #29c0d3;
}

h6 {
  font-weight: 500;
  opacity: 0.7;
}

input{
  font-family: 'Poppins';
  font-size: 16px;
  font-weight: 400;
  color: #343a40;
  margin-top: 4px;
  border:none;
  border-bottom: 1px solid #29c0d3;
  padding-top: 4px;
}

input[readonly]{
    border-bottom:none !important;
}

.v-alert{
  font-family: 'Poppins';
  font-size: 14px;
  color: #343a40;
  max-width: 900px;
}

@media  (max-width: 1450px) {
  .w-inp-mob{
    width: 75%;
  }
}

@media  (max-width: 1200px){
  .box-cash{
    height: auto;
  }
}

@media (max-width: 600px){
  .box-cash{
    margin-left: -5%;
    margin-right: auto;
  }

  .alert-info-teacher{
    margin-left: -5%;
  }
}

</style>

<style>
.v-alert__icon{
  color: gray !important;
}

.v-label{
  margin-bottom: 0px !important;
  font-family: 'Poppins';
  font-size: 14px;
}
</style>

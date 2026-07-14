<template>
<div class="info-perfil-container">
<div v-show="about" class="row">
    <div class="box-about">
      <div class="d-flex ml-8">
        <h5>Sobre Ti</h5>
        <button @click="editAbout()" class="ml-auto mr-5">{{btnTxt1?'Editar':'Guardar'}}</button>
      </div>
      <hr class="w-100">
      <div v-show="btnTxt1" class="ml-8">
        <div class="mt-5">
          <h6>Nombre</h6>
          <input :value="name" type="text" readonly>
        </div>
        <div class="mt-7">
          <h6>Apellidos</h6>
          <input :value="surname" type="text" readonly>
        </div>
        <div class="mt-7">
          <h6>Teléfono</h6>
          <input :value="phone" type="text" readonly>
        </div>
        <div class="mt-7">
          <h6>CV / RRSS</h6>
          <input :value="cv" type="text" readonly>
        </div>
        <div v-show="checkedPerfil">
          <div class="d-flex mt-7">
            <h6 class="my-auto">Perfil Verificado</h6>
            <img class="ml-2" src="/assets/images/perfil_teacher/checked.svg" alt="">
          </div>
        </div>
        <div :class="{'d-none':checkedPerfil}">
          <div class="d-flex mt-7">
            <h6 class="my-auto">Perfil Incompleto</h6>
            <img class="ml-2" src="/assets/images/perfil_teacher/incomplete.svg" alt="">
          </div>
        </div>
      </div>
      <div :class="{'d-none':btnTxt1}" class="ml-8">
        <div class="mt-5">
          <h6>Nombre</h6>
          <input ref="nameInput" v-model="name" type="text" name="name" id="nameTeacher"/>
        </div>
        <div class="mt-7">
          <h6>Apellidos</h6>
          <input v-model="surname" type="text" name="surname" id="1">
        </div>
        <div class="mt-7">
          <h6>Teléfono</h6>
          <input v-model="phone" type="text" name="phone" id="2">
        </div>
        <div class="mt-7">
          <h6>CV / RRSS</h6>
          <input v-model="cv" type="text" name="cv" id="3">
        </div>
        <div v-show="checkedPerfil">
          <div class="d-flex mt-7">
            <h6 class="my-auto">Perfil Verificado</h6>
            <img class="ml-2" src="/assets/images/perfil_teacher/checked.svg" alt="">
          </div>
        </div>
        <div :class="{'d-none':checkedPerfil}">
          <div class="d-flex mt-7">
            <h6 class="my-auto">Perfil Incompleto</h6>
            <img class="ml-2" src="/assets/images/perfil_teacher/incomplete.svg" alt="">
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-7 col-xl-8 pl-0 pt-0">
      <div class="box-account ml-md-8">
        <div class="d-flex ml-8">
          <h5>Cuenta</h5>
          <button @click="editAccount()" class="ml-auto mr-5">{{btnTxt2?'Editar':'Guardar'}}</button>
        </div>
        <hr class="w-100">
        <div v-show="btnTxt2" class="row mt-5 ml-8">
          <div class="col-12 col-lg-6 pl-0">
            <h6>Email</h6>
            <input :value="email" type="email" readonly>
          </div>
          <div class="col-12 col-lg-6 pl-0">
            <h6>Contraseña</h6>
            <input :value="password" type="text" readonly>
          </div>
        </div>
        <div :class="{'d-none':btnTxt2}" class="row mt-5 ml-8">
          <div class="col-12 col-lg-6 pl-0 mb-4">
            <h6>Email</h6>
              <input v-model="email" type="email" name="email" id="emailTeacherProfile" :rules="emailRules"
                           readonly ref="emailTeacherAccount">
          </div>
          <div class="col-12 col-lg-6 pl-0 mb-4">
            <h6>Contraseña</h6>
              <input v-model="password" type="text" name="password" id="passwordTeacherProfile"
                            :rules="passwordRules" ref="passwordTeacherAccount"/>
          </div>
        </div>
      </div>
      <div class="box-bio ml-md-8">
        <div class="d-flex ml-8">
          <h5>Biografía</h5>
          <button @click="editBio()" class="ml-auto mr-5">{{btnTxt3?'Editar':'Guardar'}}</button>
        </div>
        <hr class="w-100 mb-3">
        <div v-show="btnTxt3" class="ml-8">
          <h6>Cuenta algo sobre ti</h6>
          <v-textarea
            v-model="bio"
            no-resize
            readonly
            height="120"
            rows="4"
            flat
            solo
          ></v-textarea>
        </div>
        <div :class="{'d-none':btnTxt3}" class="ml-8">
          <h6>Cuenta algo sobre ti</h6>
          <v-textarea
            counter
            v-model="bio"
            :rules="rules"
            no-resize
            outlined
            color="#29c0d3"
            autofocus
            height="120"
            rows="4"
          ></v-textarea>
        </div>
      </div>
    </div>
</div>
<CashTeacher v-show="cash" />
</div>
</template>

<script>
import Event from '../../event.js';
import CashTeacher from './CashTeacher'
import {UpdateObject,UpdateObjectApi} from '../../axios-services'

export default {
components: {
  CashTeacher
},
data () {
  return {
      about: true,
      cash: false,
      btnTxt1: true,
      btnTxt2: true,
      btnTxt3: true,
      name: '',
      surname: '',
      phone: '',
      cv: '',
      email: '',
      password: '*******',
      bio: '',
      rules: [v => v.length <= 1400 || 'Máx 1400 caracteres'],
      passwordRules: [v => (v || '').length >= 8 || 'Min 8 caracteres'],
      emailRules: [
          v => !!v || 'Correo electronico es requerido',
          v => /.+@.+\..+/.test(v) || 'El email debe ser válido',
      ],
      checkedPerfil: true,
  }
},
mounted() {
    let vm=this
  Event.$on('cashActive' ,()=> {this.cash=true;this.about=false;this.btnTxt1=true,this.btnTxt2=true,this.btnTxt3=true})
    Event.$on('aboutActive', () => {
        this.cash = false;
        this.about = true;
    })
    Event.$on('perfil-teacher', ({user, url}) => {
        vm.name = user.name
        vm.surname = user.last_name
        vm.phone = user.phone
        vm.email = user.email
        vm.bio = user.teachers.bio
        vm.cv = user.teachers.cv_rrss_url
        vm.checkedPerfil = user.teachers.is_verified
    })
},
    computed: {
        formAccount() {
            return {
                password: this.password,
            }
        },
        formBioTeacher() {
            return {
                bio: this.bio
            }
        },
        formAboutUser(){
            return {
                name: this.name,
                last_name:this.surname,
                phone: this.phone
            }
        },
        formAboutTeacher(){
            return{
                cv_rrss_url: this.cv
            }
        }
    },
    methods: {
        editAbout() {
            this.btnTxt1 = !this.btnTxt1;
            this.$refs.nameInput.autofocus = true;
            if (this.btnTxt1 === true) {
                UpdateObject(`mi-perfil/${this.$route.params.id}`, this.formAboutUser, (error, data) => {

                })
                UpdateObjectApi(`teachers/${this.$route.params.id}`, this.formAboutTeacher, (error, data) => {
                    if(data){

                    }
                })
            }
        },

        editAccount() {
            let vm = this
            console.log(this.btnTxt2)
            this.btnTxt2 = !this.btnTxt2;
            if (this.btnTxt2 === true) {
                Object.keys(vm.formAccount).forEach(f => {
                    const refSection = 'TeacherAccount'
                    //this.$refs[f + refSection].validate()
                    console.log(this.$refs, f + refSection, this.$refs['passwordTeacherAccount'], vm.formAccount)
                })
                UpdateObject(`mi-perfil/${this.$route.params.id}`, vm.formAccount, (error, data) => {

                })
                this.password = '*******'
            } else {
                this.password = ''
            }
        },
        editBio() {
            this.btnTxt3 = !this.btnTxt3;
            if (this.btnTxt3 === true) {
                UpdateObjectApi(`teachers/${this.$route.params.id}`, this.formBioTeacher, (error, data) => {
                    if(data){

                    }
                })
            }
        },
    }
}
</script>

<style scoped>
.info-perfil-container{
  margin-left: 10%;
  margin-right: 10%;
  margin-bottom: 100px;
}

.box-about {
  min-width: 350px;
  height: 451px;
  margin-top: 50px;
  padding: 26px 0 29px;
  border-radius: 12px;
  box-shadow: 0 4px 18px 0 rgba(0, 0, 0, 0.15);
  background-color: #ffffff;
}

.box-account {
  height: 173px;
  margin-top: 50px;
  padding: 26px 0 44px;
  border-radius: 12px;
  box-shadow: 0 4px 18px 0 rgba(0, 0, 0, 0.15);
  background-color: #ffffff;
}

.box-bio {
  height: 248px;
  margin-top: 32px;
  padding: 26px 0 44px;
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
  max-width: 290px;
}

input[readonly]{
    border-bottom:none !important;
}

@media  (max-width: 1000px) {
  .box-account{
    height: auto;
    min-width: 350px;
  }

  .box-bio{
    height: auto;
    min-width: 350px;
  }
}
</style>

<style >
.v-textarea{
  font-family: 'Poppins';
  font-size: 16px;
  font-weight: 400;
  color:#343a40;
  max-width: 850px;
}

.v-input__slot{
  padding-left: 0px !important;
}

textarea#input-23{
  padding-left: 12px !important;
}

.v-input.v-textarea>.v-input__control{
  margin-right: 20px;
  margin-top: 4px;
}
</style>


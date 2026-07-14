<template>
  <div class="form-categories pt-0">
      <h5 v-show="viewType=='summer'" class="pop16">
            ¡Registrate y obtén 
            <br class="d-sm-none">
            tu matrícula GRATIS!
      </h5>
      <h2 v-show="viewType=='winter'" class="pop16">Déjanos tu contacto y disfruta del <span class="bf-text"><b>10%</b>  dto en todos los cursos <b>Campus Navidad</b></span></h2>
      <hr v-show="viewType=='winter' || viewType=='summer'">
      <div class="row">
            <div class="col-12 col-md-6">
                <label for="emailRegister" class="mb-0 pl-4 h7-txt">E-mail</label>
                <div class="pl-4 pt-0 pr-4">
                    <v-text-field
                        :id="`email${categoryModal}`"
                        v-model="email"
                        :ref="`email${categoryModal}`"
                        :rules="emailRules"
                        placeholder="ejemplo@email.com"
                        required
                        outlined
                        dense
                       v-bind:class="[errorEmail?'is-invalid':'']"
                        color="#5c2767"
                        class="input-landing"
                        @input="emailUpdate"
                    ></v-text-field>
                </div>
            </div>

            <div class="col-12 col-md-6">
                <label for="phone" class="mb-0 pl-4 h7-txt">Teléfono</label>
                <div class="pl-4 pt-0 pr-4">
                    <v-text-field
                        :id="`phone${categoryModal}`"
                        :ref="`phone${categoryModal}`"
                        v-model="phone"
                        :rules="phoneRules"
                        placeholder="ej. +34668123456"
                        required
                        outlined
                        dense
                        color="#5c2767"
                        class="input-landing"
                        @input="phoneUpdate"
                    ></v-text-field>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-6">
                <label for="name" class="mb-0 pl-4 h7-txt">Nombre</label>
                <div class="pl-4 pt-0 pr-4">
                    <v-text-field
                        :id="`name${categoryModal}`"
                        :ref="`name${categoryModal}`"
                        v-model="name"
                        :rules="[v => !!v || 'Nombre es requerido']"
                        placeholder="Indica tu nombre"
                        outlined
                        dense
                        color="#5c2767"
                        class="input-landing"
                    ></v-text-field>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <label  for="category" class="mb-0 pl-4 h7-txt">Área de interés</label>
                <div class="pl-4 pt-0 pr-4">
                    <select class="input-box pb-2" name="category" :id="idCategory" required="" v-model="categories" @change="changeSelect($event)">
                        <option value="" disabled selected>Elige una área</option>
                        <option value="Educación, metodologías e idiomas">Educación, metodologías e idiomas</option>
                        <option value="Informática, programación y videojuegos">Informática, programación y videojuegos</option>
                        <option value="Robótica e ingeniería industrial">Robótica e ingeniería industrial</option>
                        <option value="Arte digital">Arte digital</option>
                        <option value="Producción audiovisual">Producción audiovisual</option>
                        <option value="Desarrollo de marca y estrategia digital">Desarrollo de marca y estrategia digital</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row mx-auto mt-4">
            <div  class="col-12 col-sm p4-txt text-left">
                Al enviar la información, aceptas la <a :class="{'red-terms':viewType=='winter'}" class="blue-terms" href="/es/politica-de-privacidad">Política de Privacidad</a> <br> y las
                <a :class="{'red-terms':viewType=='winter'}" class="blue-terms" href="/es/terminos-y-condiciones">Condiciones del Servicio</a>
            </div>
            <div class="col-12 col-sm-3 text-right">
                <button
                    :class="{'btn-form-bf':viewType==='winter'}"
                    class="btn-form"
                    @click="send($event)"
                >
                    Enviar
                </button>
                <modal-submit></modal-submit>
            </div>
        </div>
  </div>
</template>

<script>
import Event from '../../event.js';
import {UpdateObjectApi} from "../../axios-services";

export default {
    props:['category','categoryModal','viewType'],
    created(){
        Event.$on('show-modal-card', (category) => {this.categories=category });
        this.categoryModal ? this.idCategory = this.categoryModal : ''
        console.log(this.category,this.categoryModal)
        this.category?this.categories=this.category :this.categories=''
        if(this.category){
            let vm=this.category
            let id=this.categoryModal
            let selectValue={
                target:{
                    value:vm,
                    id:id
                }
            }
            this.changeSelect(selectValue)
        }
    },
    data() {
        return {
            idCategory:'category',email:'',
            phone:'',name:'',course:'',categories:'',
            emailRules: [
            v => !!v || 'Correo electronico es requerido',
            v => /.+@.+\..+/.test(v) || 'El email debe ser válido',
            ],
            phoneRules:[
                v => !!v || 'Debe definir el teléfono',
                v =>/^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/.test(v) || 'Debe definir un teléfono válido'
            ],
            errorEmail:false
        }
    },
    computed: {
        form () {
            return {
                email: this.email,
                phone: this.phone,
                name: this.name,
            }
        },
    },

    methods: {
        changeSelect(event){
            $(".courses").attr("style","display:none");
            $("."+event.target.value).attr("style","display: inherit;");
            console.log("change")
        },
        validEmail: function (email) {
            let re = /.+@.+\..+/;
            return re.test(email);
        },
        validPhone(txtPhone) {
            var a = txtPhone;
            var filter = /^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/;
            if (filter.test(a)) {
                return true;
            } else {
                return false;
            }
        },
        send(event) {
            let vm = this
            Object.keys(this.form).forEach(f => {
                this.$refs[f+vm.categoryModal].validate(true)
            })
            this.errorEmail=false

            console.log(event)
            let emailForm=document.getElementById(`email${this.categoryModal}`)
            let phoneForm=document.getElementById(`phone${this.categoryModal}`)
            let nameForm=document.getElementById(`name${this.categoryModal}`)
            if(this.name==='' || this.email==='' || this.validEmail(this.email)==false || this.phone ==='' || this.validPhone(this.phone)==false){
                Event.$emit('hidden-modal-submit');
                this.modal=false
                if(this.email===''){
                    this.errorEmail=true
                    setTimeout(function () {
                        this.errorEmail=false
                    }, 2000);

                    emailForm.focus();
                } else if(this.phone==='') {
                    phoneForm.focus();
                } else {
                    nameForm.focus();
                }

                console.log("click without change")
            }
            else
            {
                let parameters = {
                    email: vm.email,
                    phone: vm.phone,
                    category: vm.categories,
                    course: vm.course,
                    name: vm.name
                };

                UpdateObjectApi('landing-request',  parameters, (error, data) => {
                    if (error) {
                        console.log(error);
                    } else {
                        Event.$emit('show-modal-submit');
                        Event.$emit('hidden-modal-card');

                        setTimeout(function () {
                            window.location.href = '/es?landingvisitor=true';
                        }, 8000);

                        let slct_category = this.categories;
                        window.gtag('event', 'NewLeadLanding');
                        window.gtag('event', 'conversion', {'send_to': 'AW-589803715/IpI7CPKHpPYBEMPhnpkC'});
                        window.fbq('track', 'newLeadLanding', {category: slct_category})
                    }
                });
            }
        },
        emailUpdate(){
            Event.$emit('emailupdate',this.email)
        },
        phoneUpdate(){
            Event.$emit('phoneupdate',this.phone)
        },
    }
}
</script>

<style scoped>
    h5 {
        font-family: 'Poppins';
        font-size: 16px;
        font-weight: 500;
        color: #5c2767;
        padding-left: 16px;
    }

    .pop16{
        font-family: 'Poppins';
        font-size: 16px;
        font-weight: 500;
        color: #1a1d1f;
        padding-left: 16px;
    }

    .bf-text{
        font-weight: 600;
        color: #e2313f;
    }

    .bf-text>b{
        font-weight: 700;
    }

    .btn-form {
        width: 100px;
        height: 40px;
        border-radius: 4px;
        box-shadow: 0 2px 5px 0 rgba(41, 192, 211, 0.3);
        background-color: #29c0d3;
        font-family: 'Poppins';
        font-size: 16px;
        font-weight: 600;
        color: #ffffff;
    }

    .btn-form-bf {
        border-radius: 4px;
        box-shadow: 0 2px 5px 0 rgba(226, 49, 63, 0.18);
        background-color: #e2313f;
        color: #fff !important;
    }

    .blue-terms {
        color: #29c0d3;
        font-weight: 500;
    }

    .red-terms {
        color: #e2313f !important;
    }

    .input-landing {
        width: 100%;
        height: 40px;
    }

    .form-categories {
        width: 100%;
        height: auto;
        padding: 25px;
    }

    select:required:invalid {
        color: gray;
    }
    option[value=""][disabled] {
        display: none;
    }
    option {
        color: black;
    }
    select:disabled {
    color: #000;
    }

    select {
        border-style: inset;
        outline-color: #989897;
    }

    select:focus {
        border-style: inset;
        outline-color: #29c0d3;
    }

    .border-bf{
        border: solid 1px #1a1d1f;
        opacity: .6;
    }

    select {
        background-image: url("/assets/images/icons/arrow_black.svg");
        background-repeat: no-repeat;
        background-position-x: 95%;
        background-position-y: 15px;
    }

    @media  (max-width: 800px) {
        .form-categories {
            height: 100%;
            opacity: 1;
        }
    }
</style>

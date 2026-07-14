<template>
<v-card max-width="406" height="auto" style="overflow-y:auto !important; overflow-x: hidden;">
<div class="modal-teacher pt-2 pb-7">
    <div class="col-12">
        <div class="row">
            <div class="col-12 p-0">
                <div class="d-flex justify-content-end">
                    <v-btn text icon :class="closeIcon" @click="closeModal(),closeForm()">
                            <v-icon>{{ mdiClose }}</v-icon>
                    </v-btn>
                </div>
                <div class="d-flex pb-3 pt-0 pl-8 pr-3">
                    <h1 class="title-modal my-auto">Únete a la comunidad de profesores</h1>
                </div>
                <hr class="col-10 mx-auto pt-0 pb-0 mt-0 mb-0">
                <div class="modal-body pb-0">
                    <div class="row">
                        <label :for="`nameRegister${id}`" class="pb-0 pl-4 h7-txt mb-1">Nombre</label>
                        <div class="col-12 pl-4 pt-0 pr-4 pb-0">
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

                    <div class="row">
                        <label :for="`phoneRegister${id}`" class="pb-0 pl-4 h7-txt mb-1">Teléfono</label>
                        <div class="col-12 pl-4 pt-0 pr-4 pb-0">
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
                            ></v-text-field>
                        </div>
                    </div>

                    <div class="row">
                        <label :for="`emailRegister${id}`" class="pb-0 pl-4 h7-txt mb-1">E-Mail</label>
                        <div class="col-12 pl-4 pt-0 pr-4 pb-0">
                            <v-text-field
                                :id="`email${categoryModal}`"
                                :ref="`email${categoryModal}`"
                                v-model="email"
                                :rules="emailRules"
                                placeholder="ejemplo@email.com"
                                required
                                outlined
                                dense
                                color="#5c2767"
                                class="input-landing"
                            ></v-text-field>
                        </div>
                    </div>
                    <div class="row">
                        <label  for="category" class="mb-0 pl-4 h7-txt mb-1">Área de interés</label>
                        <div class="pl-4 pt-0 pr-4">
                            <select class="input-box pb-2" name="category" :id="category" required="" v-model="category">
                                <option value="" disabled selected>Área que te interese enseñar</option>
                                <option value="Escuela y Modelo HSTEAM">Escuela y Modelo HSTEAM</option>
                                <option value="Informática, programación y videojuegos">Informática, programación y videojuegos</option>
                                <option value="Robótica e ingeniería industrial">Robótica e ingeniería industrial</option>
                                <option value="Arte digital">Arte digital</option>
                                <option value="Producción audiovisual">Producción audiovisual</option>
                                <option value="Desarrollo de marca y estrategia digital">Desarrollo de marca y estrategia digital</option>
                            </select>
                        </div>
                    </div>
                    <div :class="termsAlert?'mb-1':'mb-6'" class="mt-5 ml-1">
                        <div class="p4-txt text-muted">
                        <input v-model="terms" class="mr-2 cursor-pointer" type="checkbox" id="info" required @change="terms?termsAlert=false:termsAlert=true">He leído y acepto los <a href="/es/terminos-y-condiciones">Términos y Condiciones</a>, así como la <a href="/es/politica-de-privacidad">Política de Privacidad</a>.
                        <span v-show="termsAlert" class="error-checkbox-terms pl-3">
                            Debe aceptar los Términos y Condiciones.
                        </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 pl-4 pr-4">
                            <button v-html="innerButton" class="btn-register" @click="send($event),terms?'':termsAlert=true"></button>
                            <modal-submit :is-teacher='true'></modal-submit>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</v-card>
</template>

<script>
    import { mdiClose } from '@mdi/js';
    import {UpdateObject,UpdateObjectApi} from "../../axios-services";
    import Event from '../../event.js';
    export default {
        props:['closeIcon','id','categoryModal'],
        data() {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                name:'',
                email:'',
                phone:'',
                category:'',
                terms:false,
                termsAlert: false,
                phoneRules:[
                    v => !!v || 'Debe definir el teléfono',
                    v =>/^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/.test(v) || 'Debe definir un teléfono válido'
                ],
                emailRules: [
                    v => !!v || 'Correo electronico es requerido',
                    v => /.+@.+\..+/.test(v) || 'El email debe ser válido',
                ],
                innerButton:'Enviar solicitud',
                mdiClose
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
        methods:{

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
                if(this.name==='' || this.email==='' || this.phone ==='' || this.terms === false){
                    this.modal=false
                    if(this.email===''){
                        emailForm.focus();
                    } else if(this.phone==='') {
                        phoneForm.focus();
                    } else {
                        nameForm.focus();
                    }
                    console.log("click without change")
                }
                else {
                    let parameters = {
                        email: vm.email,
                        phone: vm.phone,
                        category: vm.category,
                        name: vm.name,
                    };
                    Event.$emit('closeModal');
                    Event.$emit('show-modal-submit');
                    setTimeout(function () {
                        window.location.href = '/es?newteacher=true';
                    }, 8000);
                    console.log(parameters)

                    UpdateObjectApi('landing-teacher-request',  parameters, (error, data) => {
                        if (error) {
                            console.log(error);
                        } else {

                            let slct_category = this.category;
                            window.gtag('event', 'NewLeadTeacher');
                            window.gtag('event', 'conversion', {'send_to': 'AW-589803715/IpI7CPKHpPYBEMPhnpkC'});
                            window.fbq('track', 'newLeadTeacher', {category: slct_category})
                        }
                    });
                }
            },
            closeModal() {
                Event.$emit('closeModal');
            },

            closeForm() {
                Event.$emit('closeForm');
            }
        }
    }
</script>

<style scoped>
    a {
        color: #29c0d3;
        font-weight: 300;
    }

    .modal-teacher{
        max-width: 406px;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 5px 10px 0 rgba(74, 64, 87, 0.2);
        background-color: #ffffff;
    }

    .modal-header {
        border-bottom: none !important;
    }

    .btn-register {
        width: 100%;
        height: 40px;
        padding: 0px 15px;
        border-radius: 4px;
        box-shadow: 0 2px 5px 0 rgba(41, 192, 211, 0.3);
        border: solid 1px #29c0d3;
        background-color: #29c0d3;
        color: white;
        font-family: 'Poppins';
        font-size: 16px;
        font-weight: 600;
    }

    .v-btn::before {
        background-color: transparent;
    }

    .cursor-pointer{
        cursor: pointer;
    }

    .error-checkbox-terms{
        width: 100% ;
        margin-top: .15rem ;
        font-size: 12px ;
        color: #ff5252 ;
        font-family: 'Poppins' ;
        font-weight: 400 ;
    }

    select {
        background-image: url("/assets/images/icons/arrow_black.svg");
        background-repeat: no-repeat;
        background-position-x: 95%;
        background-position-y: 15px;
    }

    select:required:invalid {
        color: gray;
    }
    option[value=""][disabled] {
        display: none;
    }
</style>

<template>
        <div class="modal fade" :id="action" data-backdrop="true" data-keyboard="false" tabindex="-1"
             role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <a id="openModalRegister" data-toggle="modal" data-target="#Register"></a>
            <div class="modal-dialog" :class="{'hidden-boxshadow':modalScroll}">
                <div :class="modalScroll?'col-sm-6':''" class="modal-content col-12 mx-auto pl-sm-4 pr-sm-4 pt-0 pb-0">
                    <div class="row">
                        <div class="col-12 p-0">
                            <div class="modal-header p-4">
                                <div v-show="modalScroll">
                                    <p class="h6-txt pl-2">¡Registrate y obtén tu matrícula GRATIS!</p>
                                    <!--<p class="text-muted h7-txt-light pl-2">Promoción válida hasta el 15 de septiembre</p>-->
                                </div>
                                <div v-show="!modalScroll" class="title-modal" v-text="titleRegister"></div>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="showScroll()">
                                    <v-icon>{{ mdiClose }}</v-icon>
                                </button>
                            </div>
                            <hr class="col-11 mx-auto pt-0 pb-0 mt-0">
                            <div class="modal-body">
                                        <template v-if="textRecommender===false">
                                        </template>
                                        <p :class="{'d-none':modalScroll}" v-if="textRecommender===true" class="text-muted pl-2 mb-4">¡Regístrate para que te podamos recomendar los mejores cursos!</p>
                                        <div class="row">
                                            <div :class="modalScroll?'col-sm-12 pr-sm-4':'col-sm-6 pr-sm-2'" class="col-12 pl-4 pt-0 pr-4 ">
                                                <label for="name" class="pb-0 h7-txt">Nombre completo</label>
                                                <input id="name" type="text"
                                                    class="form-control input-box" name="name"
                                                    value="" required autocomplete="name" autofocus
                                                    v-bind:class="[errorName?'is-invalid':'']"
                                                v-model="name">

                                                <!-- @error('name')-->
                                                <span v-for="(errors,key) in allErrors" :key="key" v-show="allErrors.name" class="invalid-feedback" role="alert">
                                                        <strong v-for="error in errors" :key="error" v-show="key==='name'">{{ error }}</strong>
                                                </span>
                                                <!--@enderror -->
                                            </div>
                                            <div :class="modalScroll?'col-sm-12':'col-sm-6'" class="col-12 pl-4 pt-0 pr-4">
                                                <label for="phone" class="pb-0 h7-txt">Teléfono</label>
                                                <input id="phone" type="tel"
                                                       class="form-control input-box" name="phone"
                                                       value="" required autocomplete="phone" autofocus
                                                       v-bind:class="[errorPhone?'is-invalid':'']"
                                                       v-model="phone">

                                                <!-- @error('name')-->
                                                <span v-for="(errors,key) in allErrors" :key="key" v-show="allErrors.phone" class="invalid-feedback" role="alert">
                                                                <strong v-for="error in errors" :key="error" v-show="key==='phone'">{{ error }}</strong>
                                                        </span>
                                                <!--@enderror -->
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div :class="modalScroll?'col-sm-12 pr-sm-4':'col-sm-6 pr-sm-2'" class="col-12 pl-4 pt-0 pr-4 ">
                                                <label for="emailRegister" class="pb-0 h7-txt">E-Mail</label>
                                                <input id="emailRegister" type="email"
                                                    class="form-control input-box" name="email"
                                                    value="" required autocomplete="email" v-model="email"
                                                    v-bind:class="[errorEmail?'is-invalid':'']">

                                                <!-- @error('email')-->
                                                <span v-for="(errors,key) in allErrors" :key="key" v-show="allErrors.email" class="invalid-feedback" role="alert">
                                                        <strong v-for="error in errors" :key="error" v-show="key==='email'">{{ error }}</strong>
                                                </span>
                                                <!--@enderror -->
                                            </div>
                                            <div :class="modalScroll?'col-sm-12':'col-sm-6'" class="col-12 pl-4 pt-0 pr-4 ">
                                                    <label for="passwordRegister" class="pb-0 h7-txt">Contraseña</label>
                                                    <div class="d-flex">
                                                        <input id="passwordRegister" :type="isVisible?'text':'password'"
                                                            class="input-box"
                                                            name="password" required autocomplete="new-password"
                                                            v-bind:class="[errorPassword?'is-invalid':'']"
                                                            v-model="password">
                                                        <span id="eye" class="input-box">
                                                            <v-icon @click="isVisible = !isVisible">
                                                                {{ isVisible ? mdiEyeOutline : mdiEyeOffOutline }}
                                                            </v-icon>
                                                        </span>
                                                    <!-- @error('password')-->
                                                    </div>
                                                    <span v-for="(errors,key) in allErrors" :key="key" v-show="allErrors.password" class="" :class="key==='password'?'alert-register':''" role="alert">
                                                        <strong v-for="error in errors" :key="error" v-show="key==='password'">{{ error }}</strong>
                                                    </span>
                                                <!--@enderror -->
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 pl-4">
                                            <div class="p4-txt text-muted">
                                            <input v-model="terms" class="mr-2 cursor-pointer" type="checkbox" id="info" @change="terms?termsAlert=false:termsAlert=true" required>He leído y acepto los <a href="/es/terminos-y-condiciones">Términos y Condiciones</a>, así como la <a href="/es/politica-de-privacidad">Política de Privacidad</a>.</div>
                                            <span v-show="termsAlert" class="alert-register">
                                                <strong>Debe aceptar los Términos y Condiciones.</strong>
                                            </span>
                                            </div>
                                            <div class="col-12 p4-txt pl-4 text-muted pt-0">
                                            <input class="mr-2 cursor-pointer" type="checkbox" id="info">Acepto recibir información comercial y ofertas personalizadas, incluso por
                                            medios electrónicos.
                                            </div>
                                        </div>
                                        <!-- <div v-if="errors" class="errors-container alert alert-danger text-danger m-3">
                                            {{errors}}
                                        </div> -->
                                        <div class="row">
                                            <div :class="modalScroll?'col-sm-12':'col-sm-4'" class="col-12 mx-auto pl-4 pr-4">
                                                <button class="change-register change-register-active" @click="register(),terms?'':termsAlert=true">
                                                    Registrarse
                                                </button>
                                            </div>
                                        </div>
                                        <div class="text-center mt-2">
                                            <button type="button" class="info-text purple5c" data-toggle="modal" :data-target="actionLogin" data-dismiss="modal">¿Ya tienes cuenta? Inicia sesión</button>
                                        </div>
                                        <hr class="col-11 mx-auto pt-0 pb-0">
                                        <div class="row justify-content-center mx-auto ">
                                            <div :class="modalScroll?'col-sm-12':'col-sm-5 col-md-4'"  class="col-12">
                                            <div class="box-social w-100 text-center">
                                                <div id="FacebookRegister" class="vertical-align" @click="registerSocial('facebook')">
                                                    <img src="/assets/images/modals/facebook_login.svg" alt="" class="social-logo">
                                                    <span class="h7-txt">Continúa con Facebook</span>
                                                </div>
                                            </div>
                                            </div>
                                            <div :class="modalScroll?'col-sm-12':'col-sm-5 col-md-4'" class="col-12">
                                                <div class="box-social w-100 text-center"  @click="registerSocial('google')" >
                                                    <div class="vertical-align">
                                                        <img src="/assets/images/modals/google_login.svg" alt="" class="social-logo">
                                                        <span class="h7-txt">Continúa con Google</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</template>

<script>
    import { mapActions } from 'pinia';
    import { mdiClose, mdiEyeOutline, mdiEyeOffOutline } from '@mdi/js';
    import vueLazysizes from 'vue-lazysizes';
    import Event from '../../event';
    import { useUserStore } from '../../store/user';
    import {UpdateObject,UpdateObjectApi} from "../../axios-services";

    export default {
        name: "RegisterModal",
        props:['action','id','auth'],
        directives: {
            lazysizes: vueLazysizes
        },
        data() {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                titleRegister:'Registrarse',
                name:'',
                phone:'',
                email:'',
                password:'',
                password_confirmation:'',
                terms:false,
                termsAlert:false,
                errors:'',
                allErrors:'',
                errorName:'',
                errorEmail:'',
                errorPassword:'',
                errorPhone:'',
                phoneRules:[
                    v => !!v || 'Debe definir el teléfono',
                    v =>/^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/.test(v) || 'Debe definir un teléfono válido'
                ],
                actionLogin:'Login',
                role:'Padre',
                isVisible:false,
                textRecommender:false,
                modalScroll:false,
                eventAnalytics:'registroPadre',
                sendSignalOpen: false,
                mdiClose,
                mdiEyeOutline,
                mdiEyeOffOutline
            }
        },

        mounted(){
            this.actionLogin=this.action==='Register'?'#Login':'#LoginPayment'

            Event.$on('modal.recommender',(condition)=>{
                this.textRecommender=condition
            });

            Event.$on('modal.scroll',(condition)=>{
                this.modalScroll=condition
            });
            Event.$on('modal.register.scroll',(condition)=>{
                this.eventAnalytics='registroPadrePopup'
            });
        },
        created() {
            if (window.location.href.indexOf("landingvisitor=true") > 0) {
                this.$cookies.set("hideRegisterModal", true, "1w");
            } else if (
                window.location.pathname==='/es' ||
                window.location.pathname==='/es/nuevas-tecnologias' ||
                window.location.pathname==='/es/campus-de-navidad' ||
                window.location.pathname==='/es/campus-de-semana-santa' ||
                window.location.pathname==='/es/campus-verano' ||
                window.location.pathname.indexOf("es/tech/") > 0
            ) {
                window.addEventListener('scroll', this.onScroll);
            }
        },

        destroyed() {
            window.addEventListener('scroll', this.onScroll);
        },
        methods:{
            ...mapActions(useUserStore, ['eventLoggedInSuccessful']),

            onScroll(event) {
                let positionToOpen = 830;
                if (window.location.pathname==='/es/cursos-anuales') {
                    positionToOpen = 600;
                }
                if (this.sendSignalOpen === false && window.scrollY > positionToOpen) {
                    this.sendSignalOpen = true;

                    let vm = this
                    $('#Register').on('hidden.bs.modal', function (e) {
                        vm.$cookies.set("hideRegisterModal", true, "1w");
                    })

                    this.openModal();
                }
            },

            openModal() {
                if (this.auth===false) {
                    if (!this.$cookies.get('hideRegisterModal')) {
                        this.modalScroll = true;
                        this.textRecommender = true
                        document.getElementById('openModalRegister').click();
                    }
                }
            },

            registerSocial: function(provider){
                console.log(provider)
                let vm=this
                window.open(`/register/${provider}`, '_blank');
            },
            SocialLogin:function(provider,response){
                this.$http.post(`/register/${provider}`, response).then(response => {
                    console.log(response.data)
                }).catch(err => {
                    console.log({err:err})
                })
            },
            register: function () {
                UpdateObject('registro', this.formObj(), async (error, _data) => {
                    this.errors = null;
                    if (error) {
                        let dataError = error.data ? error.data : '';
                        console.log(error)
                        if (error.status === 422) {
                            if (dataError.errors) {
                                this.allErrors=dataError.errors?dataError.errors:'';
                                this.errorEmail = dataError.errors.email ? dataError.errors.email:'';
                                this.errorName = dataError.errors.name ? dataError.errors.name:''
                                this.errorPassword = dataError.errors.password ? dataError.errors.password:'';
                                this.errorPhone = dataError.errors.phone ? dataError.errors.phone:'';
                            }
                            if (dataError.errors && (dataError.errors.email || dataError.errors.name || dataError.errors.password || dataError.errors.phone)) {
                                this.errors = dataError.message ? dataError.message : '';
                            }
                        }
                    } else {
                        if (this.terms === true) {
                            await this.eventLoggedInSuccessful();
                            this.$gtm.push({event: this.getEventAnalyticsName(this.role)})
                            this.reloadPage();
                        }
                    }
                });
            },
            getEventAnalyticsName(){
                if(this.modalScroll){
                    return 'registroPadrePopup';
                }
                return this.eventAnalytics;
            },
            formObj() {
                return {
                    name:this.name,
                    phone:this.phone,
                    email: this.email,
                    password: this.password,
                    password_confirmation: this.password_confirmation,
                    role:this.role,
                    terms:this.terms
                }
            },
            reloadPage() {
                if(this.action==='Register')
                    window.location.reload();
                if(this.action==='RegisterPayment')
                    window.location.href='/es/payment/'+this.id;
            },
            showScroll () {
                document.getElementsByTagName('html')[0].classList.remove("modal-open");
                setTimeout(() =>{
                this.modalScroll= false;},500)
            },
        }
    }
</script>

<style scoped>
    a {
        color: #29c0d3;
        font-weight: 300;
    }

    .modal {
        z-index: 2147483647 !important;
    }

    .modal-header {
        border-bottom: none !important;
    }

    .modal-content{
        border-radius: 10px !important;
    }

    img{
        border-top-left-radius: 10px;
        border-bottom-left-radius: 10px;
    }

    .h6-txt{
        font-weight: 500;
        color: #5c2767;
    }

    .change-register {
        width: 100%;
        height: 40px;
        padding: 0px 15px;
        border-radius: 3px;
        box-shadow: 0 2px 5px 0 rgba(41, 192, 211, 0.3);
        border: solid 1px #29c0d3;
        background-color: white;
        color: #29c0d3;
        font-family: 'Poppins';
        font-size: 16px;
        font-weight: 600;
    }

    .change-register-active {
        background-color: #29c0d3 !important;
        color: white !important;
    }

    .cursor-pointer{
        cursor: pointer;
    }

    .input-box#passwordRegister{
        width: 90%;
        border-right-style: none;
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
    }

    .input-box#eye{
        width: 10%;
        border-left-style: none;
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
    }

    .input-box#eye .v-icon {
        top: -3px;
    }

    .hidden-boxshadow{
        box-shadow:none !important;
    }

    .alert-register{
        width: 100% !important;
        margin-top: .25rem !important;
        font-size: 14px !important;
        font-size: 80% !important;
        color: #dc3545 !important;
    }
</style>

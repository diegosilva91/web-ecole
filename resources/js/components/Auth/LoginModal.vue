<template>
    <!-- <div id="filters" style="background-color:#f3f8fc"> -->
        <!-- Button trigger modal -->


        <!-- Modal -->
        <LazyHydrate when-visible>
        <div class="modal fade" :id="action" data-backdrop="true" data-keyboard="false" tabindex="-1"
             role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content col-12 col-md-7 col-lg-12 pt-0 pb-0">
                    <div class="row">
                        <div class="d-none d-lg-block col-lg-6 p-0">
                            <img v-lazysizes data-src="/assets/images/modals/login.png" alt="" class="h-100">
                        </div>
                        <div class="col-12 col-md-12 col-lg-6 p-0">
                            <div class="modal-header p-4">
                                <div class="title-modal">Iniciar Sesión</div>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="showScroll">
                                    <v-icon>{{ mdiClose }}</v-icon>
                                </button>
                            </div>
                            <hr class="col-10 mx-auto pt-0 pb-0 mt-0">

                                <div class="modal-body">
                                    <!--{{ route('login') }}-->
                                    <form  v-on:submit.prevent>
                                        <!--<input type="hidden" name="_token" v-bind:value="csrf">-->
                                    <!--@csrf
                                    @error('status')-->

                                    <div v-if="errors" class="errors-container alert alert-danger">
                                        {{errors}}
                                    </div>
                                    <!--@enderror-->

                                    <div class="row">
                                        <label for="email" class="pb-0 pl-4 h7-txt">E-Mail</label>

                                        <div class="col-12 pl-4 pt-0 pr-4">
                                            <!--@error('email') is-invalid @enderror value="{{ old('email') }}"-->
                                            <input id="email" type="email" class="input-box" required
                                                    autocomplete="email" autofocus v-bind:class="[errorEmail?'is-invalid':'']"
                                                    v-model="email">

                                            <!--@error('email')-->
                                            <span v-if="errorEmail" class="invalid-feedback" role="alert">
                                                <strong>{{ errorEmail }}</strong>
                                            </span>
                                            <!--@enderror-->
                                        </div>
                                    </div>

                                    <div class="row">
                                        <label for="password"
                                                class="pb-0 pl-4 mt-3 h7-txt">Contraseña</label>

                                        <div class="col-12 pl-4 pt-0 pb-0 pr-4">
                                            <div class="d-flex">
                                                <input id="password" :type="isVisible?'text':'password'" class="input-box"
                                                        :class="errorPassword?'is-invalid':''"
                                                        required autocomplete="off" v-model="password" @keyup.enter="login">
                                                <span id="eye" class="input-box">
                                                    <v-icon @click="isVisible = !isVisible">
                                                        {{ isVisible ? mdiEyeOutline : mdiEyeOffOutline }}
                                                    </v-icon>
                                                </span>
                                            </div>
                                            <span v-if="errorPassword" class="invalid-feedback" role="alert">
                                                <strong>{{ errorPassword }}</strong>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-5 text-left pl-4 pt-1">
                                            <input class="pl-4 cursor-pointer" type="checkbox" name="remember" v-model="remember" id="remember">
                                            <label class="info-text cursor-pointer" for="remember">
                                                Recuérdame
                                            </label>
                                        </div>
                                        <div class="col-7 text-right pt-0 pr-4">
                                            <a class="info-text purple-info" href="/password/reset">¿Olvidaste contraseña?</a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 pl-4 pr-4">
                                            <button class="btn-modals" @click="login">
                                                Acceder
                                            </button>
                                        </div>
                                    </div>
                                    <hr>

                                    <div class="col-12">
                                        <div class="box-social w-100 text-center" @click="registerSocial('facebook')">
                                            <div class="vertical-align">
                                                <img src="/assets/images/modals/facebook_login.svg" alt="" class="social-logo">
                                                <span class="h7-txt">Continúa con Facebook</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="box-social w-100 text-center" @click="registerSocial('google')">
                                            <div class="vertical-align">
                                                <img src="/assets/images/modals/google_login.svg" alt="" class="social-logo">
                                                <span class="h7-txt">Continúa con Google</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-center mt-3">
                                        <button type="button" class="info-text purple5c mt-2" data-toggle="modal" data-target="#Register" data-dismiss="modal">¿Aun no tienes cuenta? Registrate aquí </button>
                                    </div>
                                    </form>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </LazyHydrate>
    <!-- </div> -->
</template>

<script>
import { mapActions, mapStores } from 'pinia';
import { mdiClose, mdiEyeOutline, mdiEyeOffOutline } from '@mdi/js';
import 'lazysizes/plugins/parent-fit/ls.parent-fit';
import LazyHydrate from 'vue-lazy-hydration';
import vueLazysizes from 'vue-lazysizes';
import { useUserStore } from '../../store/user';
import {UpdateObject} from "../../axios-services";

export default {
        props:['action','id'],

        name: "LoginModal",

        components: {
            LazyHydrate
        },

        directives: {
            lazysizes: vueLazysizes
        },

        data() {
            return {
                //csrf token
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                password: '',
                email: '',
                remember: '',
                errors: '',
                errorPassword: '',
                errorEmail: '',
                isVisible:false,
                mdiClose,
                mdiEyeOutline,
                mdiEyeOffOutline
            }
        },

        methods: {
            ...mapActions(useUserStore, ['eventLoggedInSuccessful']),

            async login() {
                UpdateObject('login', this.formObj(), async (error, _data) => {
                    if (error) {
                        console.log(error)
                        if (error.status === 401) {
                            this.errors = !error.status ? '' : error.data.status;
                            this.errorPassword = !error.data.password ? '' : error.data.password;
                            this.errorEmail = !error.data.email ? '' : error.data.email;
                        }else if(error.status=== 302){
                            this.reloadPage()
                        }
                    } else {
                        await this.eventLoggedInSuccessful();
                        this.$gtm.push({ event: 'login' });
                        this.reloadPage();
                    }
                });
            },
            formObj() {
                return {
                    'email': this.email,
                    'password': this.password,
                    'remember': this.remember===false?'':this.remember,
                }
            },
            reloadPage() {
                if(this.action==='Login')
                    window.location.reload();
                if(this.action==='LoginPayment')
                    window.location.href='/es/payment/'+this.id;
            },
            registerSocial: function(provider){
                console.log(provider)
                let vm=this
                /*this.$auth.authenticate(provider).then(response =>{
                    console.log(response)
                    vm.SocialLogin(provider,response)
                }).catch(err => {
                    console.log({err:err})
                })*/
                window.open(`/register/${provider}`, '_blank');
                //window.location.href='/register/'+provider;
                /*UpdateObjectApi(`register/${provider}`,null,(error,data)=>{
                    console.log(data)
                })*/
            },
            SocialLogin:function(provider,response){
                this.$http.post(`/register/${provider}`, response).then(response => {
                    console.log(response.data)
                }).catch(err => {
                    console.log({err:err})
                })
            },
            register: function () {
                UpdateObject('registro', this.formObj(), (error, data) => {
                    if (error) {
                        let dataError = error.data ? error.data : '';
                        console.log(error)
                        if (error.status === 422) {
                            this.errors = dataError.message ? dataError.message:'';
                            if (dataError.errors) {
                                //if (dataError.errors.email)
                                this.allErrors=dataError.errors?dataError.errors:'';
                                console.log(this.allErrors);
                                this.errorEmail = dataError.errors.email ? dataError.errors.email:'';
                                this.errorName = dataError.errors.name ? dataError.errors.name:''
                                this.errorPassword = dataError.errors.password ? dataError.errors.password:'';
                            }
                        }
                    } else {
                        this.$gtm.push({event: 'login'
                        })
                        console.log(data);
                        // alert('Bienvenido a Lifecole!')
                        this.reloadPage();
                    }
                });
            },
            showScroll () {
                document.getElementsByTagName('html')[0].classList.remove("modal-open");
            }
        }
    }
</script>

<style scoped>
    a:hover {
        text-decoration: none !important;
        color: #5c2767 !important;
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

    .cursor-pointer{
        cursor: pointer;
    }

    .input-box#password{
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

    .input-box#eye .v-icon{
        top: -3px;
    }
</style>

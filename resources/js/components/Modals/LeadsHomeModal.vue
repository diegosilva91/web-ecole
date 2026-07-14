<template>
    <div class="modal fade" id="leadsModal" data-backdrop="true" data-keyboard="false" tabindex="-1"
            role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content col-12 col-md-7 col-lg-12 pt-0 pb-0">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-6 p-0">
                        <div class="modal-header pl-4 pr-4 pb-1">
                            <div class="title-modal-leads">
                                ¡Registrate y obtén 
                                <br class="d-sm-none d-md-none d-lg-inline">
                                tu matrícula GRATIS!
                            </div>
                            <div class="d-block d-lg-none">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                        @click="showScroll">
                                    <v-icon>{{ mdiClose }}</v-icon>
                                </button>
                            </div>
                        </div>
                        <hr class="col-10 mx-auto pt-0 pb-0 mt-0">
                        <div class="modal-body pt-0">
                            <div>

                                <div class="row">
                                    <label for="name" class="pb-0 pl-4 h7-txt">Nombre</label>
                                    <div class="col-12 pl-4 pt-0 pr-4">
                                        <input id="name" type="text" class="input-box" required @change="hiddenError1()"
                                                autocomplete="name" autofocus
                                                v-model="name">
                                        <div id="msg-name-error" class="msg-error"></div>
                                    </div>
                                </div>

                                <div class="row">
                                    <label for="email" class="pb-0 pl-4 h7-txt">E-mail</label>
                                    <div class="col-12 pl-4 pt-0 pr-4">
                                        <input id="email" type="email" class="input-box" required
                                                autocomplete="email" autofocus
                                                v-model="email">
                                        <div id="msg-email-error" class="msg-error"></div>
                                    </div>
                                </div>

                                <div class="row">
                                    <label for="phone" class="pb-0 pl-4 h7-txt">Teléfono</label>
                                    <div class="col-12 pl-4 pt-0 pr-4">
                                        <input id="phone" type="phone" class="input-box" required
                                                autocomplete="phone" autofocus
                                                v-model="phone">
                                        <div id="msg-phone-error" class="msg-error"></div>
                                    </div>
                                </div>


                                <div class="row mt-2">
                                    <div class="col-12 h7-txt-light text-dark pl-4 pr-4 pt-0">
                                        <input type="checkbox" name="" id="policy_leads" required
                                                style="vertical-align: middle;" v-model="policy"
                                                oninvalid="this.setCustomValidity('Debe aceptar la Política de Privacidad')"
                                                oninput="setCustomValidity('')"> <label for="policy_leads" class="d-inline">He leido y acepto la <a
                                            class="blue-title" href="/es/politica-de-privacidad">Política de
                                        Privacidad</a> y las <a class="blue-title"
                                                                href="/es/terminos-y-condiciones">Condiciones del
                                        Servicio</a>.</label>
                                        <div id="msg-policy-error" class="msg-error"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 pl-4 pr-4 pt-2">
                                        <button class="btn-modals" @click="send($event)">
                                            ¡Me interesa!
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="img-box d-none d-lg-block col-lg-6 p-0">
                        <img v-lazysizes data-src="/assets/images/modals/modal_leads1.png" alt="" class="h-100">
                        <div class="top-right">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                    @click="showScroll">
                                <v-icon>{{ mdiClose }}</v-icon>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mdiClose } from '@mdi/js';
import 'lazysizes/plugins/parent-fit/ls.parent-fit';
import vueLazysizes from 'vue-lazysizes';
import {UpdateObjectApi} from "../../axios-services";

export default {
    props: ['action', 'id'],
    name: "LoginModal",
    directives: {
        lazysizes: vueLazysizes
    },
    computed:{
        formObj:function (){
            return {
                email: this.email,
                phone: this.phone,
                name: this.name,
            }
        }
    },
    data() {
        return {
            name: '',
            email: '',
            phone: '',
            policy: false,
            mdiClose
        }
    },
    methods: {
        send() {
            if(this.hiddenErrors()){
                UpdateObjectApi('landing-request', this.formObj, (error, data) => {
                    if (error) {
                        console.log(error);
                    } else {
                        $('#leadsModal').modal('hide');
                        $("#modalSubmitLeads").modal();
                        let slct_category = 'home';
                        window.gtag('event', 'NewLeadLanding');
                        window.gtag('event', 'conversion', {'send_to': 'AW-589803715/IpI7CPKHpPYBEMPhnpkC'});
                        window.fbq('track', 'newLeadLanding', {category: slct_category})
                    }
                });
            }
        },
        hiddenError1() {
            let inputValue = document.getElementsByClassName("input-box")[0].value;
            let msgError = document.getElementById("msg-name-error");

            if (inputValue !== '') {
                msgError.classList.add('d-none');
            } else {
                msgError.classList.remove('d-none');
                msgError.textContent = "Nombre es requerido"
                return false;
            }
            return true;
        },

        hiddenError2() {
            let inputValue = document.getElementsByClassName("input-box")[2].value;
            let msgError = document.getElementById("msg-phone-error");

            if (inputValue !== '') {
                msgError.classList.add('d-none');
            } else {
                msgError.classList.remove('d-none');
                msgError.textContent = "Teléfono es requerido";
                return false;
            }

            if (this.validPhone(inputValue)===false) {
                msgError.classList.remove('d-none');
                msgError.textContent = "Debe definir un teléfono válido"
                return false;
            } else {
                msgError.classList.add('d-none');
            }
            return true;
        },

        hiddenError3() {
            let inputValue = document.getElementsByClassName("input-box")[1].value;
            let msgError = document.getElementById("msg-email-error");

            if (inputValue !== '') {
                msgError.classList.add('d-none');
            } else {
                msgError.classList.remove('d-none');
                msgError.textContent = "E-mail es requerido";
                return false;
            }

            if (this.validEmail(inputValue)===false) {
                msgError.classList.remove('d-none');
                msgError.textContent = "El E-mail debe ser válido"
                return false;
            } else {
                msgError.classList.add('d-none');
            }
            return true;
        },

        hiddenError6() {
            let msgError = document.getElementById("msg-policy-error");

            if (this.policy !== false) {
                msgError.classList.add('d-none');
            } else {
                msgError.classList.remove('d-none');
                msgError.textContent = "Aceptar la política de privacidad  es requerido"
                return false;
            }
            return true;
        },

        hiddenErrors(){
            let nameValid =  this.hiddenError1();
            let phoneValid = this.hiddenError2();
            let emailValid = this.hiddenError3();
            let policy = this.hiddenError6();
            return nameValid && phoneValid && emailValid && policy;
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
        validEmail: function (email) {
            let re = /.+@.+\..+/;
            return re.test(email);
        },

        showScroll() {
            document.getElementsByTagName('html')[0].classList.remove("modal-open");
        }
    }
}
</script>

<style scoped>
.modal {
    z-index: 2147483647 !important;
    top:15% !important;
}

.modal-header {
    border-bottom: none !important;
}

.modal-content {
    border-radius: 10px !important;
}

img {
    border-top-right-radius: 10px;
    border-bottom-right-radius: 10px;
    width: 100%;
}

.cursor-pointer {
    cursor: pointer;
}

.input-box#password {
    width: 90%;
    border-right-style: none;
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
}

.input-box#eye {
    width: 10%;
    border-left-style: none;
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
}

.img-box {
    position: relative;
}

.top-right {
    position: absolute;
    top: 10px;
    right: 16px;
}

.modal-dialog {
    max-width: 700px !important;
}

.h7-txt-light {
    font-size: 12px;
}

.blue-title {
    font-weight: 500;
}

.icon-img {
    padding: 8px;
    box-shadow: 0 2px 4px 0 rgba(80, 41, 90, 0.4);
    background-color: #fff;
    color: #793e87;
    border-radius: 50%;
}
.msg-error {
    font-family: 'Poppins';
    font-size: 12px;
    color: #ff5252;
    margin-top: 2px;
    padding-left: 8px;
}
</style>

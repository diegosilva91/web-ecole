<template>
    <div class="container">
        <h3 class="text-center mb-60">¿Cómo continuamos?</h3>
        <div class="row">
            <div class="col-11 col-md-5 my-auto mx-auto text-center">
                <img src="/assets/images/home/contact_home.png" alt="" width="467">
                <div class="d-none d-lg-block">
                    <h4 class="mt-3 text-center">O si lo prefieres puedes llamarnos al <span class="text-purple">+34 633 65 18 56</span>
                    </h4>
                </div>
            </div>
            <div class="col-11 col-md-7 mx-auto">
                <h4><span>Contacta con nuestros asesores</span> y te orientaremos de forma totalmente
                    <span>gratuita</span></h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="single_form">
                                <label class="h7-txt text-dark" for="name">Nombre y Apellidos</label>
                                <input @change="hiddenError1()" class="contact-inputs h7-txt-light text-dark"
                                       type="text" name="name"
                                       v-model="name"
                                       value="">
                                <div class="msg-error"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="single_form">
                                <label class="h7-txt text-dark" for="number">Teléfono</label>
                                <input @change="hiddenError2()" class="contact-inputs h7-txt-light text-dark"
                                       type="text" name="number"
                                       v-model="phone"
                                       value="">
                                <div class="msg-error"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="single_form">
                                <label class="h7-txt text-dark" for="email">E-mail</label>
                                <input @change="hiddenError3()" class="contact-inputs h7-txt-light text-dark"
                                       type="email" name="email"
                                       v-model="email"
                                       value="">
                                <div class="msg-error"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="single_form">
                                <label class="h7-txt text-dark" for="subject">Categoría <span class="text-muted">(Opcional)</span></label>
                                <select class="contact-inputs h7-txt-light text-dark" id="category" type="text"
                                        name="category" oninput="setCustomValidity('')"
                                        v-model="category"
                                        value="">
                                    <option class="h7-txt-light" value="" disabled selected>Seleccione categoría
                                    </option>
                                    <option value="Educación, metodologías e idiomas">
                                        Educación, metodologías e idiomas
                                    </option>
                                    <option value="Informática, programación y videojuegos">
                                        Informática, programación y videojuegos
                                    </option>
                                    <option value="Robótica e ingeniería industrial">
                                        Robótica e ingeniería industrial
                                    </option>
                                    <option value="Arte digital">
                                        Arte digital
                                    </option>
                                    <option value="Producción audiovisual">
                                        Producción audiovisual
                                    </option>
                                    <option value="Desarrollo de marca y estrategia digital">
                                        Desarrollo de marca y estrategia digital
                                    </option>
                                </select>
                                <div class="msg-error"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="single_form">
                                <label class="h7-txt text-dark" for="message">Mensaje</label>
                                <textarea @change="hiddenError5()" class="contact-inputs h7-txt-light text-dark"
                                          name="message" style="height: 101px;" v-model="message">
                                </textarea>
                                <div class="msg-error"></div>
                            </div>
                        </div>
                        <div class="d-lg-flex col-lg-12 pt-0">
                            <div class="col-12 col-lg-8 text-center text-sm-left h7-txt-light text-dark my-auto"><input
                                    type="checkbox" name="" id="policy_contact" required style="vertical-align: middle;" v-model="policy"
                                    ref="policyRef"
                                    oninvalid="setCustomValidity('Debe aceptar la Política de Privacidad')"
                                    oninput="setCustomValidity('')"><label class="ml-2 d-inline" for="policy_contact">Acepto la <a class="blue-title h7-txt"
                                                                                  href="/es/politica-de-privacidad">Política
                                de Privacidad</a> y las <a class="blue-title h7-txt" href="/es/terminos-y-condiciones">Condiciones
                                del Servicio</a>.</label>
                                <div class="msg-error"></div>
                            </div>
                            <div class="col-12 col-lg-4 pr-0">
                                <div class="text-center text-lg-right">
                                    <button class="btn-buy text-light"
                                            style="font-family: 'Poppins'; font-size: 16px; font-weight: 600;width:136px;height:31px;"
                                            @click="contact()">ME INTERESA
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="d-block d-lg-none mx-auto">
                            <h4 class="mt-3">O si lo prefieres puedes llamarnos al <span
                                    class="text-purple">+34 633 65 18 56</span></h4>
                        </div>
                    </div>
                    <div class="alert alert-success mt-20 d-none" role="alert" id ="success-message-home">Mensaje enviado correctamente</div>
            </div>
        </div>
    </div>
</template>

<script>
import {UpdateObject} from "../../axios-services";

export default {

    data: () => ({
        inpt1: document.getElementsByClassName("contact-inputs")[0],
        inpt2: document.getElementsByClassName("contact-inputs")[1],
        inpt3: document.getElementsByClassName("contact-inputs")[2],
        inpt4: document.getElementsByClassName("contact-inputs")[3],
        inpt5: document.getElementsByClassName("contact-inputs")[4],
        email: '',
        name: '',
        phone: '',
        message: '',
        category: '',
        policy: false,
    }),
    computed:{
        formObj:function (){
            return {
                email:this.email,
                name: this.name,
                number: this.phone,
                message: this.message,
                category: this.category
            }
        }
    },
    methods: {

        hiddenError1() {
            let inputValue = document.getElementsByClassName("contact-inputs")[0].value;
            let msgError = document.getElementsByClassName("msg-error")[0];

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
            var inputValue = document.getElementsByClassName("contact-inputs")[1].value;
            var msgError = document.getElementsByClassName("msg-error")[1];

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
            var inputValue = document.getElementsByClassName("contact-inputs")[2].value;
            var msgError = document.getElementsByClassName("msg-error")[2];

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

        hiddenError5() {
            var inptvalue = document.getElementsByClassName("contact-inputs")[4].value;
            var msgerror = document.getElementsByClassName("msg-error")[4];

            if (inptvalue !== '') {
                msgerror.classList.add('d-none');
            } else {
                msgerror.classList.remove('d-none');
                msgerror.textContent = "Mensaje es requerido"
                return false;
            }
            return true;
        },

        hiddenError6() {
            let msgError = document.getElementsByClassName("msg-error")[5];

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
            let messageValid = this.hiddenError5();
            let policy = this.hiddenError6();
            return nameValid && phoneValid && emailValid && messageValid && policy;
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

        contact() {
            if(this.hiddenErrors()){
                UpdateObject('contacto', this.formObj, (error, data) => {
                    if(data){
                        let msgSuccess = document.getElementById("success-message-home");
                        msgSuccess .classList.remove('d-none');
                        setTimeout(function () {
                            msgSuccess .classList.add('d-none');
                        },8000);
                        this.cleanForm();
                        window.gtag('event', 'ContactForm');
                    }
                });
            }
        },
        cleanForm(){
            this.name = '';
            this.email = '';
            this.phone = '';
            this.phone= '';
            this.message = '';
            this.category = '';
            this.policy = false;
        }

    }
}
</script>

<style scoped>
h3 {
    font-weight: 500;
}

h4 {
    font-size: 14px;
    font-weight: 300;
}

h4 > span {
    font-weight: 500;
}

.text-purple {
    color: #793e87;
}

.contact-inputs:focus {
    border-color: #793e87 !important;
}

select {
    background-image: url("/assets/images/icons/arrow_black.svg");
    background-repeat: no-repeat;
    background-position-x: 95%;
    background-position-y: 15px;
}

.msg-error {
    font-family: 'Poppins';
    font-size: 12px;
    color: #ff5252;
    margin-top: 2px;
    padding-left: 8px;
}

</style>

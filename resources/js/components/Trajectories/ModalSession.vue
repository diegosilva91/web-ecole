<template>
    <div>
        <div @click="modal=true;" class="session-info"><img class="mr-2" width="20px" height="13px"
                                                            src="/assets/images/course/icons/email-blue.svg" alt=""/>Solicitar
            sesión informativa
        </div>
        <v-dialog persistent scrollable max-width="930" v-model="modal">
            <v-list height="auto" style="overflow-y:auto !important; overflow-x: hidden;">
                <div class="text-right">
                    <button @click="modal=false;">
                        <img src="/assets/images/modals/close-icon.svg" alt="" class="mr-30 mt-20">
                    </button>
                </div>
                <div class="text-center">
                    <h4 class="title-modal">Solicitud sesión informativa</h4>
                    <p class="h7-txt-light mt-2">Solicita una sesión informativa para que podáis conocer y resolver <br
                            class="d-none d-lg-block"> dudas sobre qué cursos anuales son los más adecuados</p>
                </div>

                <hr>
                <v-list-item>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <label for="emailRegister" class="mb-0 pl-4 h7-txt">Curso solicitado</label>
                            <div class="pl-4 pt-0 pr-4">
                                <h7 class="h7-txt-light">{{ title }}</h7>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="name" class="mb-0 pl-4 h7-txt">Nombre</label>
                            <div class="pl-4 pt-0 pr-4">
                                <v-text-field
                                        id="name"
                                        ref="name"
                                        v-model="name"
                                        :rules="nameRules"
                                        placeholder="Nombre padre/madre/tutor"
                                        required
                                        outlined
                                        dense
                                        color="#29c0d3"
                                        class="input-landing"
                                ></v-text-field>
                                <span v-show="errorName" class="invalid-feedback" role="alert">
                                    <strong>{{ errorName }}</strong>
                                </span>
                            </div>
                        </div>
                    </div>
                </v-list-item>
                <v-list-item>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <label for="emailRegister" class="mb-0 pl-4 h7-txt">Correo</label>
                            <div class="pl-4 pt-0 pr-4">
                                <v-text-field
                                        id="email"
                                        v-model="email"
                                        ref="email"
                                        :rules="emailRules"
                                        placeholder="ejemplo@email.com"
                                        required
                                        outlined
                                        dense
                                        v-bind:class="[errorEmail?'is-invalid':'']"
                                        color="#29c0d3"
                                        class="input-landing"
                                ></v-text-field>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="phone" class="mb-0 pl-4 h7-txt">Teléfono</label>
                            <div class="pl-4 pt-0 pr-4">
                                <v-text-field
                                        id="phone"
                                        ref="phone"
                                        v-model="phone"
                                        :rules="phoneRules"
                                        placeholder="ej. +34668123456"
                                        required
                                        outlined
                                        dense
                                        color="#29c0d3"
                                        class="input-landing"
                                ></v-text-field>
                            </div>
                        </div>
                    </div>
                </v-list-item>
                <v-list-item>
                    <div class="col-12">
                        <label for="msg" class="mb-0 h7-txt">Mensaje</label>
                        <v-textarea
                                id="msg"
                                ref="msg"
                                v-model="msg"
                                :rules="msgRules"
                                outlined
                                dense
                                no-resize
                                color="#29c0d3"
                                class="text-muted"
                                height="200px"
                                hide-details
                        ></v-textarea>
                    </div>
                </v-list-item>
                <br>
                <v-list-item class="row">
                    <div class="col-12 col-md-7">
                        <v-alert
                                dense
                                :icon="mdiInformationOutline"
                                color="#e4f8fa"
                                class="mb-0 ml-3"
                        >
                            Pueden asistir tanto hij@s como adultos. Se recomienda ambos.
                        </v-alert>
                        <div v-if="errors" class="errors-container alert alert-danger">
                            {{ errors }}
                        </div>
                    </div>
                    <div class="col-12 col-md-5 p4-txt pl-6 text-muted">
                        <input class="mr-2 cursor-pointer" type="checkbox" ref="check" id="info" v-model="check"
                               required>He leído y acepto la <a
                            class="link-text" href="/es/politica-de-privacidad">Política de Privacidad</a>.
                        <span v-show="errorCheck" class="" role="alert">
                                    <strong>{{ errorCheck }}</strong>
                            </span>
                    </div>
                </v-list-item>
                <v-list-item>
                    <div class="row mb-5 mt-2">
                        <v-btn
                            class="accent mb-5 ml-auto mr-6"
                            :loading="contactIsLoading"
                            :disabled="contactIsLoading"
                            color="accent"
                            @click="contact"
                        >
                            <span class="font-weight-semibold">Enviar</span>
                        </v-btn>
                    </div>
                </v-list-item>
            </v-list>
        </v-dialog>
        <v-dialog max-width="511" v-model="modal2">
            <v-list>
                <v-list-item>
                    <div class="row">
                        <div class="mx-auto">
                            <img src="/assets/images/icons/checked.svg" alt=""><span class="checked-txt">!Solicitud enviada correctamente!</span>
                        </div>
                    </div>
                </v-list-item>
            </v-list>
        </v-dialog>
    </div>
</template>

<script>
import { mdiInformationOutline } from "@mdi/js";
import {UpdateObject} from "../../axios-services";

export default {
    props: ['title'],
    data: () => ({
        contactIsLoading: false,
        modal: false,
        modal2: false,
        courseTitle: 'Introducción a la programación y creación de videojuegos',
        name: '',
        phone: '',
        email: '',
        msg: '¡Hola! A mi hij@ y a mí nos gustaría asistir a una sesión informativa para tener más información y aclarar algunas dudas. Muchas gracias.',
        check: false,
        nameRules: [
            v => !!v || 'Su nombre es requerido',
        ],
        emailRules: [
            v => !!v || 'Correo electronico es requerido',
            v => /.+@.+\..+/.test(v) || 'El email debe ser válido',
        ],
        phoneRules: [
            v => !!v || 'Debe definir el teléfono',
            v => /^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/.test(v) || 'Debe definir un teléfono válido'
        ],
        msgRules: [v => !!v || 'Debe definir el mensaje'],
        errors: '',
        allErrors: '',
        errorName: '',
        errorEmail: '',
        errorCheck:'',
        mdiInformationOutline
    }),
    computed: {
        formObj() {
            return {
                name: this.name,
                email: this.email,
                subject: this.courseTitle,
                number: this.phone,
                message: this.msg,
            }
        },
    },
    methods: {
        activeValidate() {
            this.$refs.name.validate();
            this.$refs.phone.validate();
            this.$refs.email.validate();
            this.$refs.msg.validate();
            this.$refs.name.focus();
            this.$refs.email.focus();
            this.$refs.phone.focus();
            this.$refs.msg.focus();
            this.$refs.check.focus();
        },
        validate() {
            if (!this.$refs.name.valid) {
                this.$refs.name.focus();
                this.$refs.name.blur();
                return true
            } else if (!this.$refs.email.valid) {
                this.$refs.email.focus();
                this.$refs.email.blur();
                return true
            } else if (!this.$refs.phone.valid) {
                this.$refs.phone.focus();
                this.$refs.phone.blur();
                return true
            } else if (!this.$refs.msg.valid) {
                this.$refs.msg.focus();
                this.$refs.msg.blur();
                return true
            }
            else if (!this.check) {
                this.$refs.check.focus();
                this.errorCheck='Debe aceptar'
                return true
            }
            return false;
        },
        contact: function () {
            this.contactIsLoading = true;
            this.activeValidate()
            if (!this.validate()) {
                UpdateObject('contacto', this.formObj, (error, data) => {
                    if (data) {
                        this.modal = false
                        this.modal2 = true;
                    } else {
                        let dataError = error.data ? error.data : '';
                        if (error.status === 422) {
                            this.errors = dataError.message ? dataError.message : '';
                            this.allErrors = dataError.errors ? dataError.errors : '';
                            this.errorEmail = dataError.errors.email ? dataError.errors.email : '';
                            this.errorName = dataError.errors.name ? dataError.errors.name : '';

                        }
                        this.contactIsLoading = false;
                    }
                })
            } else {
                this.contactIsLoading = false;
            }
        }
    }
}
</script>

<style scoped>
.session-info {
    font-family: 'Open Sans', sans-serif;
    font-size: 16px;
    font-weight: 600;
    color: #29c0d3 !important;
    text-decoration: underline !important;
    cursor: pointer;
}

.title-modal {
    font-family: 'Poppins', sans-serif;
    font-size: 16px;
    font-weight: 500;
    color: #5c2767;
}

.input-landing {
    width: 100%;
    height: 40px;
}

.v-alert {
    font-family: 'Poppins';
    font-size: 12px;
    color: #343a40;
    border-radius: 4px;
}

.link-text {
    color: #29c0d3;
}

.checked-txt {
    font-family: 'Poppins', sans-serif;
    font-size: 16px;
    font-weight: 500;
    color: #343a40;
    margin-left: 10px;
}
</style>

<style>
textarea#msg {
    font-family: 'Poppins';
    font-size: 14px;
    color: #343a40;
    opacity: 0.7;
}
</style>

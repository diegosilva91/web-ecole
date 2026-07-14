<template>
    <div>
        <v-dialog
            max-width="350"
            v-model="modal"
        >
            <v-list class="box">
                <v-list-item>
                    <h4 class="mx-auto">¡Hemos registrado tu solicitud! </h4>
                </v-list-item>
                <hr class="col-10 mx-auto mb-0 mt-0">
                <v-list-item>
                    <h5 class="h7-txt-light mx-auto text-center">{{isTeacher?'Te hemos enviado un correo electrónico (o lo recibirás en breve) con la información sobre los siguientes pasos.':'Gracias por dejarnos tu información. Te contactaremos en un plazo de 24 horas para atender todas tus dudas.'}}</h5>
                </v-list-item>
                <div class="d-flex">
                    <a class="mx-auto" :href="isTeacher?'/es?newteacher=true':'/es?landingvisitor=true'"><button class="submit-btn mx-auto mt-7">¡Genial!</button></a>
                </div>
            </v-list>
        </v-dialog>
    </div>
</template>

<script>
import Event from '../../event.js';

export default {
    props: ['isTeacher'],
    mounted() {
        Event.$on('show-modal-submit', () => {
            this.modal=true;
        });
        Event.$on('hidden-modal-submit', () => {console.log('hidden-modal-submit');this.modal=false;});
    },
    data() {
        return {
            modal: false,
        }
    }
}
</script>

<style scoped>
h4 {
    font-size: 16px;
    font-weight: 500;
    text-align: center;
    color: #1a1d1f;
}

.border-line {
    opacity: 0.33;
    border: solid 1px #1a1d1f;
}

.submit-btn {
    width: 109px;
    height: 40px;
    border-radius: 4px;
    background-color: #29c0d3;
    color: #fff;
    font-family: 'Poppins';
    font-size: 16px;
    font-weight: 600;
}

.box {
    padding: 25px 30px;
}

.v-dialog {
    border-radius: 12px !important;
}
</style>

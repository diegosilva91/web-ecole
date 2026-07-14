<template>
    <v-dialog max-width="642" height="188" v-model="modal">
        <v-list>
            <v-list-item>
                <h5 class="mx-auto text-center mb-10 mt-5" v-html="message"></h5>
            </v-list-item>
            <v-list-item v-if="enableButton">
                <div class="row">
                    <div class="mx-auto">
                        <button class="btn-buy mt-2 mb-5 text-light" @click="actionButton">Volver a la página de inicio</button>
                    </div>
                </div>
            </v-list-item>
            <v-list-item v-if="!enableButton">
                <v-progress-circular
                indeterminate
                color="#5c2767"
                class="mx-auto mb-5"
                ></v-progress-circular>
           </v-list-item>
        </v-list>
    </v-dialog>
</template>

<script>
import Event from "../../event";
export default {
    props:['active'],
    data() {
        return {
            modal: false,
            message: 'Está siendo redirigido a la plataforma de pago seguro.<br /> Por favor, espere.',
            enableButton: false,
        }
    },
    mounted() {
        if(this.active){
            this.modal=true;
            this.message='¡Vaya! Parece que el enlace a este curso ya no esta disponible.';
            this.enableButton= true;
            this.countAction();
        }
        let vm=this;
        Event.$on("openModalPayment", ({message,enable}) => {
            console.log(message,enable)
            vm.message = message
            vm.enableButton = enable
            vm.modal = true
            if(vm.enableButton===true){
                setTimeout(() => {
                    vm.actionButton()
                }, 5000)
            }
        });
    },
    methods: {
        countAction(){
            let vm=this
            setTimeout(() => {
                vm.actionButton()
            }, 5000)
        },
        actionButton(){
            window.location.href = '/es'
        }
    }
};
</script>

<style scoped>
.btn-buy{
    width: 250px;
}
</style>

<style>
.v-dialog {
    border-radius: 12px !important;
}
</style>

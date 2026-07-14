<template>
    <v-dialog persistent max-width="642" height="188" v-model="modal">
        <v-list>
            <v-list-item>
                <h5 class="mx-auto text-center mb-10">{{message}}</h5>
                <div v-if="enableButton" class="d-flex justify-content-center">
                    <button class="btn-reviews mt-10" @click="actionButton">Ir a la página de inicio</button>
                </div>
            </v-list-item>
        </v-list>
    </v-dialog>
</template>

<script>
import Event from "../../event";

export default {
    data() {
        return {
            modal: false,
            message: '¡Opinión enviada correctamente!',
            enableButton: true,
        }
    },
    mounted() {
        let vm=this;
        Event.$on("openModalReviews", ({message,enable}) => {
            console.log(message)
            vm.message = message
            vm.enableButton = enable
            vm.modal = true
            if(!vm.enableButtom){
                setTimeout(() => {
                    vm.actionButton()
                }, 2000)
            }
        });
    },
    methods: {
        actionButton(){
            window.location.href = '/es'
        }
    }
};
</script>

<style>
.v-dialog {
    border-radius: 12px !important;
}
</style>

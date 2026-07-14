<template>
    <div class="box-cash">
        <div class="d-flex ml-8">
            <h5>Tus Notificaciones,<br class="d-block d-sm-none"/> Tus Normas</h5>
        </div>
        <hr class="w-100 mb-10"/>
        <div v-show="btnTxt">
            <div class="mt-5 ml-8">
                <div class="row">
                    <h6 class="col-9">Promociones / Novedades de la Newsletter</h6>
                    <v-switch
                        v-model="promo"
                        inset
                        color="#29c0d3"
                        @change="updatePromo"
                        class="col-2 mt-0"
                    ></v-switch>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {UpdateObject} from "../../axios-services";
import Event from "../../event";

export default {
    data() {
        return {
            btnTxt: true,
            checkbox: true,
            promo: true
        };
    },
    mounted(){
        let vm = this
        Event.$on('perfil-customer', ({user, url}) => {
            vm.promo=!!user.customer.notification_promotions
        })
    },
    computed: {
        formPromo() {
            return {
                notification_promotions: this.promo
            }
        },
    },
    methods: {
        updatePromo() {
            UpdateObject(`mi-perfil/${this.$route.params.id}`, this.formPromo, (error, data) => {

            })
        }
    }
};
</script>

<style scoped>
.box-cash {
    min-width: 350px;
    height: 453px;
    margin-top: 50px;
    margin-bottom: 25px;
    margin-right: 10%;
    padding: 26px 0;
    border-radius: 12px;
    box-shadow: 0 4px 18px 0 rgba(0, 0, 0, 0.15);
    background-color: #ffffff;
}

h5 {
    font-weight: 600;
    text-transform: uppercase;
}

h6 {
    font-size: 16px;
    font-weight: 400;
}

p,
input {
    font-family: "Poppins";
    font-size: 16px;
    font-weight: 400;
    color: #343a40;
    margin-top: 4px;
}

@media (max-width: 600px) {
    .box-cash {
        margin-left: -5%;
        margin-right: auto;
    }
}

@media (max-width: 1200px) {
    .box-cash {
        height: auto;
    }
}
</style>

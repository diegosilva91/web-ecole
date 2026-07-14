<template>
    <v-select
        :items="items"
        v-model="selectPayment"
        dense
        outlined
        @input="changePayment()"
        validate-on-blur
        :append-icon="mdiChevronDown"
        color="#793e87"
        :disabled="!!disabled"
        :filled="!!disabled"
    ></v-select>
</template>

<script>
import { mdiChevronDown } from '@mdi/js';

export default {
    props:['disabled'],
    mounted() {
        let submit = document.getElementById("submit");
        submit.dataset.method='Credit/Debit card';
        if (window.location.href.indexOf("es/cursos-anuales/payment") > -1) {
            this.items = ['Tarjeta de Crédito o Débito','Pago domiciliado (SEPA)'];
        } else {
            this.items = ['Tarjeta de Crédito o Débito','Pago cuenta bancaria', 'PayPal', 'Transferencia Bancaria'];
        }
    },
    data: () => ({
        mdiChevronDown,
        selectPayment: 'Tarjeta de Crédito o Débito',
        items: ['Tarjeta de Crédito o Débito','Pago cuenta bancaria', 'PayPal', 'Transferencia Bancaria'],
    }),
    methods: {
        changePayment(event) {
            let creditCard = document.getElementById("card-element");
            let payPal = document.getElementById("payPal");
            let submit = document.getElementById("submit");
            let submitTransfer = document.getElementById("submit-transfer");
            let transferBank = document.getElementById("transfer-bank");
            let sepaStripe = document.getElementById("sepa-element");

            //CreditCard
            if (this.selectPayment === "Tarjeta de Crédito o Débito") {
                submit.dataset.method = 'Credit/Debit card';
                creditCard.classList.remove('d-none');
                sepaStripe.classList.add('d-none');
            } else {
                creditCard.classList.add('d-none');
            }

            //PayPal
            if (this.selectPayment === "PayPal") {
                payPal.classList.remove('d-none');
                submit.classList.add('d-none');
                sepaStripe.classList.add('d-none');
                creditCard.classList.add('d-none');
            } else {
                payPal.classList.add('d-none');
                submit.classList.remove('d-none');
            }

            //TransferBank
            if (this.selectPayment === "Transferencia Bancaria") {
                transferBank.classList.remove('d-none');
                submitTransfer.classList.remove('d-none');
                submit.classList.add('d-none');
                sepaStripe.classList.add('d-none');
                creditCard.classList.add('d-none');
            } else {
                transferBank.classList.add('d-none');
                submitTransfer.classList.add('d-none');
            }

            if (this.selectPayment === "Pago domiciliado (SEPA)" || this.selectPayment === "Pago cuenta bancaria") {
                submit.dataset.method = 'Sepa';
                sepaStripe.classList.remove('d-none');
                creditCard.classList.add('d-none');
            } else {
                sepaStripe.classList.add('d-none');
            }
        },
    }
}
</script>

<style>
.v-menu__content.theme--light {
    z-index: 2222 !important;
}
</style>
<style scoped>
i {
    color: #793e87 !important;
}
</style>

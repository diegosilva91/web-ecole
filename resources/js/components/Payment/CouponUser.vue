<template>
    <div>
        <input type="hidden" name="promo_code" id="promo_code" v-model="promoCode">
        <input type="hidden" name="secret_intent" id="secret_intent_type" v-model="payment_intent_id">
        <input type="hidden" name="total_price_coupon" id="total_price_coupon" v-model="total_price_coupon">
    </div>
</template>

<script>
import Event from '../../event.js'
import {UpdateObjectApi} from '../../axios-services'
export default {
name: "CouponUser",
    props:['course'],
    data: () => ({
        promoCode: '',
        payment_intent_id:'',
        total_price_coupon:'',
    }),
    mounted() {
        this.course.price_total=this.total_price_coupon
        Event.$on('price_total', (price_total) => {
            this.total_price_coupon=price_total
        })
        Event.$on('promo_code', (promo_code) => {
            console.log("show " + promo_code);
            this.promoCode = promo_code;
        })
        Event.$on('totalPrice_promoCode',(total_price)=>{
            console.log("show total_price_promoCode "+ total_price)
            this.total_price_coupon=total_price
            /*if(this.payment_intent_id!=='')
                UpdateObjectApi(`payment/intent/${this.payment_intent_id}`, {price_total_stripe:total_price}, (error, data) => {
                        if(data)
                            this.payment_intent_id=data.id
                })*/
        })
        Event.$on('payment_intent', (payment_intent) => {
            console.log("show payment_intent " + payment_intent)
            this.payment_intent_id=payment_intent
        })
    }
}
</script>

<style scoped>

</style>

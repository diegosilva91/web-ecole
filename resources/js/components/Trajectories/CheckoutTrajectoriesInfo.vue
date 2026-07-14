<template>
    <div class="col-lg-4 order-lg-2 mb-4">
        <h4 class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-muted">Información del curso</span>
        </h4>

        <CheckoutCourseInfo
            class="mb-5"
            :course="course"
            :price_enrollment="price_enrollment"
            :price_subscription="price_subscription"
            :promoData="promoData"
            :promotion="promotion"
        ></CheckoutCourseInfo>

        <CheckoutPlanInfo
            v-if="courseStorePlanSelected"
            :course="course"
            :planSelected="courseStorePlanSelected"
            :promoData="promoData"
        ></CheckoutPlanInfo>

        <form class="card p-2 mt-2" v-on:submit.prevent>
            <div class="d-flex">
                <input
                    :disabled="!(this.promotion && this.courseStorePlanSelected)"
                    v-model="promoCode"
                    type="text"
                    class="form-control mr-2"
                    placeholder="Cupón de descuento"
                >
                <div class="input-group-append">
                    <v-btn
                        depressed
                        :disabled="!(this.promotion && this.courseStorePlanSelected)"
                        type="submit"
                        @click="sendPromoCode(true)"
                    >Aplicar</v-btn>
                </div>
            </div>
        </form>
        <div class="errors-container alert alert-danger mt-2" :class="couponState1">
            Descuento no aplicado!
        </div>
        <div class="errors-container alert alert-success mt-2" :class="couponState2">
            Descuento aplicado!
        </div>

        <!-- Poner solo checkout Cursos Anuales -->
        <v-alert v-show="price_enrollment"
            class="mt-4"
            dense
            :icon="mdiInformationOutline"
            type="info"
        >
            <span class="text-body-2">La matrícula solo se abonará <span>únicamente</span> en el primer pago para asegurar la plaza.</span>
        </v-alert>
        <v-alert
            class="mt-4"
            dense
            :icon="mdiInformationOutline"
            type="info"
        >
            <span class="text-body-2">Se cobrará el importe del curso todos los meses desde el 28 al 31 de cada mes.</span>
        </v-alert>
    </div>
</template>

<script>
import { mdiInformationOutline } from "@mdi/js";
import { mapActions, mapState, mapWritableState } from 'pinia';
import { useCourseStore } from '../../store/course';
import {UpdateObjectApi} from '../../axios-services'
import Event from '../../event.js';
import {TypeBackCoupon} from '../../Entity/Coupon';
import CheckoutCourseInfo from "../Payment/CheckoutCourseInfo.vue";
import CheckoutPlanInfo from "../Payment/CheckoutPlanInfo.vue";

export default {
    name: "CheckoutTrajectoriesInfo",

    components: {
        CheckoutCourseInfo,
        CheckoutPlanInfo
    },

    props: {
        coupon: {
            type: String,
            default: undefined
        },

        course: {
            type: Object,
            default: () => undefined
        },

        planSelectedId: {
            type: Number,
            default: undefined
        },

        price_enrollment: {
            default: undefined
        },

        price_subscription: {
            type: Object,
            default: () => undefined
        },

        promotion: {
            default: undefined
        },
    },

    mounted() {
        // Set store data
        this.courseStoreCourse = this.course;
        if (this.course.prices_packs) {
            this.courseStorePlanBasic = {
                ...this.courseStorePlanBasic,
                priceAmount: Number(this.course.prices_packs[0].price_subscription),
                priceId: this.course.prices_packs[0].prices_id_stripe_basic,
            };
            this.courseStorePlanLifecooler = {
                ...this.courseStorePlanLifecooler,
                priceAmount: Number(this.course.prices_packs[1].price_subscription),
                priceId: this.course.prices_packs[1].prices_id_stripe_lifecooler,
            };
            this.planSelectedId && this.courseStoreSelectePlan(this.planSelectedId);
        }

        if (this.course.price_total) {
            if (this.totalPrice.trim() && this.totalPrice !== 0 && this.totalPrice < this.course.price_total) {
                Event.$emit('price_total', this.totalPrice);
            } else {
                Event.$emit('price_total', this.course.price_total);
            }
        }
        if (this.coupon !== '') {
            this.promoCode = this.coupon
            this.sendPromoCode()
        }
    },

    data: () => ({
        couponState1: "d-none",
        couponState2: "d-none",
        divNotFound: false,
        promoCode: '',
        promoData: undefined,
        discountCoupon: '',
        disabled: false,
        mdiInformationOutline
    }),

    methods: {
        ...mapActions(useCourseStore, { courseStoreSelectePlan: 'selectePlan' }),

        sendPromoCode() {
            let formObj = null
            if (this.course) {
                formObj = {
                    course_id: this.course.id,
                    type_coupon :  TypeBackCoupon.TYPE_TRAJECTORY
                }
            }
            this.promoCode = this.promoCode.toUpperCase();
            UpdateObjectApi(`coupons/${this.promoCode}`, formObj, (error, data) => {
                if (error || data.error) {
                    if(data.error){
                        console.log(data.error);
                    }
                    this.couponState1 = ""
                    this.couponState2 = "d-none"
                    this.promoDiscount = 0;
                    this.discountCoupon = '';
                    this.promoData = undefined;
                    this.promoCode = '';
                    Event.$emit('promo_code', this.promoCode);
                    Event.$emit('totalPrice_promoCode', this.totalPrice)
                } else {
                    this.couponState2 = ""
                    this.couponState1 = "d-none"
                    this.disabled = true
                    if (data.promo_code === null) {
                        this.couponState1 = ""
                        this.couponState2 = "d-none"
                    }
                    this.promoData = data.promo_code
                    this.promoDiscount = data.promo_code ? data.promo_code.discount : ''
                    Event.$emit('promo_code', this.promoCode);
                    Event.$emit('totalPrice_promoCode', this.totalPrice)
                    if (this.totalPrice) {
                        let text = document.getElementById('price-transfer')
                        text.innerHTML = this.totalPrice + ' €'
                        text.value = this.totalPrice + ' €'
                    } else {
                        let text = document.getElementById('price-transfer')
                        text.innerHTML = this.course.price_total + ' €'
                        text.value = this.course.price_total + ' €'
                    }
                }
            })
        }
    },

    computed: {
        ...mapState(useCourseStore, {
            courseStorePlanSelected: 'planSelected'
        }),

        ...mapWritableState(useCourseStore, {
            courseStoreCourse: 'course',
            courseStorePlanBasic: 'planBasic',
            courseStorePlanLifecooler: 'planLifecooler',
        }),

        totalPrice: function () {
            let total_price = 0
            if (this.course.discount)
                total_price = this.course.price_total - (this.course.price_total * (this.course.discount / 100))
            else
                total_price = this.course.price_total
            return (total_price - this.promoDiscount).toFixed(2)
        },
        promoDiscount: {
            get: function () {
                return this.discountCoupon
            },
            set: function (value) {
                let price_total = 0;
                let price_discount_total = 0;
                if (this.course.discount)
                    price_total = this.course.price_total - (this.course.price_total * (this.course.discount / 100))
                else
                    price_total = this.course.price_total
                if (this.promoData) {
                    if (this.promoData.type === 'percent') {
                        price_discount_total = price_total * (value / 100)
                        this.discountCoupon = price_discount_total
                    } else if (this.promoData.type === 'fixed') {
                        price_discount_total = (value)
                        this.discountCoupon = price_discount_total
                    } else if (this.promoData.type === 'price') {
                        price_discount_total = (value)
                        this.discountCoupon = price_total - price_discount_total
                    } else {
                        this.discountCoupon = 0
                    }
                } else {
                    this.discountCoupon = ''
                }
            }
        }
    },
}
</script>

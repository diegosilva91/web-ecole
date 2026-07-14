import Vue from 'vue';
import { createPinia, PiniaVuePlugin } from 'pinia';
import { useCourseStore } from './store/course'
import Vuetify from 'vuetify';
import {UpdateObject, UpdateObjectApi} from './axios-services'
import Event from './event';
import {Integrations} from "@sentry/tracing";
import {loadStripe} from '@stripe/stripe-js/pure';
import * as Sentry from "@sentry/browser";
import 'vuetify/dist/vuetify.min.css'

require('./bootstrap');

Sentry.init({
    Vue,
    dsn: process.env.MIX_SENTRY_VUE_DNS,
    autoSessionTracking: true,
    integrations: [
        new Integrations.BrowserTracing(),
    ],
    tracingOptions: {
        trackComponents: true,
    },
    logErrors: true,
    // We recommend adjusting this value in production, or using tracesSampler
    // for finer control
    tracesSampleRate: 1.0,
});

// Vue Pinia
Vue.use(PiniaVuePlugin);
const pinia = createPinia();

// Vuetify
Vue.use(Vuetify);
const vuetify = new Vuetify({
    icons: {
        iconfont: 'mdiSvg'
    }
});

Vue.component('nav-bar', () => import(/* webpackChunkName: "dist/js/nav-bar" */'./components/NavBar.vue'));
Vue.component('footer-new', () => import(/* webpackChunkName: "dist/js/footer-new" */'./components/FooterNew.vue'));
Vue.component('coupon-user', () => import(/* webpackChunkName: "dist/js/coupon-user" */  './components/Payment/CouponUser.vue'));
Vue.component('checkout-promotion', () => import(/* webpackChunkName: "dist/js/checkout-promotion" */  './components/Payment/CheckoutPromotion.vue'));
Vue.component('payment-select', () => import(/* webpackChunkName: "dist/js/payment-select" */  './components/Payment/PaymentSelect.vue'));
Vue.component('payment-modal', () => import(/* webpackChunkName: "dist/js/payment-modal" */  './components/Modals/PaymentModal.vue'));
Vue.component('checkout-trajectories-info', () => import(/* webpackChunkName: "dist/js/trajectories/checkout-trajectories-info" */'./components/Trajectories/CheckoutTrajectoriesInfo.vue'));
Vue.component('course-plans-section', () => import(/* webpackChunkName: "dist/js/course-plans-section" */'./components/Course/CoursePlansSection.vue'));
Vue.component('overlay', () => import(/* webpackChunkName: "dist/js/overlay" */'./components/Overlay.vue'));

new Vue({
    el: '#trajectories',
    pinia,
    vuetify
});

const userStore = useCourseStore();

console.log(process.env.MIX_STRIPE_KEY, process.env.STRIPE_KEY)

loadStripe.setLoadParameters({advancedFraudSignals: false});
$(document).ready(function () {

    let purchaseInProcess = false;
    window.addEventListener('beforeunload', function (e) {
        if (purchaseInProcess) {
            e.preventDefault();
            e.returnValue = 'El proceso de compra no ha finalizado. Por favor continua en la página.';
            return 'El proceso de compra no ha finalizado. Por favor continua en la página.';
        }
    });

    let price_total_stripe;
    let promotionIdVal = $("#promotion_id").val()
    let course_id = $("#course_id").val();
    if (!promotionIdVal) {
        document.querySelector("#submit").disabled = true;
    }
    let style = {
        base: {
            color: "#32325d",
            fontFamily: 'Arial, sans-serif',
            fontSmoothing: "antialiased",
            fontSize: "16px",
        },
        invalid: {
            fontFamily: 'Arial, sans-serif',
            color: "#fa755a",
            iconColor: "#fa755a"
        }
    };
    let styleTransferSepa = {
        base: {
            color: '#32325d',
            fontFamily: 'Arial, sans-serif',
            fontSmoothing: "antialiased",
            fontSize: '16px',
            ':-webkit-autofill': {
                color: '#32325d',
            },
        },
        invalid: {
            color: '#fa755a',
            iconColor: '#fa755a',
            ':-webkit-autofill': {
                color: '#fa755a',
            },
        },
    };
    let optionsSepa = {
        style: styleTransferSepa,
        supportedCountries: ['SEPA'],
        placeholderCountry: 'ES',
    };
    let info = " PAYMENT | VALIDATION | PromotionId: " + promotionIdVal + " | Usuario entra en pagina de payment";
    log("DEBUGGING", info);
    Sentry.setTag('info', info);
    Sentry.captureMessage(info)
    Event.$on('price_total', (price_total) => {
        console.log("price_total load " + price_total);
        price_total_stripe = price_total;
        $('#total_price_coupon').val(price_total)
    });
    const cardBrandToPfClass = {
        'visa': 'pf-visa',
        'mastercard': 'pf-mastercard',
        'amex': 'pf-american-express',
        'discover': 'pf-discover',
        'diners': 'pf-diners',
        'jcb': 'pf-jcb',
        'unknown': 'pf-credit-card',
    }
    const setBrandIcon = function (brand) {
        let brandIconElement = document.getElementById('brand-icon');
        let pfClass = 'pf-credit-card';
        if (brand in cardBrandToPfClass) {
            pfClass = cardBrandToPfClass[brand];
        }
        for (let i = brandIconElement.classList.length - 1; i >= 0; i--) {
            brandIconElement.classList.remove(brandIconElement.classList[i]);
        }
        brandIconElement.classList.add('pf');
        brandIconElement.classList.add(pfClass);
    }
    const setCVCIcon = function (setting) {
        let cvcIconElement = document.getElementById('card-element-cvc');
        if (setting === true) {
            cvcIconElement.classList.add('pf-cvc');
        }else{
            cvcIconElement.classList.remove('pf-cvc');
        }
    }

    const stripe = loadStripe(process.env.MIX_STRIPE_KEY)
        .then((result) => {
            let elements = result.elements({locale: 'es'});
            let card = elements.create('cardNumber', {style: style});
            let cardExpiry = elements.create('cardExpiry', {style: style});
            let cardCvc = elements.create('cardCvc', {style: style});
            card.mount("#card-element-number");
            cardExpiry.mount("#card-element-expiry");
            cardCvc.mount("#card-element-cvc");

            let iban = elements.create('iban', optionsSepa);
            iban.mount('#iban-element');
            cardCvc.on("focus", function (event) {
                setCVCIcon(true);
            });
            cardCvc.on("blur", function (event) {
                setCVCIcon(false);
            });
            document.querySelector("#submit").disabled = false;
            card.on("change", function (event) {
                if (event.brand) {
                    setBrandIcon(event.brand);
                }
                if (event.complete) {
                    // enable payment button
                    document.querySelector("#submit").disabled = false;
                } else if (event.error) {
                    // show validation to customer
                    document.querySelector("#submit").disabled = true
                    document.querySelector("#card-error").textContent = event.error ? event.error.message : "";
                }
                // Disable the Pay button if there are no card details in the Element
                document.querySelector("#submit").disabled = event.empty;
                document.querySelector("#card-error").textContent = event.error ? event.error.message : "";
            });
            if (!promotionIdVal) {
                document.querySelector("#submit").disabled = true;
                card.update({disabled: true});
                card.update({
                    style: {
                        empty: {
                            color: "e9ecef", background: "#e9ecef"
                        }
                    }
                })
            }
            // console.log("price", $('#total_price_coupon').val(),price_total_stripe)
            $("#submit").click(function (e) {
                let methodStripe = this.dataset.method;
                e.preventDefault();
                timeOutNoLoading.cancel()
                // log("DEBUGGING", " PAYMENT | VALIDATION | PromotionId: " + promotionIdVal + " | Usuario hace click en botón pago");
                $("#errors").html("");
                $("#errors").hide()
                let validate = validateForm()
                if (validate === true) {
                    loading(true, "#submit");
                    // log("DEBUGGING", " PAYMENT | VALIDATION | PromotionId: " + promotionIdVal + " | JSON para crear promotion purchase | " + JSON.stringify(paymentObject(price_total_stripe)));
                    UpdateObject("payment", paymentObject(price_total_stripe, methodStripe), (error, data_payment) => {
                        if (error) {
                            // log("DEBUGGING", " PAYMENT | VALIDATION | PromotionId: " + promotionIdVal + " | Error al crear promotion purchase | " + error.toString());
                            Sentry.captureMessage(error);
                            showErrors("", false)
                            loading(false, "#submit");
                            console.log("payment", error)
                            if (error.status === 422) {
                                let dataError = error.data ? error.data : ''
                                let errorPayment = dataError.errors.payment ? dataError.errors.payment : '';
                                let errorName = dataError.errors.name ? dataError.errors.name : '';
                                let errorEmail = dataError.errors.email ? dataError.errors.email : '';
                                let errorPhone = dataError.errors.phone ? dataError.errors.phone : '';
                                let assistant_name = dataError.errors['assistant_name[0]'] ? dataError.errors['assistant_name[0]'] : '';
                                let assistant_age = dataError.errors['assistant_age[0]'] ? dataError.errors['assistant_age[0]'] : '';
                                //console.log("error",errorPayment) bus
                                if (errorPayment) {
                                    // log("DEBUGGING", " PAYMENT | VALIDATION | PromotionId: " + promotionIdVal + " | Error al crear promotion purchase | " + errorPayment);
                                    showErrors(errorPayment, true, 'errors')
                                }
                                if (errorName) {
                                    // log("DEBUGGING", " PAYMENT | VALIDATION | PromotionId: " + promotionIdVal + " | Error en el nombre | " + errorName);
                                    showErrors(errorName, true, 'namePayment')
                                }
                                if (errorEmail) {
                                    // log("DEBUGGING", " PAYMENT | VALIDATION | PromotionId: " + promotionIdVal + " | Error en el email | " + errorEmail);
                                    showErrors(errorEmail, true, 'email')
                                }
                                if (errorPhone) {
                                    // log("DEBUGGING", " PAYMENT | VALIDATION | PromotionId: " + promotionIdVal + " | Error en el email | " + errorEmail);
                                    showErrors(errorPhone, true, 'phone')
                                }
                                if (assistant_name) {
                                    showErrors(assistant_name, true, 'assistant_name_0')
                                }
                                if (assistant_age) {
                                    showErrors(assistant_age, true, 'assistant_age_0')
                                }
                            }
                            else if(error.status === 419){
                                alert('Has dejado tu sesión inactiva y se ha cerrado tu sesión, tu página será actualizada')
                                window.location.reload()
                            }
                        } else {
                            timeOutNoLoading.setup(showErrors, log, promotionIdVal)
                            // log("DEBUGGING", " PAYMENT | VALIDATION | PromotionId: " + promotionIdVal + " | PromotionPurchase creado | Datos de promotionPurchase: " + JSON.stringify(data_payment));
                            let secret_intent_type = $('#secret_intent_type').val()
                            console.log('secret_intent_type: ' + secret_intent_type);
                            if (!secret_intent_type.trim()) {
                                UpdateObjectApi("trajectories/subscriptions-intent", paymentObject(data_payment.promotionPurchasePayment.total_price, methodStripe), (error, data) => {
                                    if (data) {
                                        // log("DEBUGGING", " PAYMENT | VALIDATION | PromotionId: " + promotionIdVal + " | Payment_intent creado | PaymentIntent: " + data.id);
                                        Event.$emit('payment_intent', data.id)
                                        data.clientSecret = data.client_secret
                                        console.log("data.clientSecret", data.clientSecret)
                                        console.log("payment created", data_payment)
                                        console.log("methodStripe", methodStripe)
                                        //confirmar pago
                                        if (methodStripe === 'Sepa') {
                                            payWithSepa(result, iban, data.clientSecret, data_payment.promotionPurchase, data.customer, data.subscriptionId, data.id)
                                        } else {
                                            payWithCard(result, card, data.clientSecret, data_payment.promotionPurchase, data.customer, data.subscriptionId, data.id);
                                        }
                                        // Complete payment when the submit button is clicked
                                    } else {
                                        // log("DEBUGGING", " PAYMENT | VALIDATION | PromotionId: " + promotionIdVal + " | No creó el paymentIntent | error: " + error);
                                        loading(false, "#submit")
                                        Sentry.captureMessage("Something went wrong in payment info")
                                    }
                                });
                            } else {
                                UpdateObjectApi(`trajectories/subscriptions-intent/${secret_intent_type}`, paymentObject(data_payment.promotionPurchasePayment.total_price, methodStripe), (error, data) => {
                                    if (data) {
                                        // log("DEBUGGING", " PAYMENT | VALIDATION | PromotionId: " + promotionIdVal + " | Payment_intent actualizado | PaymentIntent: " + data.id);
                                        Event.$emit('payment_intent', data.id)
                                        data.clientSecret = data.client_secret
                                        console.log("data.clientSecret", data.clientSecret)
                                        console.log("payment updated", data_payment)
                                        console.log("methodStripe", methodStripe)
                                        if (methodStripe === 'Sepa') {
                                            payWithSepa(result, iban, data.clientSecret, data_payment.promotionPurchase, data.customer, data.subscriptionId, data.id)
                                        } else {
                                            payWithCard(result, card, data.clientSecret, data_payment.promotionPurchase, data.customer, data.subscriptionId, data.id);
                                        }
                                        // Complete payment when the submit button is clicked
                                    } else {
                                        // log("DEBUGGING", " PAYMENT | VALIDATION | PromotionId: " + promotionIdVal + " | No creó el paymentIntent | error: " + error);
                                        loading(false, "#submit")
                                        Sentry.captureMessage("Something went wrong in payment info")
                                    }
                                });
                            }
                        }
                    })
                }
            });
        })
        .catch((error) => {
            // log("DEBUGGING"," PAYMENT | VALIDATION | PromotionId: " + promotionIdVal + " | Stripe no se ha cargado correctamente"+ error);
            console.log("Stripe no carga")
            console.log(error)
        });

    let validateForm = function () {
        let email = $("#emailPayment").val();
        let name = $("#namePayment").val();
        let phone = $('#phonePayment').val();

        let assistant_name = $("#assistant_name_0").val();
        let assistant_age = $("#assistant_age_0").val();
        if ($("#sons_group input[type='radio']:checked").val() !== 'new' && $("#sons_group input[type='radio']:checked").val() !== undefined) {
            assistant_name = 'something';
            assistant_age = 'something';
        }

        let password = $("#passwordPayment").val();
        if ($("#passwordPayment").attr("type") === "hidden") {
            password = 'password'
        }

        if (!name.trim()) {
            let errorName = 'Debes indicar el nombre'
            $("#namePayment").focus()
            showErrors(errorName, true, 'namePayment')
            // log("DEBUGGING"," PAYMENT | VALIDATION | PromotionId: " + promotionIdVal + " | Usuario con nombre vacío");
            return false;
        } else if (!isEmail(email)) {
            let errorEmail = 'Debes indicar el email'
            $("#emailPayment").focus()
            showErrors(errorEmail, true, 'emailPayment')
            // log("DEBUGGING"," PAYMENT | VALIDATION | PromotionId: " + promotionIdVal +" | Usuario con email vacío");
            return false;
        } else if (!password.trim()) {
            let errorPassword = 'Debes indicar la contraseña'
            $("#passwordPayment").focus()
            showErrors(errorPassword, true, 'passwordPayment')
            // log("DEBUGGING"," PAYMENT | VALIDATION | PromotionId: " + promotionIdVal +" | Usuario con contraseña vacío");
            return false;
        } else if (password.trim().length < 8) {
            let errorPassword = 'La contraseña debe ser mayor a 8 caracteres'
            $("#passwordPayment").focus()
            showErrors(errorPassword, true, 'passwordPayment')
            // log("DEBUGGING"," PAYMENT | VALIDATION | PromotionId: " + promotionIdVal +" | Usuario con contraseña vacío");
            return false;
        } else if (!phone.trim()) {
            let errorPhone = 'Debes indicar el teléfono'
            $("#passwordPhone").focus()
            showErrors(errorPhone, true, 'phonePayment')
            // log("DEBUGGING"," PAYMENT | VALIDATION | PromotionId: " + promotionIdVal +" | Usuario con contraseña vacío");
            return false;
        } else if (!isPhone(phone)) {
            let errorPhone = 'Debes indicar el teléfono con un formato válido (XXXXXXXXX ó +XX-XXXXXXXXX)'
            $("#phonePayment").focus()
            showErrors(errorPhone, true, 'phonePayment')
            // log("DEBUGGING"," PAYMENT | VALIDATION | PromotionId: " + promotionIdVal +" | Usuario con email vacío");
            return false;
        } else if (!assistant_name.trim()) {
            let errorAssistanName = 'Debes indicar el nombre de tu hij@'
            $("#assistant_name_0").focus()
            showErrors(errorAssistanName, true, 'assistant_name_0')
            // log("DEBUGGING"," PAYMENT | VALIDATION | PromotionId: " + promotionIdVal + "| Usuario con campo del hijo vacío");
            return false;
        } else if (!assistant_age.trim() && !$.isNumeric(assistant_age)) {
            let errorAssistanAge = 'Debes indicar la edad de tu hij@'
            $("#assistant_age_0").focus()
            showErrors(errorAssistanAge, true, 'assistant_age_0')
            // log("DEBUGGING"," PAYMENT | VALIDATION | PromotionId: " + promotionIdVal + "| Usuario con campo de la edad del hijo vacío");
            return false;
        } else if (!$('#policy').is(":checked")) {
            let errorPolicy = 'Tienes que aceptar nuestros términos y condiciones'
            $('#policy').focus()
            showErrors(errorPolicy, true, 'policy')
            // log("DEBUGGING"," PAYMENT | VALIDATION | PromotionId: " + promotionIdVal +"| Usuario con campo de checking de términos y condiciones sin marcar");
            return false
        } else {
            log("DEBUGGING", " PAYMENT | VALIDATION | PromotionId: " + promotionIdVal + " | El usuario ha pasado todas las validaciones de formulario | nombre: " + name + " , email:" + email + ",contraseña: " + password +
                ",nombre_hijo: " + assistant_name + ",edad_hijo: " + assistant_age + ",checking_terminos: " + true);
            return true
        }
    }
    let isEmail = function (email) {
        let regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if (!regex.test(email)) {
            return false;
        } else {
            return true;
        }
    }
    let isPhone = function (phone) {
        let regex = /^(1[ \-\+]{0,3}|\+1[ -\+]{0,3}|\+1|\+)?((\(\+?1-[2-9][0-9]{1,2}\))|(\(\+?[2-8][0-9][0-9]\))|(\(\+?[1-9][0-9]\))|(\(\+?[17]\))|(\([2-9][2-9]\))|([ \-\.]{0,3}[0-9]{2,4}))?([ \-\.][0-9])?([ \-\.]{0,3}[0-9]{2,4}){2,3}$/;
        if (!regex.test(phone)) {
            return false;
        } else {
            return true;
        }
    }

    let paymentObject = function (price, method) {
        if (!method) {
            method = 'Credit/Debit card';
        }
        let password = $('#passwordPayment').val()
        let total_price_coupon = $('#total_price_coupon').val()
        console.log("total_price_coupon" + total_price_coupon, "price_total_stripe" + price_total_stripe, "price " + price)
        if (total_price_coupon === '')
            price_total_stripe = total_price_coupon
        if (!price_total_stripe || price_total_stripe === '' || total_price_coupon === '')
            total_price_coupon = price
        console.log("total price with coupon" + total_price_coupon, "assitan_name_0 " + $("#assistant_name_0").val(), "course_id" + $("#course_id").val(), "promotion_id " + $("#promotion_id").val(), "secret_intent " + $('#secret_intent_type').val())
        if (password) {
            return {
                promotion_id: $("#promotion_id").val(),
                course_id: $("#course_id").val(),
                email: $('#emailPayment').val(),
                password: password,
                name: document.getElementById('namePayment').value,
                phone: $('#phonePayment').val(),
                'assistant_name[0]': $("#assistant_name_0").val(),
                'assistant_age[0]': $('#assistant_age_0').val() ? parseInt($('#assistant_age_0').val()) : $('#assistant_age_0').val(),
                add_son: ($("#sons_group input[type='radio']:checked").val() === undefined) ? "new" : $("#sons_group input[type='radio']:checked").val(),
                secret_intent:$('#secret_intent_type').val(),
                promo_code: $('#promo_code').val(),
                price_total_stripe: total_price_coupon,
                price_id: userStore.planSelected.priceId,
                pack_id: userStore.planSelected.id,
                price_enrollment_id: ($('#price_enrollment_id').val()).trim ? $('#price_enrollment_id').val() : null,
                payment_method: method,
            }
        } else {
            return {
                promotion_id: $("#promotion_id").val(),
                course_id: $("#course_id").val(),
                email: $('#emailPayment').val(),
                name: document.getElementById('namePayment').value,
                phone: $('#phonePayment').val(),
                'assistant_name[0]': $("#assistant_name_0").val(),
                'assistant_age[0]': $('#assistant_age_0').val() ? parseInt($('#assistant_age_0').val()) : $('#assistant_age_0').val(),
                add_son: ($("#sons_group input[type='radio']:checked").val() === undefined) ? "new" : $("#sons_group input[type='radio']:checked").val(),
                secret_intent:$('#secret_intent_type').val(),
                promo_code: $('#promo_code').val(),
                price_total_stripe: total_price_coupon,
                price_id: userStore.planSelected.priceId,
                pack_id: userStore.planSelected.id,
                price_enrollment_id: ($('#price_enrollment_id').val()).trim ? $('#price_enrollment_id').val() : null,
                payment_method: method
            }
        }
    }

    // Calls stripe.confirmCardPayment
    // If the card requires authentication Stripe shows a pop-up modal to
    // prompt the user to enter authentication details without leaving your page.
    var payWithCard = function (stripe, card, clientSecret, dataUserPayment, customer, subscription, PaymentIntentId) {
        console.log('payWithCard step 1');
        loading(true);
        console.log('payWithCard step 2');
        timeOutNoLoading.cancel()
        console.log('payWithCard step 3');
        stripe
            .confirmCardPayment(clientSecret, {
                receipt_email: $('#emailPayment').val(),
                payment_method: {
                    card: card
                }
            })
            .then(function (result) {
                console.log('payWithCard result');
                console.log(result);
                if (result.error) {
                    // Show error to your customer
                    console.log("error stripe", result.error)
                    loading(false);
                    Sentry.captureMessage(result.error);
                    Sentry.setTag('error', result.error);
                    showError(result.error.message);
                    if (!result.error.payment_intent) {
                        result.error.payment_intent = {id: PaymentIntentId};
                    }
                    UpdateObjectApi("payment/update", paymentUserObject(dataUserPayment, result.error.payment_intent, customer, subscription, 'error', result.error.message), (error, data_error) => {
                        console.log(data_error, error);
                        if (error) {
                            Event.$emit("openModalPayment", {message: result.error.message, enable: false});
                        }
                    });
                } else {
                    // The payment succeeded!
                    console.log("pago exitoso", result);
                    UpdateObjectApi("payment/update", paymentUserObject(dataUserPayment, result.paymentIntent, customer, subscription, 'succeeded', null), (error, data_payment) => {
                        orderComplete();
                        if (error) {
                            console.log(error)
                            Sentry.captureMessage(error);
                            Sentry.setTag('error', error);
                            Sentry.captureMessage(error)
                        } else {
                            console.log("update data payment", data_payment)
                        }
                        purchaseInProcess = false;
                        window.location.href = '/es/payment/' + course_id + '/' + data_payment.promotionPurchase.id + '/success';
                    })
                }
            })
            .catch((error) => {
                // log("DEBUGGING"," PAYMENT | VALIDATION | PromotionId: " + promotionIdVal + " | Error pago Stripe"+ error);
                console.log("Stripe error")
                console.log(error);
            });
        console.log('payWithCard end operation');
    };
    let payWithSepa = function (stripe, iban, clientSecret, dataUserPayment, customer, subscription, PaymentIntentId) {
        console.log('payWithSepa step 1');
        loading(true);
        console.log('payWithSepa step 2');
        timeOutNoLoading.cancel();
        console.log('payWithSepa step 3');
        stripe
            .confirmSepaDebitPayment(
                clientSecret, {
                    payment_method: {
                        sepa_debit: iban,
                        billing_details: {
                            email: $('#emailPayment').val(),
                            name: $('#namePayment').val()
                        }
                    }
                })
            .then(function (result) {
                console.log('payWithSepa');
                console.log(result);
                if (result.error) {
                    // Show error to your customer
                    console.log("payWithSepa -> error", result.error)
                    loading(false);
                    Sentry.captureMessage(result.error);
                    showError(result.error.message);
                    if (!result.error.payment_intent) {
                        result.error.payment_intent = {id: PaymentIntentId, subscriptionId: subscription};
                    }
                    UpdateObjectApi("payment/update", paymentUserObject(dataUserPayment, result.error.payment_intent, customer, subscription, 'error', result.error.message), (error, data_error) => {
                        console.log(data_error, error);
                        if (error) {
                            Event.$emit("openModalPayment", {message: result.error.message, enable: false});
                        }
                    });
                } else {
                    // The payment succeeded!
                    console.log("payWithSepa -> ok", result)
                    UpdateObjectApi("payment/update", paymentUserObject(dataUserPayment, result.paymentIntent, customer, subscription, 'pending', null), (error, data_payment) => {
                        orderComplete();
                        if (error) {
                            console.log("payment/update -> error", error)
                            Sentry.captureMessage(error);
                        } else {
                            console.log("payment/update -> ok", data_payment)
                        }
                        purchaseInProcess = false;
                        window.location.href = '/es/payment/' + course_id + '/' + data_payment.promotionPurchase.id + '/success';
                    })
                }
            })
            .catch((error) => {
                console.log(error);
            });
        console.log('payWithSepa end operation');
    };
    let paymentUserObject = function (dataUser, paymentIntent, customer, subscription, status, status_reason) {
        return {
            promotion_purchase_id: dataUser.id,
            promotion_purchase_status: status,
            promotion_purchase_status_reason: status_reason,
            paymentIntent: paymentIntent,
            stripe_customer: customer,
            stripe_subscription_token: subscription
        }
    }
    /* ------- UI helpers ------- */
    // Shows a success message when the payment is complete
    // Show the customer the error from Stripe if their card fails to charge
    const showError = function (errorMsgText) {
        loading(false);
        const errorMsg = document.querySelector("#card-error");
        errorMsg.textContent = errorMsgText;
        errorMsg.style = ""
        setTimeout(function () {
            errorMsg.textContent = "";
            errorMsg.style = "display:none;"
        }, 20000);
    };
    const orderComplete = function () {
        document.querySelector("#submit").disabled = true;
        $("#card-error").html('Pago exitoso, cargando factura...');
    };
    const cleanInputs = function () {
        $('input:not([type="hidden"])').removeClass('is-invalid');
    }
    const showErrors = function (errorMessage, active, id) {
        $("#errors").show()
        let $id = $(`#${id}`);
        cleanInputs()
        const errorMsg = document.querySelector("#errors");
        loading(false)
        if (active) {
            errorMsg.classList.add("alert-danger");
            errorMsg.innerHTML += errorMessage
        } else {
            errorMsg.classList.remove("alert-danger");
            errorMsg.innerHTML = ""
        }
        $id.addClass('is-invalid');
    }

    // Show a spinner on payment submission
    const loading = function (isLoading, idDomHTML) {
        if (!idDomHTML) {
            idDomHTML = '#submit'
        }
        if (isLoading) {
            purchaseInProcess = true;
            document.querySelector(idDomHTML).disabled = true;
            $('#submitProgress').show();
            $('#submitContent').hide();
        } else {
            purchaseInProcess = false;
            document.querySelector(idDomHTML).disabled = false;
            $('#submitProgress').hide();
            $('#submitContent').show();
        }
    };

    const timeOutNoLoading = {
        setup: function (handleError, log, promotionIdVal) {
            this.cancel();
            this.timeoutID = window.setTimeout(function (msg) {
                // log("DEBUGGING"," PAYMENT | VALIDATION | PromotionId: " + promotionIdVal + " | Se ha disparado el timeout");
                handleError('Lo sentimos, ha habido un problema al contactar con tu banco. Nuestro equipo se pondrá en contacto contigo lo antes posible', true, 'errors')
            }, 30000);
        },
        cancel: function () {
            if (typeof this.timeoutID == "number") {
                window.clearTimeout(this.timeoutID);
                delete this.timeoutID;
            }
        }
    }

    function log(tipo, traza) {
        var srvconsumes = {type: tipo, payload: traza};

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            contentType: "application/json",
            url: "/es/payment-log",
            data: JSON.stringify(srvconsumes),
            dataType: "json",
            success: function (data) {
                console.log("log sent")
            },
            error: function (result) {
                console.log("log not sent");
            }
        });
    }

    $('#sons_group .radio_son').click(function () {
        let ra = $(this).find('input').val();
        if (ra === 'new') {
            $('#user-assistant').show();
        } else {
            $('#user-assistant').hide();
        }
    });

    const form = document.querySelector('#payment-form');
    const checkboxes = form.querySelectorAll('input.assistants');
    const checkboxLength = checkboxes.length;
    const firstCheckbox = checkboxLength > 0 ? checkboxes[0] : null;

    function init() {
        if (firstCheckbox) {
            for (let i = 0; i < checkboxLength; i++) {
                checkboxes[i].addEventListener('change', checkValidity);
            }
            checkValidity();
        }
    }

    function isChecked() {
        for (let i = 0; i < checkboxLength; i++) {
            if (checkboxes[i].checked) return true;
        }
        return false;
    }

    function checkValidity() {
        const errorMessage = !isChecked() ? 'Debes seleccionar al menos un hijo.' : '';
        firstCheckbox.setCustomValidity(errorMessage);
    }

    init()
});

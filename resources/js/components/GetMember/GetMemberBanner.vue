<template>
    <VApp class="auth-member">
        <div>
            <div class="modal fade" id="modalGetmember" data-backdrop="false" data-keyboard="false" tabindex="-1"
                 role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true"
                 style="z-index:2000000005 !important;">

                <v-list class="modal-getMember text-dark pb-10">
                    <v-list-item>
                        <v-btn class="ml-auto close" icon>
                            <v-icon @click="closeModal">{{ mdiClose }}</v-icon>
                        </v-btn>
                    </v-list-item>
                    <h2 class="ml-mob-30 ml-tb-40 ml-dk-40 title-modal pt-0">
                        Invita a tus amig@s
                    </h2>
                    <h2 class="ml-mob-30 ml-tb-40 ml-dk-40 subtitle-modal mt-3">Consigue un curso <span>gratis</span> en
                        Lifecole</h2>
                    <div
                        class="ml-mob-30 ml-tb-40 ml-dk-40 mr-mob-30 mr-tb-40 mr-dk-40 mt-4 mb-2 text-modal text-justify">
                        Invita a tus amig@s a descubrir <span>Lifecole</span>. Por cada 5 compras que realicen con tu
                        cupón
                        dto. te regalamos un curso totalmente <span>gratis</span> para tu hij@.
                        <br><br>Ofrece a tus amig@s un cupón del 20% dto. para su primera compra.
                    </div>
                    <div class="col-9 col-md-8 col-lg-8 promotion mx-auto mt-4 mb-5">{{ promoCode }}
                        <span v-clipboard:copy="promoCode"
                              v-clipboard:success="onCopy"
                              v-clipboard:error="onError">Copiar</span>
                    </div>

                    <v-menu transition="scroll-y-transition" origin="center">
                        <template v-slot:activator="{ on, attrs }">
                            <div class="col-12 text-center">
                                <v-btn
                                    dark
                                    color="#29c0d3"
                                    class="btn-share-promo text-light"
                                    v-bind="attrs"
                                    v-on="on"
                                >
                                    COMPARTIR
                                </v-btn>
                            </div>
                        </template>

                        <template>
                            <v-list class="mt-70">
                                <v-list-item class="justify-content-center">
                                    <img src="/assets/images/mgm/whatsapp_purple.svg" alt="" class="mr-12 pointer"
                                         id="Whatsapp" @click="share($event)">
                                    <img src="/assets/images/mgm/facebook_purple.svg" alt="" class="mr-12 pointer"
                                         id="Facebook" @click="share($event)">
                                    <!-- <img src="/assets/images/mgm/insta_purple.svg" alt="" class="mr-12 pointer" id="Instagram" @click="share($event)"> -->
                                    <img src="/assets/images/mgm/twitter_purple.svg" alt="" class="pointer" id="Twitter"
                                         @click="share($event)">
                                </v-list-item>
                            </v-list>
                        </template>
                    </v-menu>

                    <!-- <h6 class="share-txt text-center pt-4">O compártelo directamente en tus redes sociales</h6>
                    <div class="row justify-content-center pt-4 pb-2">
                      <img src="/assets/images/mgm/whatsapp_purple.svg" alt="" class="mr-12 pointer" id="Whatsapp" @click="share($event)">
                      <img src="/assets/images/mgm/facebook_purple.svg" alt="" class="mr-12 pointer" id="Facebook" @click="share($event)">
                      <img src="/assets/images/mgm/insta_purple.svg" alt="" class="mr-12 pointer" id="Instagram" @click="share($event)">
                      <img src="/assets/images/mgm/twitter_purple.svg" alt="" class="pointer" id="Twitter" @click="share($event)">
                    </div> -->
                    <div class="row mx-auto pl-16 pr-16">
                        <div class="col-6 pr-0 text-center">
                            <div class="number-promotion">{{ counter }}</div>
                            <div class="label-counter">Ganado</div>
                        </div>
                        <div class="col-6 pl-0 text-center">
                            <div class="number-promotion">{{ left }}</div>
                            <div class="label-counter">Pendiente</div>
                        </div>
                    </div>
                    <div class="row justify-content-center pt-4">
                        <a class="terms" href="/es/terminos-invita-amigos">Términos y condiciones</a>
                    </div>
                </v-list>
            </div>
            <v-dialog
                v-model="dialog"
                max-width="464"
                :fullscreen="fullDisplayMob"
            >
                <v-list class="modal-getMember text-dark pb-10">
                    <v-list-item>
                        <v-btn class="ml-auto" icon @click="dialog=false">
                            <v-icon>{{ mdiClose }}</v-icon>
                        </v-btn>
                    </v-list-item>
                    <h2 class="ml-mob-30 ml-tb-40 ml-dk-40 title-modal pt-0">
                        Invita a tus amig@s
                    </h2>
                    <h2 class="ml-mob-30 ml-tb-40 ml-dk-40 subtitle-modal mt-3">Consigue un curso <span>gratis</span> en
                        Lifecole</h2>
                    <div
                        class="ml-mob-30 ml-tb-40 ml-dk-40 mr-mob-30 mr-tb-40 mr-dk-40 mt-4 mb-2 text-modal text-justify">
                        Invita a tus amig@s a descubrir <span>Lifecole</span>. Por cada 5 compras que realicen con tu
                        cupón
                        dto. te regalamos un curso totalmente <span>gratis</span> para tu hij@.
                        <br><br>Ofrece a tus amig@s un cupón del 20% dto. para su primera compra.
                    </div>
                    <div class="col-9 col-md-8 col-lg-8 promotion mx-auto mt-4 mb-5">{{ promoCode }} <span
                        v-clipboard:copy="promoCode"
                        v-clipboard:success="onCopy"
                        v-clipboard:error="onError">Copiar</span>
                    </div>

                    <v-menu transition="scroll-y-transition" origin="center">
                        <template v-slot:activator="{ on, attrs }">
                            <div class="col-12 text-center">
                                <v-btn
                                    color="#29c0d3"
                                    class="btn-share-promo text-light"
                                    v-bind="attrs"
                                    v-on="on"
                                >
                                    COMPARTIR
                                </v-btn>
                            </div>
                        </template>
                        <template>
                            <v-list class="mt-70">
                                <v-list-item class="justify-content-center">
                                    <img src="/assets/images/mgm/whatsapp_purple.svg" alt="" class="mr-12 pointer"
                                         id="Whatsapp" @click="share($event)">
                                    <img src="/assets/images/mgm/facebook_purple.svg" alt="" class="mr-12 pointer"
                                         id="Facebook" @click="share($event)">
                                    <!-- <img src="/assets/images/mgm/insta_purple.svg" alt="" class="mr-12 pointer" id="Instagram" @click="share($event)"> -->
                                    <img src="/assets/images/mgm/twitter_purple.svg" alt="" class="pointer" id="Twitter"
                                         @click="share($event)">
                                </v-list-item>
                            </v-list>
                        </template>
                    </v-menu>

                    <!-- <h6 class="share-txt text-center pt-4">O compártelo directamente en tus redes sociales</h6>
                    <div class="row justify-content-center pt-4 pb-2">
                      <img src="/assets/images/mgm/whatsapp_purple.svg" alt="" class="mr-12 pointer" id="Whatsapp" @click="share($event)">
                      <img src="/assets/images/mgm/facebook_purple.svg" alt="" class="mr-12 pointer" id="Facebook" @click="share($event)">
                      <img src="/assets/images/mgm/insta_purple.svg" alt="" class="mr-12 pointer" id="Instagram" @click="share($event)">
                      <img src="/assets/images/mgm/twitter_purple.svg" alt="" class="pointer" id="Twitter" @click="share($event)">
                    </div> -->
                    <div class="row mx-auto pl-16 pr-16">
                        <div class="col-6 pr-0 text-center">
                            <div class="number-promotion">{{ counter }}</div>
                            <div class="label-counter">Ganado</div>
                        </div>
                        <div class="col-6 pl-0 text-center">
                            <div class="number-promotion">{{ left }}</div>
                            <div class="label-counter">Pendiente</div>
                        </div>
                    </div>
                    <div class="row justify-content-center pt-4">
                        <a class="terms" href="/es/terminos-invita-amigos">Términos y condiciones</a>
                    </div>
                </v-list>
            </v-dialog>
        </div>
    </VApp>
</template>

<script>
import { mdiClose } from '@mdi/js';
import {VApp} from 'vuetify/es5/components/VApp/VApp'
import {ClickOutside, VAppBar, VCheckbox, VCol, VRow} from 'vuetify/lib';
import {VBtn} from 'vuetify/es5/components/VBtn/VBtn';
import {VIcon} from 'vuetify/es5/components/VIcon/VIcon';
import {VMenu} from 'vuetify/es5/components/VMenu/VMenu';
import {VProgressCircular} from 'vuetify/es5/components/VProgressCircular/VProgressCircular'
import {VDialog} from 'vuetify/es5/components/VDialog/VDialog'
import {Intersect, Resize, Ripple, Touch} from 'vuetify/lib/directives';
import {VList, VListItem} from 'vuetify/es5/components/VList/VList'
import {VThemeProvider} from 'vuetify/es5/components/VThemeProvider'
import {GetObject} from '../../axios-services'
import Event from "../../event";

export default {
    components: {
        VApp,
        VAppBar, VRow, VCol, VCheckbox,
        VMenu,
        VDialog,
        VList,
        VListItem,
        VBtn,
        VIcon,
        VProgressCircular,
        VThemeProvider
    },
    directives: {ClickOutside, Ripple, Intersect, Touch, Resize},
    props: ['login', 'user_id'],
    data() {
        return {
            isActive: false,
            isDark: false,
            hiddenBanner: false,
            dialog: false,
            dataTarget: '#Register',
            promoCode: '',
            counter: 0,
            left: 0,
            copiedText: '',
            mdiClose
        }
    },
    created() {
        if (this.user_id) {
            this.loadCoupon()
        }
    },

    mounted() {
        Event.$on('get-member', (open) => {
            this.dialog = true
        });
        let user = this.$cookies.get('user')
        if (user) {
            console.log("cookie", user)
            if (user.getMember === 'close') {
                this.closeBanner()
                console.log("close modal", user.getMember)
            }
        }
    },

    computed: {
        fullDisplayMob() {
            if (window.innerWidth <= 896) {
                return true;
            }
        }
    },
    methods: {
        onCopy: function (e) {
            this.copiedText = e.text;
            this.copiedText = ''
        },
        onError: function (e) {
            console.log('Failed to copy texts')
        },
        hiddenScroll() {
            document.getElementsByTagName('html')[0].classList.add("modal-open");
        },

        closeModal() {
            document.getElementById('modalGetmember').classList.replace('show', 'd-none')
        },

        closeBanner() {
            this.hiddenBanner = true;
            let user = {getMember: 'close'};
            if (!this.$cookies.get('user'))
                this.$cookies.set('user', user, "1d");
        },
        loadCoupon() {
            GetObject('coupons', (error, data) => {
                console.log(data)
                this.promoCode = data.coupon ? data.coupon.code : ''
                this.counter = data.coupon ? data.coupon.counter : 0
                this.left = data.coupon ? data.coupon.limit - data.coupon.counter : 0
            })
        },
        share: function (event) {
            let text = '¡Hola! Te regalo un 20% de descuento en tu primer curso en Lifecole. Usa el cupón ' + this.promoCode
            let id = event.currentTarget.id;
            let currentUrl = window.location.href
            console.log(event.currentTarget.id);
            if (id === 'Facebook') {
                window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(currentUrl + '?utm_source=mgm&utm_medium=facebook&utm_campaing=cincocupones') + '&quote=' + text, '_blank');
            } else if (id === 'Whatsapp') {
                window.open('https://api.whatsapp.com/send?text=' + encodeURIComponent(text + ' ' + currentUrl + '?utm_source=mgm&utm_medium=whatsapp&utm_campaing=cincocupones'), '_blank');
            } else if (id === 'Twitter') {
                window.open('https://twitter.com/intent/tweet?text=' + encodeURIComponent(text) + '&url=' + encodeURIComponent(currentUrl + '?utm_source=mgm&utm_medium=twitter&utm_campaing=cincocupones'), '_blank');
            }
        },
    },
}
</script>

<style scoped>
.auth-member {
    position: absolute;
}

.title-getmember {
    font-family: Poppins;
    font-size: 21px;
    font-weight: 400;
}

.title-getmember > span {
    font-weight: 600;
}

.sub-titlegm {
    font-family: Poppins;
    font-size: 14px;
    font-weight: 400;
}

.getMember-btn {
    width: 95px;
    height: 32px;
    border-radius: 3px;
    box-shadow: 0 2px 5px 0 rgba(52, 58, 64, 0.25);
    border: solid 1.5px #343a40;
    background-color: #f5f5f5;
    font-family: Poppins;
    font-size: 14px;
    font-weight: bold;
    color: #343a40;
    text-transform: uppercase;
    margin-left: auto;
    margin-right: 15px;
}

.close-btn {
    font-size: 24px;
    font-weight: 700;
    position: absolute;
    top: -5px;
    right: 0;
    margin-right: 5px;
    cursor: pointer;
}

.modal-getMember {
    border-radius: 10px !important;
    box-shadow: 0 5px 10px 0 rgba(74, 64, 87, 0.2) !important;
    height: 100%;
}

.title-modal {
    font-family: Poppins;
    font-size: 32px !important;
    font-weight: bold !important;
}

.subtitle-modal {
    font-family: Poppins;
    font-size: 18px;
    font-weight: 400;
}

.subtitle-modal > span {
    font-weight: 600;
    color: #5c2767;
}

.text-modal {
    font-family: Poppins;
    font-size: 14px;
    font-weight: 400;
}

.text-modal > span {
    font-weight: 600;
    color: #5c2767;
}

.promotion {
    width: 280px;
    height: 46px !important;
    border-radius: 8px;
    box-shadow: 0 2px 8px 0 rgba(35, 158, 173, 0.5);
    border: solid 1px #29c0d3;
    padding: 10px 25px;
    font-family: Poppins;
    font-size: 12px;
    font-weight: normal;
    color: rgba(52, 58, 64, 0.7);
}

.promotion > span {
    font-family: Poppins;
    font-size: 14px;
    font-weight: bold;
    color: #29c0d3;
    cursor: pointer;
    position: sticky;
    left: 80%;
}

.btn-share-promo {
    width: 280px;
    height: 46px !important;
    border-radius: 8px !important;
    box-shadow: 0 2px 8px 0 rgba(35, 158, 173, 0.5) !important;
    font-family: Poppins;
    font-size: 14px;
    font-weight: bold;
}

.share-txt {
    font-family: Poppins;
    font-size: 12px;
    font-weight: normal;
}

.pointer {
    cursor: pointer;
}

.number-promotion {
    font-family: Poppins;
    font-size: 24px;
    font-weight: 600;
    color: #5c2767;
}

.label-counter {
    font-family: Poppins;
    font-size: 16px;
    font-weight: normal;
    line-height: 1.31;
}

.terms {
    font-family: Poppins;
    font-size: 14px;
    font-weight: 600;
    color: #29c0d3;
}

@media (max-width: 767.98px) {
    .title-getmember {
        font-size: 16px;
        width: max-content;
    }

    .sub-titlegm {
        font-size: 12px;
    }

}

</style>

<style>
.v-dialog {
    overflow-x: hidden !important;
    overflow-y: hidden !important;
}
</style>

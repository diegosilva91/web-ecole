import Vue from 'vue';
import { createPinia, PiniaVuePlugin } from 'pinia';
import Vuetify, { VApp  } from "vuetify/lib";
import VueCookies from 'vue-cookies';
import 'vuetify/dist/vuetify.min.css'

require('./bootstrap');

// Vue Pinia
Vue.use(PiniaVuePlugin);
const pinia = createPinia();

// Vuetify
Vue.use(Vuetify, {
    components: {
        VApp
    }
})
const vuetify = new Vuetify({
    icons: {
        iconfont: 'mdiSvg'
    }
})

// Vue Cookies
Vue.use(VueCookies);

// Home components
Vue.component('nav-bar', () => import(/* webpackPrefetch: true */ /* webpackChunkName: "dist/js/home/nav-bar" */'./components/NavBar.vue'));
Vue.component('footer-new', () => import(/* webpackPrefetch: true */ /* webpackChunkName: "dist/js/home/footer-new" */'./components/FooterNew.vue'));
Vue.component('home-page', () => import(/* webpackPrefetch: true */ /* webpackChunkName: "dist/js/home/home-page" */'./components/Home/Home.vue'));

// Banner Top Menu components
Vue.component('top-banner', () => import(/* webpackChunkName: "dist/js/top-banner" */'./components/GetMember/TopBanner.vue'));

// Promo Landing components
Vue.component('promo-landing', () => import(/* webpackChunkName: "dist/js/promo-landing" */'./components/Promo/PromoLanding.vue'));

Vue.component('overlay', () => import(/* webpackChunkName: "dist/js/overlay" */'./components/Overlay.vue'));

new Vue({
    el: '#app',
    pinia,
    vuetify
});
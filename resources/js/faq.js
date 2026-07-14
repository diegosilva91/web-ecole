import Vue from 'vue'
import { createPinia, PiniaVuePlugin } from 'pinia';
import Vuetify, { VApp } from 'vuetify/lib';

require('./bootstrap');

// Vue Pinia
Vue.use(PiniaVuePlugin);
const pinia = createPinia();

// Vuetify
Vue.use(Vuetify, {
    components: {
        VApp
    }
});
const vuetify = new Vuetify({
    icons: {
        iconfont: 'mdiSvg'
    }
});

Vue.use(require('vue-cookies'))

Vue.component('frequently-questions',  () => import(/* webpackPrefetch: true */ /* webpackChunkName: "dist/js/faq/frequently-questions" */'./components/FAQ/FrequentlyQuestions.vue'));
Vue.component('nav-bar', () => import(/* webpackPrefetch: true */ /* webpackChunkName: "dist/js/faq/nav-bar" */'./components/NavBar.vue'));
Vue.component('footer-new', () => import(/* webpackPrefetch: true */ /* webpackChunkName: "dist/js/faq/footer-new" */'./components/FooterNew.vue'));
Vue.component('home-page', () => import(/* webpackPrefetch: true */ /* webpackChunkName: "dist/js/faq/home-page" */'./components/Home/Home.vue'));
Vue.component('overlay', () => import(/* webpackChunkName: "dist/js/overlay" */'./components/Overlay.vue'));

new Vue({
    el: '#faq',
    pinia,
    vuetify
});


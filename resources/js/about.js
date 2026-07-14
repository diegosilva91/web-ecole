import Vue from 'vue';
import { createPinia, PiniaVuePlugin } from 'pinia';
import Vuetify, { VApp } from 'vuetify/lib';
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
});
const vuetify = new Vuetify({
    icons: {
        iconfont: 'mdiSvg'
    }
})

Vue.use(require('vue-cookies'));

Vue.component('nav-bar', () => import(/* webpackChunkName: "dist/js/nav-bar" */'./components/NavBar.vue'));
Vue.component('footer-new', () => import(/* webpackChunkName: "dist/js/footer-new" */'./components/FooterNew.vue'));

Vue.component('about-header', () => import(/* webpackChunkName: "dist/js/about-header" */'./components/About/AboutHeader.vue'));
Vue.component('about-info', () => import(/* webpackChunkName: "dist/js/about-info" */'./components/About/AboutInfo.vue'));
Vue.component('about-cards', () => import(/* webpackChunkName: "dist/js/about-cards" */'./components/About/AboutCards.vue'));
Vue.component('about-team', () => import(/* webpackChunkName: "dist/js/about-team" */'./components/About/AboutTeam.vue'));
Vue.component('about-inversor', () => import(/* webpackChunkName: "dist/js/about/about-inversor" */'./components/About/AboutInversor.vue'));
Vue.component('overlay', () => import(/* webpackChunkName: "dist/js/overlay" */'./components/Overlay.vue'));

new Vue({
    el: '#about',
    pinia,
    vuetify
});

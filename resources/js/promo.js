require('./bootstrap');
import 'vuetify/dist/vuetify.min.css';
window.Vue = require('vue');

import VueTagManager from "vue-tag-manager"
Vue.use(VueTagManager, {
    gtmId: process.env.MIX_GTM_ID
})
Vue.use(require('vue-cookies'))

Vue.component('nav-bar', () => import(/* webpackPrefetch: true */ /* webpackChunkName: "dist/js/home/nav-bar" */'./components/NavBar.vue'));
Vue.component('footer-new', () => import(/* webpackPrefetch: true */ /* webpackChunkName: "dist/js/home/footer-new" */'./components/FooterNew.vue'));
Vue.component('promo-landing', () => import(/* webpackChunkName: "dist/js/promo-landing" */'./components/Promo/PromoLanding.vue'));

const app = new Vue({
    el: '#promos',
});


    // Show Modal Promo //
    $(window).on('load',function(){
        $('#modalBF').modal('show');
    });





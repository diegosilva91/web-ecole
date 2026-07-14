import Vue from "vue";
import { createPinia, PiniaVuePlugin } from 'pinia';
import VueTagManager from "vue-tag-manager"
import Vuetify, { VApp } from "vuetify/lib";

require('./bootstrap');

Vue.use(VueTagManager, {
    gtmId: process.env.MIX_GTM_ID
})

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

// NavBar and footer
Vue.component('nav-bar', () => import(/* webpackPrefetch: true *//* webpackChunkName: "dist/js/nav-bar" */'./components/NavBar.vue'));
Vue.component('footer-new', () => import(/* webpackPrefetch: true *//* webpackChunkName: "dist/js/footer-new" */'./components/FooterNew.vue'));

Vue.component('teacher-header', () => import(/* webpackPrefetch: true *//* webpackChunkName: "dist/js/teacher-header" */'./components/Teacher/TeacherHeader.vue'));
Vue.component('register-teacher-form', () => import(/* webpackPrefetch: true *//* webpackChunkName: "dist/js/register-teacher-form" */'./components/Teacher/RegisterTeacherForm.vue'));
Vue.component('teacher-benefits', () => import(/* webpackPrefetch: true *//* webpackPrefetch: true *//* webpackChunkName: "dist/js/teacher-benefits" */'./components/Teacher/TeacherBenefits.vue'));
Vue.component('teacher-modal-form', () => import(/* webpackPrefetch: true *//* webpackChunkName: "dist/js/teacher-modal-form" */'./components/Teacher/TeacherModalForm.vue'));
Vue.component('teacher-lifecooler', () => import(/* webpackChunkName: "dist/js/teacher-lifecooler" */'./components/Teacher/TeacherLifecooler.vue'));
Vue.component('teacher-faq', () => import(/* webpackChunkName: "dist/js/teacher-faq" */'./components/Teacher/TeacherFaq.vue'));
Vue.component('teacher-cards', () => import(/* webpackChunkName: "dist/js/teacher-cards" */'./components/Teacher/TeacherCards.vue'));
Vue.component('modal-submit', () => import(/* webpackChunkName: "dist/js/modal-submit" */'./components/Landing/ModalSubmit.vue'));
Vue.component('overlay', () => import(/* webpackChunkName: "dist/js/overlay" */'./components/Overlay.vue'));


new Vue({
    el: '#teacherPage',
    pinia,
    vuetify
});

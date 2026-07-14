import Vue from "vue";
import Vuetify, { VApp } from 'vuetify/lib';
import 'vuetify/dist/vuetify.min.css'

require('./bootstrap');

// Vuetify
Vue.use(Vuetify, {
    components: {
        VApp
    }
});

Vue.use(require('vue-cookies'))

Vue.component('navbar-landing', () => import(/* webpackChunkName: "dist/js/navbar-landing" */'./components/Landing/NavbarLanding.vue'));
Vue.component('landing-form', () => import(/* webpackChunkName: "dist/js/landing-form" */'./components/Landing/LandingForm.vue'));
Vue.component('sponsors-baner', () => import(/* webpackChunkName: "dist/js/sponsors-baner" */'./components/Home/SponsorsBaner.vue'));
Vue.component('landing-modal', () => import(/* webpackChunkName: "dist/js/landing-modal" */'./components/Landing/LandingModal.vue'));
Vue.component('modal-submit', () => import(/* webpackChunkName: "dist/js/modal-submit" */'./components/Landing/ModalSubmit.vue'));

// Landing General Tech //
Vue.component('header-landing-tech', () => import(/* webpackChunkName: "dist/js/header-landing-tech" */'./components/Landing/HeaderLandingTech.vue'));
Vue.component('landing-form-tech', () => import(/* webpackChunkName: "dist/js/landing-form-tech" */'./components/Landing/LandingFormTech.vue'));
Vue.component('landing-modal-tech', () => import(/* webpackChunkName: "dist/js/landing-modal-tech" */'./components/Landing/LandingModalTech.vue'));
Vue.component('banner-courses', () => import(/* webpackChunkName: "dist/js/banner-courses" */'./components/Home/BannerCourses.vue'));
Vue.component('landing-tags', () => import(/* webpackChunkName: "dist/js/landing-tags" */'./components/Landing/LandingTags.vue'));
Vue.component('landing-video', () => import(/* webpackChunkName: "dist/js/landing-video" */'./components/Landing/LandingVideo.vue'));
Vue.component('landing-banner', () => import(/* webpackChunkName: "dist/js/landing-banner" */'./components/Landing/LandingBanner.vue'));
Vue.component('landing-reviews', () => import(/* webpackChunkName: "dist/js/landing-reviews" */'./components/Landing/LandingReviews.vue'));
Vue.component('landing-contact', () => import(/* webpackChunkName: "dist/js/landing-contact" */'./components/Landing/LandingContact.vue'));

Vue.component('footer-landing', () => import(/* webpackChunkName: "dist/js/footer-landing" */'./components/Landing/FooterLanding.vue'));

new Vue({
    el: '#landingPage',
    vuetify: new Vuetify()
});

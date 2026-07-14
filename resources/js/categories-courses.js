import Vue from 'vue'
import { createPinia, PiniaVuePlugin } from 'pinia';
import Vuetify, { VApp } from 'vuetify/lib';
import 'vuetify/dist/vuetify.min.css'

require('./bootstrap');

// Vue Pinia
Vue.use(PiniaVuePlugin);
const pinia = createPinia();

// Vue Cookies
Vue.use(require('vue-cookies'));

// Vuetify
Vue.use(Vuetify, {
    components: {
        VApp
    }
});

Vue.component('nav-bar', () => import(/* webpackPrefetch: true */ /* webpackChunkName: "dist/js/home/nav-bar" */'./components/NavBar.vue'));
Vue.component('footer-new', () => import(/* webpackPrefetch: true */ /* webpackChunkName: "dist/js/home/footer-new" */'./components/FooterNew.vue'));
Vue.component('tech-header', () => import(/* webpackChunkName: "dist/js/categories-courses/tech-header" */'./components/Tech/TechHeader.vue'));
Vue.component('course-card-new', () => import(/* webpackChunkName: "dist/js/courses/course-card-new" */'./components/Courses/CourseCardNew.vue'));
Vue.component('courses-tech', () => import(/* webpackChunkName: "dist/js/categories-courses/courses-tech" */'./components/Tech/CoursesTech.vue'));
Vue.component('search-trajectories-list', () => import(/* webpackChunkName: "dist/js/search-trajectories-list" */'./components/Trajectories/SearchTrajectoriesList.vue'));
Vue.component('overlay', () => import(/* webpackChunkName: "dist/js/overlay" */'./components/Overlay.vue'));

new Vue({
    el: '#course-categories',
    pinia,
    vuetify: new Vuetify()
});

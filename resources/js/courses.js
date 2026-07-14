require('./bootstrap');
import Vue from 'vue';
import { createPinia, PiniaVuePlugin } from 'pinia';
import Vuetify, { VApp } from 'vuetify/lib';
import 'vuetify/dist/vuetify.min.css'

Vue.use(require('vue-cookies'))

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

Vue.component('nav-bar', () => import(/* webpackChunkName: "dist/js/nav-bar" */'./components/NavBar.vue'));
Vue.component('footer-new', () => import(/* webpackChunkName: "dist/js/footer-new" */'./components/FooterNew.vue'));

Vue.component('course-card-new', require('./components/Courses/CourseCardNew.vue').default);
Vue.component('search-list-courses', require('./components/Courses/SearchListCourses.vue').default);
Vue.component('search-trajectories-list', () => import(/* webpackChunkName: "dist/js/search-trajectories-list" */'./components/Trajectories/SearchTrajectoriesList.vue'));
Vue.component('filter-courses', () => import(/* webpackChunkName: "dist/js/filter-courses" */'./components/Categorization/FilterCourses.vue'));

Vue.component('tech-header', () => import(/* webpackChunkName: "dist/js/categories-courses/tech-header" */'./components/Tech/TechHeader.vue'));
Vue.component('overlay', () => import(/* webpackChunkName: "dist/js/overlay" */'./components/Overlay.vue'));

new Vue({
    el: '#courses',
    pinia,
    vuetify
});

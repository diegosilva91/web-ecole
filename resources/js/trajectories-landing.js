import Vue from 'vue';
import Vuetify, { VApp } from 'vuetify/lib';
import 'vuetify/dist/vuetify.min.css'

require('./bootstrap');

// Vuetify
Vue.use(Vuetify, {
    components: {
        VApp
    }
});
const vuetify = new Vuetify();

Vue.component('nav-bar', () => import(/* webpackPrefetch: true */ /* webpackChunkName: "dist/js/home/nav-bar" */'./components/NavBar.vue'));
Vue.component('footer-new', () => import(/* webpackPrefetch: true */ /* webpackChunkName: "dist/js/home/footer-new" */'./components/FooterNew.vue'));

Vue.component('landing-trajectories', () => import(/* webpackChunkName: "dist/js/landing-trajectories" */'./components/Trajectories/LandingTrajectories.vue'));
Vue.component('search-trajectories-list', () => import(/* webpackChunkName: "dist/js/search-trajectories-list" */'./components/Trajectories/SearchTrajectoriesList.vue'));

new Vue({
    el: '#trajectories',
    vuetify
});

require('./bootstrap');

import Vue from "vue";
import Vuetify from "vuetify";
import VueProgressBar from 'vue-progressbar'
import 'vuetify/dist/vuetify.min.css'

// Vuetify
Vue.use(Vuetify);
const vuetify = new Vuetify({
    icons: {
        iconfont: 'mdiSvg'
    }
});

// Vue Progress Bar
const options = {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '5px'
}
Vue.use(VueProgressBar, options)

//NavBar and footer
Vue.component('nav-bar', () => import(/* webpackChunkName: "dist/js/nav-bar" */'./components/NavBar.vue'));
Vue.component('footer-new', () => import(/* webpackChunkName: "dist/js/footer-new" */'./components/FooterNew.vue'));
Vue.component('review-modal', () => import(/* webpackChunkName: "dist/js/review-modal" */'./components/Modals/ReviewModal.vue'));
Vue.component('reviews-form', () => import(/* webpackChunkName: "dist/js/reviews-form" */'./components/Reviews/ReviewsForm.vue'));

new Vue({
    el: '#reviewsPage',
    vuetify
});

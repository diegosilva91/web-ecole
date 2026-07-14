import Vue from 'vue';
import { createPinia, PiniaVuePlugin } from 'pinia';
import Vuetify, { VApp } from 'vuetify/lib';
import VueTagManager from "vue-tag-manager";
import lazySizes from 'lazysizes';
import moment from 'moment';
import VueMoment from 'vue-moment';
import 'vuetify/dist/vuetify.min.css';
import CartIcon from './components/Icons/CartIcon';

require('./bootstrap');

Vue.use(require('vue-cookies'))
Vue.use(VueTagManager, {
    gtmId: process.env.MIX_GTM_ID
})

// Vue Moment
require('moment/locale/es');
moment.locale('es');
Vue.use(VueMoment, { moment });

// Vue Pinia
Vue.use(PiniaVuePlugin);
const pinia = createPinia();

// Vuetify
Vue.use(Vuetify, {
    components: {
        VApp,
    }
});
const vuetify = new Vuetify({
    icons: {
        iconfont: 'mdiSvg',
        values: {
            cartIcon: {
              component: CartIcon,
            },
        },
    }
});

Vue.use(lazySizes);

//Course Details
Vue.component('course-details-header', () => import(/* webpackPrefetch: true */ /* webpackChunkName: "dist/js/course/course-details-header" */  './components/CourseDetailsHeader.vue'));
Vue.component('course-details-why', () => import(/* webpackPrefetch: true */ /* webpackChunkName: "dist/js/course/course-details-why" */  './components/CourseDetailsWhy.vue'));
Vue.component('course-details-card', () => import(/* webpackPrefetch: true */ /* webpackChunkName: "dist/js/course/course-details-card" */  './components/CourseDetailsCard.vue'));
Vue.component('course-details-promotions', () => import(/* webpackPrefetch: true */ /* webpackChunkName: "dist/js/course/course-details-promotions" */  './components/CourseDetailsPromotions.vue'));
Vue.component('course-details-tooltip', () => import(/* webpackPrefetch: true */ /* webpackChunkName: "dist/js/course/course-details-tooltip" */  './components/CourseDetailsTooltip.vue'));
Vue.component('course-plans-mini', () => import(/* webpackPrefetch: true */ /* webpackChunkName: "dist/js/course/course-plans-mini" */  './components/Course/CoursePlansMini.vue'));
Vue.component('course-plans-mini-container', () => import(/* webpackPrefetch: true */ /* webpackChunkName: "dist/js/course/course-plans-mini-container" */  './components/Course/CoursePlansMiniContainer.vue'));
Vue.component('course-reviews', () => import(/* webpackPrefetch: true */ /* webpackChunkName: "dist/js/course/course-reviews" */  './components/Course/CourseReviews.vue'));
Vue.component('course-rating', () => import(/* webpackPrefetch: true */ /* webpackChunkName: "dist/js/course/course-rating" */  './components/Course/CourseRating.vue'));
Vue.component('course-opinions', () => import(/* webpackPrefetch: true *//* webpackChunkName: "dist/js/course/course-opinions" */  './components/Course/CourseOpinions.vue'));
Vue.component('teachers-expansion-panels', () => import(/* webpackPrefetch: true *//* webpackChunkName: "dist/js/course/course-teachers" */ './components/Teachers/TeachersExpansionPanels.vue'));
Vue.component('teachers-dialog', () => import(/* webpackPrefetch: true *//* webpackChunkName: "dist/js/course/course-teachers" */ './components/Teachers/TeachersDialog.vue'));
Vue.component('course-footer', () => import(/* webpackPrefetch: true *//* webpackChunkName: "dist/js/course/course-footer" */ './components/Course/CourseFooter.vue'));

//Buttons (Star, Like and Share)
Vue.component('favorite-button', () => import/* webpackPrefetch: true */ (/* webpackChunkName: "dist/js/course/favorite-button" */  './components/FavoriteButton.vue'));
Vue.component('share-button', () => import/* webpackPrefetch: true */ (/* webpackChunkName: "dist/js/course/share-button" */  './components/ShareButton.vue'));

//NavBar and footer
Vue.component('nav-bar', () => import(/* webpackPrefetch: true */ /* webpackChunkName: "dist/js/course/nav-bar" */'./components/NavBar.vue'));
Vue.component('footer-new', () => import(/* webpackPrefetch: true */ /* webpackChunkName: "dist/js/course/footer-new" */'./components/FooterNew.vue'));

//Modals
Vue.component('modal-session', () => import(/* webpackPrefetch: true */ /* webpackChunkName: "dist/js/course/modal-session" */'./components/Trajectories/ModalSession.vue'));

Vue.component('overlay', () => import(/* webpackChunkName: "dist/js/overlay" */'./components/Overlay.vue'));

new Vue({
    el: '#course',
    pinia,
    vuetify
});

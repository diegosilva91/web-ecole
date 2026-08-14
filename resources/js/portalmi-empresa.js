require('./bootstrap');
window.Vue = require('vue');
import { createPinia, PiniaVuePlugin } from 'pinia';
import Vuetify from "vuetify";
import VueRouter from 'vue-router'

// Vue Pinia
Vue.use(PiniaVuePlugin);
const pinia = createPinia();

Vue.use(Vuetify);
Vue.use(VueRouter)
Vue.use(require('vue-cookies'))
import VueTagManager from "vue-tag-manager"
Vue.use(VueTagManager, {
    gtmId: process.env.MIX_GTM_ID
})
import router from './components/PortalMi-empresa/manager-router-lf'
Vue.component('navigation-manager-mi-empresa', require('./components/PortalMi-empresa/NavigationManagerLF.vue').default);
Vue.component('nav-bar', () => import(/* webpackChunkName: "dist/js/nav-bar" */'./components/NavBar.vue'));
Vue.component('footer-new', () => import(/* webpackChunkName: "dist/js/footer-new" */'./components/FooterNew.vue'));
Vue.component('overlay', () => import(/* webpackChunkName: "dist/js/overlay" */'./components/Overlay.vue'));

new Vue({
    el: '#portalmi-empresa',
    pinia,
    router: router,
    vuetify: new Vuetify()
});

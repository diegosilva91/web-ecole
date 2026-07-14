import VueTagManager from "vue-tag-manager"

import Vue from 'vue'
import VueAxios from 'vue-axios'
import VueSocialauth from 'vue-social-auth'
import axios from 'axios';

Vue.use(VueAxios, axios)
Vue.use(VueSocialauth, {
    providers: {
        google: {
            clientId: '721480707563-n9gnn08j8alarsigi95rtpid2e7c3e1u.apps.googleusercontent.com',
            redirectUri: '/auth/google/callback' // Your client app URL
        }
    }
})

Vue.component('login-modal', () => import(/* webpackChunkName: "dist/js/login-modal" */  './components/Auth/LoginModal.vue'));
Vue.component('register-modal', () => import(/* webpackChunkName: "dist/js/register-modal" */  './components/Auth/RegisterModal.vue'));
Vue.component('favorite-message', () => import(/* webpackChunkName: "dist/js/favorite-message" */  './components/Modals/FavoriteMessage.vue'));

Vue.use(VueTagManager, {
    gtmId: process.env.MIX_GTM_ID
})
new Vue({
    el: '#guests'
});


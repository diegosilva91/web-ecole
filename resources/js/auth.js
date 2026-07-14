import Vue from 'vue'
import VueClipboard from 'vue-clipboard2'
import VueCookies from 'vue-cookies';
import Vuetify, { VApp } from 'vuetify/lib';

// Vue Clipboard 2
VueClipboard.config.autoSetContainer = true
Vue.use(VueClipboard)

// Vue Cookies
Vue.use(VueCookies);

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

Vue.component('get-member-banner', () => import(/* webpackPrefetch: true */ /* webpackChunkName: "dist/js/auth/get-member-banner" */'./components/GetMember/GetMemberBanner.vue'));

new Vue({
    el: '#auth',
    vuetify
});

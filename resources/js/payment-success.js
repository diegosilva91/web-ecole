import Vue from "vue";
import { createPinia, PiniaVuePlugin } from 'pinia';
import Vuetify, { VApp } from "vuetify/lib";
import VueCookies from "vue-cookies";
import "vuetify/dist/vuetify.min.css";

require("./bootstrap");

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
    iconfont: "mdiSvg"
  }
});

// Vue Cookies
Vue.use(VueCookies);

// Vue components
Vue.component("nav-bar", () =>
  import(
    /* webpackPrefetch: true */ /* webpackChunkName: "dist/js/payment-success/nav-bar" */ "./components/NavBar.vue"
  )
);
Vue.component("footer-new", () =>
  import(
    /* webpackPrefetch: true */ /* webpackChunkName: "dist/js/payment-success/footer-new" */ "./components/FooterNew.vue"
  )
);
Vue.component("checkout-course-info", () =>
  import(
    /* webpackPrefetch: true */ /* webpackChunkName: "dist/js/payment-success/checkout-course-info" */ "./components/Payment/CheckoutCourseInfo.vue"
  )
);
Vue.component("top-banner", () =>
  import(
    /* webpackChunkName: "dist/js/top-banner" */ "./components/GetMember/TopBanner.vue"
  )
);
Vue.component('overlay', () => import(/* webpackChunkName: "dist/js/overlay" */'./components/Overlay.vue'));

new Vue({
  el: "#app",
  pinia,
  vuetify
});

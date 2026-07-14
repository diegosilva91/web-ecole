import Vue from 'vue'
import Vuetify from 'vuetify/lib'
import 'vuetify/dist/vuetify.min.css'
// import { VAppBar, VRow,VCol ,VCheckbox} from 'vuetify/lib'
//only summerbanner
// import { Ripple, Intersect, Touch, Resize } from 'vuetify/lib/directives';
Vue.use(Vuetify, {
    // components: { VAppBar,VRow,VCol,VCheckbox },
    // directives: { Ripple, Intersect, Touch, Resize },
})

const opts = {
    theme: {
        dark: false,
    },
    icons: {
        iconfont: 'mdi'
    },
    themes: {
        dark: true,
        light: {
            primary: "#4682b4",
            secondary: "#b0bec5",
            accent: "#8c9eff",
            error: "#b71c1c",
        },
    },
}

export default new Vuetify(opts)

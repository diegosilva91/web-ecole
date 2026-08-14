import Vue from 'vue';
import Vuetify, { VApp  } from "vuetify/lib";
import { createPinia, PiniaVuePlugin } from 'pinia';
import 'vuetify/dist/vuetify.min.css'

require('./bootstrap');

// Vue Pinia
Vue.use(PiniaVuePlugin);
const pinia = createPinia();

// Vuetify
Vue.use(Vuetify, {
    components: {
        VApp
    }
})
const vuetify = new Vuetify({
    icons: {
        iconfont: 'mdiSvg'
    }
})

Vue.use(require('vue-cookies'))

Vue.component('nav-bar', () => import(/* webpackChunkName: "dist/js/nav-bar" */'./components/NavBar.vue'));
Vue.component('footer-new', () => import(/* webpackChunkName: "dist/js/footer-new" */'./components/FooterNew.vue'));
Vue.component('overlay', () => import(/* webpackChunkName: "dist/js/overlay" */'./components/Overlay.vue'));

new Vue({
    el: '#contact',
    pinia,
    vuetify
});

//Change contact page    and Validations Functions
var selec = document.getElementById("subject");
var inpt1 = document.getElementsByClassName("contact-inputs")[0];
var inpt2 = document.getElementsByClassName("contact-inputs")[1];
var inpt3 = document.getElementsByClassName("contact-inputs")[2];
var inpt4 = document.getElementsByClassName("contact-inputs")[3];
var inpt5 = document.getElementsByClassName("contact-inputs")[4];
var inpt6 = document.getElementsByClassName("contact-inputs")[5];

selec.addEventListener("change", changeContact)
inpt1.addEventListener("change", hiddenError1);
inpt2.addEventListener("change", hiddenError2);
inpt3.addEventListener("change", hiddenError3);
inpt4.addEventListener("change", hiddenError4);
inpt5.addEventListener("change", hiddenError5);
inpt6.addEventListener("change", hiddenError6);

function changeContact() {
    var s = document.getElementById("subject").value;
    var c = document.getElementById("category");
    var errorcat = document.getElementById("msg_error_category");
    var lc = document.getElementById("label_category");
    var partial = document.getElementById("partial_contact");
    var partialTeacher = document.getElementById("partial_teacher");

    if(s==="Quiero ser profesor de mi-empresa") {
        partial.classList.add('d-none');
        partialTeacher.classList.remove('d-none');
    } else {
        partial.classList.toggle('d-none',false);
        partialTeacher.classList.toggle('d-none',true);
    }

    if(s==="Solicitud de Sesión Online Informativa") {
        c.setAttribute('required','required');
        c.setCustomValidity('Debe definir la categoría');
        lc.classList.add('d-none');
        errorcat.classList.remove('d-none');
    } else {
        c.removeAttribute('required');
        c.setCustomValidity('');
        lc.classList.toggle('d-none', false);
        errorcat.classList.toggle('d-none', true);
    }

}

function hiddenError1() {
    var inptvalue = document.getElementsByClassName("contact-inputs")[0].value;
    var msgerror = document.getElementsByClassName("msg-error")[0];

    if( inptvalue !== ''){
        msgerror.classList.add('d-none');
    } else {
        msgerror.classList.remove('d-none');
    }
}

function hiddenError2() {
    var inptvalue = document.getElementsByClassName("contact-inputs")[1].value;
    var msgerror = document.getElementsByClassName("msg-error")[1];

    if( inptvalue !== ''){
        msgerror.classList.add('d-none');
    } else {
        msgerror.classList.remove('d-none');
    }

    if(/.+@.+\..+/.test(inptvalue) == false) {
        msgerror.classList.remove('d-none');
        msgerror.textContent = "El email debe ser válido"
    } else {
        msgerror.textContent = "Correo electronico es requerido"
        msgerror.classList.add('d-none');
    }
}

function hiddenError3() {
    var inptvalue = document.getElementsByClassName("contact-inputs")[2].value;
    var msgerror = document.getElementsByClassName("msg-error")[2];

    if( inptvalue !== ''){
        msgerror.classList.add('d-none');
    } else {
        msgerror.classList.remove('d-none');
    }

    if(/^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/.test(inptvalue) == false) {
        msgerror.classList.remove('d-none');
        msgerror.textContent = "Debe definir un teléfono válido"
    } else {
        msgerror.textContent = "Debe definir el teléfono"
        msgerror.classList.add('d-none');
    }
}

function hiddenError4() {
    var inptvalue = document.getElementsByClassName("contact-inputs")[3].value;
    var msgerror = document.getElementsByClassName("msg-error")[3];

    if( inptvalue !== ''){
        msgerror.classList.add('d-none');
    } else {
        msgerror.classList.remove('d-none');
    }
}

function hiddenError5() {
    var inptvalue = document.getElementsByClassName("contact-inputs")[4].value;
    var msgerror = document.getElementsByClassName("msg-error")[4];

    if( inptvalue !== ''){
        msgerror.classList.add('d-none');
    } else {
        msgerror.classList.remove('d-none');
    }
}

function hiddenError6() {
    var inptvalue = document.getElementsByClassName("contact-inputs")[5].value;
    var msgerror = document.getElementsByClassName("msg-error")[5];

    if( inptvalue !== ''){
        msgerror.classList.add('d-none');
    } else {
        msgerror.classList.remove('d-none');
    }
}

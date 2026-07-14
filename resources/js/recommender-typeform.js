import Vue from "vue";
window.Vue = require('vue');
import Vuetify from "vuetify";
import {UpdateObjectApi} from "./axios-services";
import 'vuetify/dist/vuetify.min.css'
require('./bootstrap');
Vue.use(Vuetify);

//NavBar and footer
Vue.component('nav-bar', () => import(/* webpackChunkName: "dist/js/nav-bar" */'./components/NavBar.vue'));
Vue.component('footer-new', () => import(/* webpackChunkName: "dist/js/footer-new" */'./components/FooterNew.vue'));
const typeform = new Vue({
    el: '#type-form',
    vuetify: new Vuetify()
});

$(document).ready(function () {
    let qs,js,q,s,d=document, gi=d.getElementById, ce=d.createElement, gt=d.getElementsByTagName, id="typef_orm";
    if(!gi.call(d,id) && window.location.pathname==='/es/recommender') {
        const embedElement =  document.querySelector('.typeform-widget')
       let user_id=$('#typeform-widget').data('userId')
        let form_id= $('#typeform-widget').data('formId')
        // console.log(embedElement,user_id,form_id,`https://form.typeform.com/to/${form_id}/?user_id= ${ user_id}`)
        window.typeformEmbed.makeWidget(embedElement, `https://form.typeform.com/to/${form_id}/?user_id= ${ user_id}`,
            {
                hideHeaders: true,
                hideFooter: true,
                onSubmit: function (event) {
                    // console.log(event.response_id)
                    UpdateObjectApi(`recommender-courses/update`, {user_id:user_id,token_typeform: event.response_id}, (error, data) => {
                        if (data) {
                            console.log(data)
                            if(user_id===data.user_id){
                                window.location.href = `/es/lf/mis_cursos/cursos_recomendados/${user_id}?id_recommender=${data.id}`
                            }
                            else if(data.u_key){
                                window.location.href = `/es/lf/mis_cursos/cursos_recomendados/${data.u_key}?id_recommender=${data.id}`
                            }else{
                                window.location.href = `/es/lf/mis_cursos/cursos_recomendados/0?id_recommender=${data.id}`
                            }
                        } else {
                            //todo send log
                            window.location.href = `/es/lf/mis_cursos/cursos_recomendados/0?id_recommender=1`
                        }
                    })
                }
            }
        )
    }
})

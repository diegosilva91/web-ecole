import VueRouter from "vue-router";
import UserPerfilModel from '../UserPerfil/UserPerfil.vue'
import TeacherPerfilModel from '../Perfil/PerfilTeacher.vue'
import TeacherPromotions from '../PortalTeacher/PromotionsResponsive.vue'
import ResponsiveMyCourses from '../PortalUser/ResponsiveMyCourses.vue';
import RecommendedCourses from '../PortalUser/RecommendedCourses.vue';
import NoAuth from "../Guest/NoAuth.vue";
import {GetObject} from "../../axios-services";

let routes= {
    mode: 'history',
//'.Auth::id())
    routes: [
        {
            path: '/es/lf/miperfil/:id/view',
            name: 'UserPerfilModel',
            component: UserPerfilModel,
            props:true
        },
        {
            path: '/es/lf/profesor/:id/model',
            name: 'TeacherPerfilModel',
            component: TeacherPerfilModel,
            props:true
        },
        {
            path: '/es/lf/promociones/:id',
            name: 'TeacherPromotions',
            component: TeacherPromotions,
            props:true
        },
        {
            path: '/es/lf/mis_cursos/:id',
            name: 'ResponsiveMyCourses',
            component: ResponsiveMyCourses,
            props:true
        },
        {
            path: '/es/lf/mis_cursos/cursos_recomendados/:id',
            name: 'RecommendedCourses',
            component: RecommendedCourses,
            props:true,
            query:"id_recommender"
        },
        {
            path: '/es/lf/not_authorized/:id',
            name: 'notAuth',
            component:NoAuth,
            props: true,
        },
    ]
}
const router=new VueRouter(routes)
router. beforeEach(async (to, from, next) => {
    if(to.params.id){
        let response=await getAxios(to);
        console.log(response);
        if(response.error){
            return next({
                    name: 'notAuth',params:{id:response.user_id}
                })
        }
        return next()
    }
});
async function getAxios(to){
    let response;
    try {
        response = await GetObject(`auth/${to.params.id}`, async (error, data) => {
            if (data) {
                return await data// return next()
            } else {
                console.log(error.data)
                return await error.data;
            }
        });
        return response
    }catch (e) {
        console.log(e)
        return e;
    }

}
export default router;

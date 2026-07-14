<template>
    <div v-if="loaded">
        <div v-if="courses.length<1" class="container-10 text-center p-5 mt-5 mb-100">
            <h3>Aun no tienes ningún curso</h3>
            <p class="mt-2">¡Descubre nuestra amplia variedad de cursos!</p>
            <a href="/es/cursos"><button class="btn-more-courses mt-2">Ver Cursos</button></a>
        </div>
        <div v-else class="container-10 text-center p-5 mt-5 mb-100">
            <h3>{{info}}</h3>
            <p class="mt-2">¡Descubre nuestra amplia variedad de cursos!</p>
            <a href="/es/cursos"><button class="btn-more-courses mt-2">Ver Cursos</button></a>
        </div>
    </div>
</template>

<script>
import {GetObject} from "../../axios-services";
import Event from "../../event";

export default {
    data: () => ({
        courses:[],
        info:'Aún no tienes ningún curso activo.',
        title:'Activos',
        loaded:false,
    }),
    mounted(){
        this.GetCourses()
        Event.$on('filter-title-my-courses', (title)=>{
            console.log(title)
            if(title===null){
                title='Activos'
                this.info='Aún no tienes ningún curso activo.'
            }
            else{
                switch(title) {
                    default:
                    case 'activos':
                        this.info='Aún no tienes ningún curso activo.'
                        break;
                    case 'next':
                        this.info='No tienes ningún curso próximo.'
                        title = 'Próximos'
                        break;
                    case 'finalizados':
                        this.info='Aún no tienes ningún curso completado.'
                        title = 'Próximos'
                        break;
                }
            }
            this.loaded=true
        this.title=title
        });
        Event.$on('counter-courses',(count_courses)=>{
            console.log("count")

            if(count_courses>0){
                this.loaded=false
            }
            else{
                this.loaded=true
            }
        })
    },
    methods:{
        GetCourses(){
            GetObject(`promotions?include=promotionPurchases,courses,userPromotionPurchases&active_promotions=false&filter[userPromotionPurchases.id]=${this.$route.params.id}`, (error, data) => {
                this.loaded= true
                if (data.promotions.data.length > 0) {
                    this.courses = data.promotions.data
                }
            })
        }
    }

}
</script>

<style scoped>
.container-10{
    margin-left: 15%;
    margin-right: 15%;
    background-color: #eef0f3;
}

h3{
    font-family: 'Poppins';
    font-size: 21px;
    font-weight: 500;
    line-height: 1.95;
}

p{
    font-family: 'Poppins';
    font-size: 18px;
    font-weight: 500;
    line-height: 1.95;
    color: #343a40;
}

.btn-more-courses {
  width: 176px;
  height: 38px;
  border-radius: 8px;
  box-shadow: 0 2px 8px 0 rgba(35, 158, 173, 0.5);
  background-color: #29c0d3;
  text-transform: uppercase;
  color: #fff;
  font-family: 'Open Sans';
  font-size: 16px;
  font-weight: 600;
}

@media (max-width: 500px){
    .container-10{
        margin-left: auto;
        margin-right: auto;
    }
}
</style>

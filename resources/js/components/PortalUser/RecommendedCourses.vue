<template>
  <div v-show="courses.length>0" class="container">
    <h2  class="h2-txt-med  mt-40 mt-dk-100 text-center">Cursos Recomendados</h2>
    <div v-if="loading" class="container mx-auto">
          <div class="row">
              <div v-for="course in courses" :key="course.id" class="col-11 col-md-6 col-lg-3">
                  <div class="single_courses mt-30 mb-30">
                      <a :href="`${course.newLink}`">
                          <div class="courses_image">
                              <img :src="`https://myawsmi-empresa.s3.eu-west-1.amazonaws.com/public/${course.cover_image}`" alt="course">
                          </div>
                      </a>
                      <div class="courses_content">
                          <div class="tag-categorie mt-2">{{ course.categoryName }}</div>
                          <h2 class="course-title mt-2" style="line-height: 1.5 !important;"><a class="text-dark" :href="`${course.newLink}`">{{
                                  course.title | truncate(45, '...')
                              }}</a></h2>
                          <div class="d-inline">
                              <img class="d-inline" src="/assets/images/course/icons/star.svg" alt=""
                                   style="vertical-align: sub;">
                              <div class="d-inline purple-title h7-txt-sbold">{{ course.avg_reviews|formatDouble }}<span
                                  class="text-muted p3-txt ml-2"
                                  style="vertical-align: top;">({{ course.total_reviews }})</span></div>
                          </div>
                          <p class="course-details mt-2">{{ course.intro | sanitize | truncate( 50, '...') }}</p>

                          <div class="row">
                              <div class="col-6 course-details">
                                  <img src="/assets/images/home_vector/carrito-gris.svg" alt="">
                                  Total
                                  {{ course.price_total - (course.price_total * course.discount) / 100 }}€
                              </div>
                              <div class="col-6 course-details">
                                  <img src="/assets/images/home_vector/user.svg" alt="">
                                  {{ course.student_ages_min }}-{{ course.student_ages_max }}
                                  Años
                              </div>
                          </div>
                          <div class="row mt-4">
                              <div class="col-6 course-details"><img src="/assets/images/home_vector/date.svg" alt="">
                                  {{ course.first_promotion.start_at | formatted('yyyy-MM-dd') }}
                              </div>
                              <div class="col-6 course-details"><img src="/assets/images/home_vector/session.svg" alt="">
                                  {{ course.duration }} sesiones
                              </div>
                          </div>

                          <div v-if="course.discount>0">
                              <div class="course-details red-title">{{ course.discount }}% Dto. <span
                                  class="dto">{{ course.price_total }}€</span></div>
                              <a :href="`${course.newLink}`"
                                 class="v-btn v-size--default theme--light mt-0 mb-20 w-100" style="background-color:#29c0d3;height: 31px;border-radius: 8px;
                        box-shadow: 0 2px 8px 0 rgba(35, 158, 173, 0.5);"><img
                                  src="/assets/images/home_vector/carrito.svg" alt=""> <span
                                  class="btn-price text-lowercase ml-4">{{ course.price_per_hour }}€ / h</span></a>
                          </div>
                          <div v-else>
                              <a :href="`${course.newLink}`"
                                 class="v-btn v-size--default theme--light mt-5 mb-20 w-100" style="background-color:#29c0d3;height: 31px;border-radius: 8px;
                        box-shadow: 0 2px 8px 0 rgba(35, 158, 173, 0.5);"><img
                                  src="/assets/images/home_vector/carrito.svg" alt=""> <span
                                  class="btn-price text-lowercase ml-4">{{ course.price_per_hour }}€ / h</span></a>
                          </div>
                      </div>
                  </div>
              </div>
          </div>

      </div>
  </div>
</template>

<script>
import InfiniteLoading from 'vue-infinite-loading';
import {GetObject} from '../../axios-services'
import Event from "../../event";
let today = new Date();
let todayFormat = today.getFullYear() + '/' + (today.getMonth() + 1) + '/' + today.getDate()
export default {
    components: {
        InfiniteLoading,
    },
    props:['recommender_load'],
    data() {
        return {
            courses: [],
            loading: false,
            query: '',
            page: 1,
            url:'',
            selectDaily:[],
            skills:[],
            starts_after_hour:[],
            filters:3,
        }
    },
    mounted(){
        console.log(this.recommender_load,this.$route.params.id);
        let id_recommender=this.$route.query.id_recommender
        let query=id_recommender?`id=${id_recommender}&user_id=${this.$route.params.id}`:`user_id=${this.$route.params.id}`
        GetObject(`recommender-courses?${query}`,(error,data)=>{
            let recommender={daily:[],starts_after_hour:'Mañana'};
            if(error){

            }else{
                if(data.recommender_type){
                    recommender=JSON.parse(data.recommender_type)
                    if(recommender.daily){
                        this.selectDaily=recommender.daily
                    }
                    if(recommender.starts_after_hour){
                        if(recommender.starts_after_hour.length>1) {
                            this.starts_after_hour='&filter[starts_after_hour]= 09:00:00, 14:00:00' +
                                '&filter[starts_after_hour]= 15:00:00, 20:00:00'
                        }
                        else{
                            this.starts_after_hour=recommender.starts_after_hour==='Mañana'?'&filter[starts_after_hour]=09:00:00, 14:00:00' :
                                '&filter[starts_after_hour]=15:00:00, 20:00:00'
                        }
                    }
                    if(recommender.skills){
                        this.skills.push(recommender.skills)
                    }
                    this.page=1
                    this.filters=3
                    this.query='&filterRecommended=true'+this.parameterizeArray('daily',this.selectDaily)+this.starts_after_hour+this.parameterizeArray('skills.skill_name',this.skills)
                    this.UpdateCourses(this.query)
                } else if(data.token_typeform){
                    this.query='&filterRecommended=true'
                    this.UpdateCourses(this.query)
                }
            }
        })
        Event.$on('count-courses',(count_courses)=>{
            console.log(count_courses)
        })
    },
    methods:{

        infiniteHandler($state) {
            GetObject('courses?include=categories,promotions,skills' + this.query+`&page=${this.page}`, (error, data) => {
                console.log(data)
                if (data.courses.data.length) {
                    console.log("data")
                    this.page += 1;
                    this.courses.push(...data.courses.data);
                    data.courses.data ? this.courses.map(value => {
                        //    /* console.log(new Date(Math.min(...value.promotions.map(value=>{console.log(new Date(value.start_at.replace(/-/g, "/") ))
                        //         return new Date(value.start_at.replace(/-/g, "/") ) }))) )*/
                        //    value.start_at = new Date(Math.min(...value.promotions/*.filter(value=>{console.log(value.start_at)})*/.map(value => {/*console.log(new Date(value.start_at.replace(/-/g, "/") ))*/
                        //        return new Date(value.start_at.replace(/-/g, "/"))
                        //    })))
                        //    console.log(value.first_promotion)
                        value.start_at= new Date(value.first_promotion.start_at.replace(/-/g, "/"))
                        if (!value.newLink) {
                            value.newLink = '';
                        }
                        //console.log(value.start_at)
                    }) : ''
                    /*this.courses=this.courses.filter(value=>{ console.log(today,value.start_at,today<=value.start_at)
                        if(value.start_at>=today) return value})*/
                    this.url = data.url ? data.url : ''
                    //console.log(this.url)
                    Event.$emit('count-courses', this.courses.length)
                    this.loading = true
                    $state.loaded();
                } else {
                    console.warn(error)
                    $state.complete();
                }
            })
        },
        UpdateCourses(query) {
            this.loading = false
            GetObject('courses?include=categories,promotions,skills' + query, (error, data) => {
                console.log(data)
                this.page += 1;
                this.courses = data.courses.data ? data.courses.data : []
                data.courses.data ? this.courses.map(value => {
                    //    /* console.log(new Date(Math.min(...value.promotions.map(value=>{console.log(new Date(value.start_at.replace(/-/g, "/") ))
                    //         return new Date(value.start_at.replace(/-/g, "/") ) }))) )*/
                    //    value.start_at = new Date(Math.min(...value.promotions/*.filter(value=>{console.log(value.start_at)})*/.map(value => {/*console.log(new Date(value.start_at.replace(/-/g, "/") ))*/
                    //        return new Date(value.start_at.replace(/-/g, "/"))
                    //    })))
                    //    console.log(value.first_promotion)
                    value.start_at= new Date(value.first_promotion.start_at.replace(/-/g, "/"));
                    if (!value.newLink) {
                        value.newLink = '';
                    }
                    //console.log(value.start_at)
                }) : ''
                /*this.courses=this.courses.filter(value=>{ console.log(today,value.start_at,today<=value.start_at)
                    if(value.start_at>=today) return value})*/
                this.url = data.url ? data.url : ''
                //console.log(this.url)
                Event.$emit('count-courses', this.courses.length)
                this.loading = true
            })
        },
        parameterizeArray(key, arr,operator) {
            if (arr.length === 0)
                return ''
            if (operator==='&')
                return '&filter[' + key + ']=' + arr.join( ',')
            return '&filter[' + key + ']=' + arr.join('&filter[' + key + ']=')
        },
    },
    filters: {
        truncate(text, length, suffix) {
            if (text.length > length) {
                return text.substring(0, length) + suffix;
            } else {
                return text;
            }
        },


        formatted(date) {
            const d = new Date(date.replace(/-/g, "/"));
            const mo = new Intl.DateTimeFormat('es', {month: '2-digit'}).format(d);
            const da = new Intl.DateTimeFormat('es', {day: '2-digit'}).format(d);
            const ye = new Intl.DateTimeFormat('es', {year: 'numeric'}).format(d);
            return `${da}-${mo}-${ye}`
        },
        formatDouble(value) {
            if (value - Math.floor(value) !== 0) {
                return parseFloat(value).toFixed(1)
            } else {
                return parseFloat(value).toFixed(0)
            }
        }, sanitize(value) {
            return value.replace( /(<([^>]+)>)/ig, '');
        }

    }
}
</script>

<style>

</style>

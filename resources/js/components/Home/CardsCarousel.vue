<template>
    <LazyHydrate when-visible>
    <section id="cursos" :class="viewType==='blackfriday'?'bg-list-courses-bf':'bg-list-courses'" class="pb-40">
        <div class="container">
            <h2 class="h2-txt-med text-dark text-center mt-100 mb-25">Cursos intensivos destacados</h2>
            <observer v-if="!loading" msg="cards-carousel" v-on:intersect="intersected"/>
            <div v-else>
                <template v-if="courses.length>0">
                    <div class="row">
                        <div v-for="(course, i) in courses"
                             :key="i" class="col-lg-3 col-sm-6 col-11 mx-auto mx-sm-0">
                            <course-card-new :title="course.title" :ageMax="course.student_ages_max"
                                             :category="course.categoryName"
                                             :imgMobile="course.cover_image_mobile?url+course.cover_image_mobile:null"
                                             :ageMin="course.student_ages_min" :img="url+course.cover_image"
                                             :url="course.newLink"
                                             :price="course.price_total" :id="course.id"
                                             :intro="course.intro"
                                             :startAt="course.start_at"
                                             :discount="course.discount"
                                             :sessions="course.duration"
                                             :priceHour="course.price_per_hour"
                                             :typeCourse="course.type_course"
                                             :subtypeCourse="course.subtype_course"
                                             :rating="course.avg_reviews"
                                             :valorations="course.total_reviews">
                            </course-card-new>
                        </div>
                    </div>
                    <infinite-loading @infinite="infiniteHandler">
                        <div class="row" slot="spinner">
                            <v-progress-circular
                                indeterminate
                                color="#5c2767"
                                class="mx-auto">
                            </v-progress-circular>
                        </div>
                        <div slot="no-more"></div>
                        <div slot="no-results"></div>
                    </infinite-loading>
                    <div class="row">
                        <a class="mr-lg-4 ml-mob-30 ml-tb-15 ml-lg-auto" href="/es/cursos">
                            <button class="btn-booking"><span class="btn-price blue-title">Ver más</span></button>
                        </a>
                    </div>
                </template>
            </div>
            <div v-if="!loading"  class="row">
                <v-progress-circular
                    indeterminate
                    color="#5c2767"
                    class="mx-auto">
                </v-progress-circular>
            </div>
        </div>
    </section>
    </LazyHydrate>
</template>
<script>
import LazyHydrate from 'vue-lazy-hydration';
const Observer= () => import(/* webpackChunkName: "dist/js/home/observer-cards-carousel" */ '../Observer.vue')
import VProgressCircular from 'vuetify/es5/components/VProgressCircular'
import InfiniteLoading from 'vue-infinite-loading';
const CourseCardNew= () => import(/* webpackChunkName: "dist/js/home/course-card-new-cards-carousel" */  '../Courses/CourseCardNew');
import {GetObject} from "../../axios-services";

export default {
    name: "CardsCarousel",
    props:['viewType'],
    components: {
        LazyHydrate,
        VProgressCircular,
        Observer,
        CourseCardNew,
        InfiniteLoading,
    },
    data() {
        return {
            loading:false,
            courses:[],
            url:'',
            page:1,
        }
    },
    mounted() {
    },
    methods: {
        intersected() {
            this.loading=true
            this.$nextTick(()=>{this.UpdateCourses()})
        },
        infiniteHandler($state) {
            GetObject(`courses/featured?page=${this.page}`, (error, data) => {
                //console.log(data)
                if (data.courses.data.length) {
                    //console.log("data")
                    this.page += 1;
                    this.courses.push(...data.courses.data);
                    data.courses.data ? this.courses.map(value => {
                        //    /* console.log(new Date(Math.min(...value.promotions.map(value=>{console.log(new Date(value.start_at.replace(/-/g, "/") ))
                        //         return new Date(value.start_at.replace(/-/g, "/") ) }))) )*/
                        //    value.start_at = new Date(Math.min(...value.promotions/*.filter(value=>{console.log(value.start_at)})*/.map(value => {/*console.log(new Date(value.start_at.replace(/-/g, "/") ))*/
                        //        return new Date(value.start_at.replace(/-/g, "/"))
                        //    })))
                        //    console.log(value.first_promotion)
                        if(value.first_promotion){
                            value.start_at= new Date(value.first_promotion.start_at.replace(/-/g, "/"))
                        }
                        if (!value.newLink) {
                            value.newLink = '';
                        }
                        //console.log(value.start_at)
                    }) : ''
                    /*this.courses=this.courses.filter(value=>{ console.log(today,value.start_at,today<=value.start_at)
                        if(value.start_at>=today) return value})*/
                    this.url = data.url ? data.url : ''
                    //console.log(this.url)
                    this.loading = true
                    $state.loaded();
                } else {
                    console.warn(error)
                    $state.complete();
                }
            })
        },
        UpdateCourses() {
            GetObject(`courses/featured?page=${this.page}`, (error, data) => {
                this.page+=1;
                this.courses = data.courses.data? data.courses.data : []
                data.courses.data ? this.courses.map(value => {
                    //    /* console.log(new Date(Math.min(...value.promotions.map(value=>{console.log(new Date(value.start_at.replace(/-/g, "/") ))
                    //         return new Date(value.start_at.replace(/-/g, "/") ) }))) )*/
                    //    value.start_at = new Date(Math.min(...value.promotions/*.filter(value=>{console.log(value.start_at)})*/.map(value => {/*console.log(new Date(value.start_at.replace(/-/g, "/") ))*/
                    //        return new Date(value.start_at.replace(/-/g, "/"))
                    //    })))
                        //console.log(value.first_promotion)
                    if(value.first_promotion){
                        value.start_at= new Date(value.first_promotion.start_at.replace(/-/g, "/"))
                    }
                  //  value.start_at=  new Date(value.start_at.replace(/-/g, "/"))
                    //console.log(value.start_at)
                }) : ''
                this.url=data.url
            })
        }
    },
    filters: {
        parametrized(value) {
            if (value === null)
                return ''
            else
                return value
        }
    }
}
</script>

<style scoped>
.bg-list-courses {
  width: 100%;
  height: auto;
  object-fit: contain;
  background-blend-mode: multiply;
  background-image: linear-gradient(to bottom, #fff, #dcf4f7 27%, #dbf4f7);
}

.bg-list-courses-bf {
  width: 100%;
  height: auto;
  object-fit: contain;
  background-blend-mode: multiply;
  background-image: linear-gradient(to bottom, #fff, rgba(26,29,31,0.3));
}
</style>

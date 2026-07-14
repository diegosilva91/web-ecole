<template>
    <div>
        <div class="d-none d-lg-block">
            <MyCourses/>
        </div>
        <div class="d-block d-lg-none">
            <MyCoursesMobile/>
        </div>
        <infinite-loading @infinite="infiniteHandler" ref="infiniteLoading">
            <div class="row" slot="spinner">
                <v-progress-circular
                    indeterminate
                    color="#5c2767"
                    class="mx-auto">
                </v-progress-circular>
            </div>
            <div slot="no-more"></div>
            <div slot="no-results"><NoCourses /></div>
        </infinite-loading>
         <RecommendedCourses/>
    </div>
</template>

<script>
import MyCourses from './MyCourses'
import MyCoursesMobile from './MyCoursesMobile'
import NoCourses from './NoCourses'
import RecommendedCourses from './RecommendedCourses'
import Event from "../../event";
import {GetObject} from "../../axios-services";
import InfiniteLoading from "vue-infinite-loading";

export default {
    components: {
        MyCourses,
        MyCoursesMobile,
        NoCourses,
        RecommendedCourses,
        InfiniteLoading
    },
    data: () => ({
        page: 1,
        courses: [],
        query: `&filter[start_at_end_at]=active`,
        url:'https://myawslifecole.s3.eu-west-1.amazonaws.com/public/',
    }),
    mounted() {
        let vm=this
         Event.$on('filter-my-courses', (query) => {
             this.query = query
             vm.page = 1
             this.getData(this.query);
             this.page = 2
             try{
                 this.$refs.infiniteLoading.stateChanger.reset();
             }catch (e) {
                 console.log(e);
             }
         })
    },
    methods: {
        infiniteHandler($state) {
            GetObject(`promotions?include=promotionPurchases,courses,userPromotionPurchases&active_promotions=false&filter[userPromotionPurchases.id]=${this.$route.params.id}&page=${this.page}${this.query}`, (error, data) => {
                if (data.promotions.data.length > 0) {
                    this.page += 1;
                    data.promotions.data = data.promotions.data ? data.promotions.data.map((courses) => {
                            if (courses.next_at) {
                                courses.date = new Date(courses.next_at.replace(/-/g, "/"))
                                courses.time = courses.date
                            } else {
                                courses.date = new Date(courses.start_at.replace(/-/g, "/"))
                                courses.time = courses.date
                            }
                            if (!courses.completed) {
                                courses.completed=false
                            }
                            if (!courses.is_next) {
                                courses.is_next=false
                            }
                            return courses;
                        })
                        : []
                    this.courses.push(...data.promotions.data);
                    this.url=data.url
                    Event.$emit('counter-courses', this.courses.length)
                    Event.$emit('data-courses', {courses:this.courses,url:this.url})
                    $state.loaded()
                } else {
                    console.log(error)
                    $state.complete();
                }
            })
        },
        getData: function (query) {
            this.loading = false

            GetObject(`promotions?include=promotionPurchases,courses,userPromotionPurchases&active_promotions=false&filter[userPromotionPurchases.id]=${this.$route.params.id}&page=${this.page}${query}`, (error, data) => {
                if (error) {
                    data.promotions.courses = []
                    this.loading = true
                } else {
                    // this.page += 1;
                    data.promotions.data = data.promotions.data ? data.promotions.data.map((courses) => {
                            if (courses.next_at) {
                                courses.date = new Date(courses.next_at.replace(/-/g, "/"))
                                courses.time = courses.date
                            } else {
                                courses.date = new Date(courses.start_at.replace(/-/g, "/"))
                                courses.time = courses.date
                            }
                            if (!courses.completed) {
                                courses.completed=false
                            }
                            return courses;
                        })
                        : []
                    this.courses = data.promotions.data
                    this.url=data.url
                    Event.$emit('data-courses', {courses:this.courses,url:this.url})
                    Event.$emit('counter-courses', this.courses.length)
                }
            });
        },
    },
}
</script>

<style>

</style>

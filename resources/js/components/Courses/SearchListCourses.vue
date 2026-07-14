<template>
    <div v-if="loading" class="container mb-100">
        <div v-if="courses.length>0">
            <div class="row">
                <div v-for="(course, i) in courses"
                     :key="i" class="col-lg-3 col-sm-6 col-11">
                    <course-card-new :title="course.title" :ageMax="course.student_ages_max"
                                     :category="course.categoryName"
                                     :imgMobile="course.cover_image_mobile?url+course.cover_image_mobile:null"
                                     :ageMin="course.student_ages_min" :img="url+course.cover_image"
                                     :url="course.newLink"
                                     :price="course.price_total"
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
        </div>

        <div class="col-12 mt-50" v-else>
            <img src="/assets/images/filters/error-busqueda.svg" alt="" class="row mx-auto"/>
        </div>
    </div>
    <div v-else class="container mb-100">
        <div class="row" slot="spinner">
            <v-progress-circular
                    indeterminate
                    color="#5c2767"
                    class="mx-auto">
            </v-progress-circular>
        </div>
    </div>
</template>

<script>
import InfiniteLoading from 'vue-infinite-loading';
import Event from "../../event";
import {getCourses, TypeBackCourse} from "../../courses/courses";

let today = new Date();
let todayFormat = today.getFullYear() + '/' + (today.getMonth() + 1) + '/' + today.getDate()
export default {
    name: "ListCourses",
    components: {
        InfiniteLoading,
    },
    props: ['searchquery', 'optionsRequestSelected'],
    data() {
        return {
            courses: [],
            loading: false,
            start_at: '',
            queryTree :[],
            pagination: {
                current: 1,
                total: 0
            },
            typeView : 'type_courses',
            query: '',
            url: '',
            page: 1,
            list: [],
        }
    },
    mounted() {
        console.log("mounted list courses");
        if (this.optionsRequestSelected !== undefined && this.optionsRequestSelected !==null) {
            this.loadRequestFilters();
            this.UpdateCourses(this.query);
        } else if (!this.searchquery) {
            this.UpdateCourses(this.query)
        }
    },
    methods: {
        loadRequestFilters() {
            if(this.optionsRequestSelected !== undefined) {
                let indexArea;
                let slugArea;
                let indexCategories;
                let slugCategories;
                let index;
                let slug;

                if ('area' in this.optionsRequestSelected) {
                    indexArea = 'areas'
                    slugArea = this.optionsRequestSelected.area.slug;
                    console.log(this.optionsRequestSelected.categories);
                    this.loadList(slugArea, indexArea);
                    if ('categories' in this.optionsRequestSelected) {
                        indexCategories = 'categories'
                        slugCategories = this.optionsRequestSelected.categories.slug;
                        this.loadList(slugCategories, indexCategories);
                    }
                    if (this.optionsRequestSelected.specializations) {
                        index = 'specializations'
                        slug = this.optionsRequestSelected.specializations.slug;
                        this.loadList(slug, index);
                    }
                }
            }
        },
        loadList( slug, index) {
            this.queryTree [index] = `&${index}=${slug}`;
            if (index === 'tag') {
                this.queryTree [index] = `&${index}[]=${slug}`;
            }
            this.applyFilters();
        },
        applyFilters() {
            let query = '';
            if (this.queryCourseType !== '') {
                query += 'type_course='+TypeBackCourse['filter_intensives'];
            }
            if (Object.keys(this.queryTree).length > 0) {
                if (this.queryTree['areas']) {
                    query += this.queryTree['areas'];
                }
                if (this.queryTree['categories']) {
                    query += this.queryTree['categories'];
                }
                if (this.queryTree['specializations']) {
                    query += this.queryTree['specializations'];
                }
                if (this.queryTree['tag'] && this.typeView === 'type_tags') {
                    query += this.queryTree['tag'];
                }
            }
            this.query = '?' + query;
        },
        async infiniteHandler($state) {
            this.pagination.current = this.pagination.current + 1;
            let data = await this.initQueries(this.query);
            if (data.courses) {
                if (data.courses.data.length > 0) {
                    $state.loaded();
                    this.courses.push(...data.courses.data);
                } else {
                    $state.complete();
                }
            } else {
                $state.complete();
            }
        },
        async UpdateCourses(query) {
            this.loading = false;
            let data = await this.initQueries(query);
            if(data.courses){
                this.courses = data.courses.data ? data.courses.data : [];
            }
            this.url = data.url ? data.url : '';
            this.loading = true;
        },
        async initQueries(query) {
            let page = null;
            if (this.typeView === 'type_courses') {
                page = this.pagination.current;
                this.pagination.current = 0;
            }
            let data = await getCourses('courses/search', query, page, TypeBackCourse['filter_intensives'], );
            console.log(data);
            console.log("courses ",this.courses);
            if('last_page' in data.courses ){
                this.pagination.total = data.courses.last_page;
            }
            this.pagination.current = page;
            this.$forceUpdate();
            console.log("update page",this.pagination);
            return data;
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
@media (max-width: 668px) {
    .col-11 {
        margin-right: auto !important;
        margin-left: auto !important;
    }
}
</style>

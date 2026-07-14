<template>
    <div v-if="loading" class="container">
        <div class="row">
            <div v-for="course in courses" :key="course.id" class="col-lg-4 col-sm-6 col-11">
                <CardTrajectory :title="course.title"
                                :ageMax="course.student_ages_max"
                                :category="course.categoryName"
                                :imgMobile="course.cover_image_mobile?url+course.cover_image_mobile:null"
                                :ageMin="course.student_ages_min" :img="url+course.cover_image"
                                :studentsMin="course.students_min"
                                :studentsMax="course.students_max"
                                :url="course.newLink"
                                :price="course.price_total" :id="course.id"
                                :priceEnrollment="course.price_enrollment"
                                :startAt="course.start_at"
                                :endAt="course.end_at"
                                :discount="course.discount"
                                :duration="course.duration"
                                :sessions="course.session"
                                :sessionTime="course.sessionTime"
                                :rating="course.avg_reviews"
                                :valorations="course.total_reviews|parametrized"></CardTrajectory>
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
import CardTrajectory from './CardTrajectory.vue'
import {getCourses, TypeBackCourse} from "../../courses/courses";
export default {
    props:['optionsRequestSelected', 'queryFeatured', 'limit'],
    components: {
        InfiniteLoading,
        CardTrajectory,
    },
    data: () => ({
        courses: [],
        loading: false,
        queryTree :[],
        pagination: {
            current: 1,
            total: 0
        },
        typeView : 'type_courses',
        query: '',
        page: 1,
        url: '',
        queryParams:''
    }),
    mounted() {
        let query;
        if (this.optionsRequestSelected !== undefined && this.optionsRequestSelected !==null) {
            this.loadRequestFilters();
        } else if(!this.queryFeatured) {
            this.queryParams=query;
            this.UpdateCourses(query);
        }

        this.loading = true;
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
                query += 'type_course='+TypeBackCourse['filter_trajectories'];
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
            let data = await this.initQueries(this.query);
            if (data.courses) {
                if (data.courses.data.length > 0) {
                    $state.loaded();
                    this.courses.push(...data.courses.data);
                    this.url = data.url ? data.url : '';
                } else {
                    $state.complete();
                }
            } else {
                $state.complete();
            }

        },
        async UpdateCourses(query) {

        },
        async initQueries(query) {
            let page = null;
            if (this.typeView === 'type_courses') {
                page = this.pagination.current;
                this.pagination.current = 0;
            }
            let data = await getCourses('courses/search', query, page, TypeBackCourse['filter_trajectories'], );
            page= page + 1;
            console.log(data);
            console.log("courses ",this.courses);
            if('last_page' in data.courses ){
                this.pagination.total = data.courses.last_page;
            }
            this.pagination.current = page;
            this.$forceUpdate();
            console.log("update page",this.pagination);
            return data;
        },
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
.tag-bf-b20 {
    height: auto;
    padding: 8px 16px;
    border-radius: 4px;
    background-color: #1a1d1f;
    font-family: 'Poppins';
    font-size: 14px;
    font-weight: 300;
    color: #fff;
    width: max-content;
}
.tag-bf-b20>span{
    font-weight: 600;
    color: #ffb000;
}
.tag-bf-b20.cm-style>span{
    font-weight: 600;
    color: #29c0d3;
}
.b20-text{
    padding: 3px 6px;
    border-radius: 1px;
    background-color: #2e3438;
    font-size: 16px;
}
@media  (max-width: 668px) {
    .col-11 {
        margin-right: auto!important;
        margin-left: auto!important;
    }
}
@media (min-width: 1800px){
    .container{
        max-width: 1185px !important;
    }
}
</style>

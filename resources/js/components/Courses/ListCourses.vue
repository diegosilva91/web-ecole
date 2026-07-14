<template>
    <div v-if="!isLoading || isMobile" class="mb-100 mt-1">
        <div v-if="courses.length > 0">
            <div>
                <div v-show="loadPagination" class="row">
                    <div
                        v-for="(course, i) in courses"
                        :key="i"
                        class="col-12 col-sm-6 col-lg-4"
                    >
                        <course-card-new
                            :title="course.title" :ageMax="course.student_ages_max"
                            :category="course.categoryName"
                            :imgMobile="course.cover_image_mobile?url+course.cover_image_mobile:null"
                            :ageMin="course.student_ages_min" :img="url+course.cover_image"
                            :url="course.newLink"
                            :price="course.price_total" :id="course.id"
                            :startAt="course.start_at"
                            :discount="course.discount"
                            :sessions="course.duration"
                            :priceHour="course.price_per_hour"
                            :typeCourse="course.type_course"
                            :subtypeCourse="course.subtype_course"
                            :rating="course.avg_reviews"
                            :valorations="course.total_reviews|parametrized"
                        ></course-card-new>
                    </div>
                </div>
                <div v-show="!loadPagination" class="row mt-100 list-loading-inside" slot="spinner">
                    <v-progress-circular
                            indeterminate
                            color="#5c2767"
                            class="mx-auto">
                    </v-progress-circular>
                </div>

            </div>
            <template v-if="paginated===true">
                <div v-if="pagination.total>1" class="row d-flex align-self-end justify-content-end mt-4 mb-140">
                    <v-pagination
                            color="#29c0d3"
                            v-model="pagination.current"
                            :length="pagination.total"
                            total-visible="4"
                            @input="onPageChange"
                    ></v-pagination>
                </div>
            </template>
            <template v-else-if="infiniteScroll">
                <infinite-loading @infinite="infiniteHandler"  ref="infiniteLoading">
                    <div class="row mt-100" slot="spinner">
                        <v-progress-circular
                                indeterminate
                                color="#5c2767"
                                class="mx-auto">
                        </v-progress-circular>
                    </div>
                    <div slot="no-more"></div>
                    <div slot="no-results"></div>
                </infinite-loading>
            </template>
        </div>
        <div v-else-if="!isLoading" class="col-12 mt-50">
            <img src="/assets/images/filters/error-busqueda.svg" alt="" class="row mx-auto"/>
        </div>
        <div v-else class="mb-100">
            <div class="row mt-100" slot="spinner">
                <v-progress-circular
                        indeterminate
                        color="#5c2767"
                        class="mx-auto">
                </v-progress-circular>
            </div>
        </div>
    </div>
    <div v-else class="mb-100">
        <div class="row mt-100" slot="spinner">
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

let today = new Date();
export default {
    name: "ListCourses",
    components: {
        InfiniteLoading,
    },
    props: [
        'coursesData',
        'url',
        'paginated',
        'page',
        'infiniteScroll',
        'IsActiveQuerySearch',
        'loadingFather',
        'isLoading',
        'isMobile'
    ],
    data() {
        return {
            courses: [],
            loading: false,
            start_at: '',
            pagination: {
                current: 1,
                total: 0
            },
            list: [],
            noResults : false,
            loadPagination : false,
        }
    },
    mounted() {
    },
    watch: {
        courses:function(value){
            if(this.infiniteScroll === true && this.paginated!==true && this.pagination.current===1 && this.isMobile===true && this.loadingFather) {
                if (value.length === 0) {
                    this.loading = false;
                }
            }
        },
        loadingFather : function (value) {
            this.loading = value;
        },
        pagination: function (value,old){
            if('current' in value && 'current' in old && this.paginated===true){
                if(value.current !== value.current){
                    this.loading=true;
                }
            }
        },
        page: function (value){
            if('total' in value){
                this.pagination.total= this.page.total
            }
            if('current' in value){
                this.pagination.current= this.page.current;
            }
        },
        coursesData: function (value,old) {
            this.loadPagination= true;
            if (typeof value === 'object') {
                if (value.data) {//pagination
                    this.courses = value.data
                    if (this.paginated === true && value.last_page) {
                        this.pagination.total = value.last_page ;
                    }
                    if(value.current_page ){
                        this.pagination.current = value.current_page;
                    }
                    if(value.data.length>=0){
                        this.loading = true
                    }
                    this.noResults = false;
                    if('length' in old && 'length' in value.data){
                        if(old.length>=0 && value.data.length===0 ){
                            this.noResults = true;
                        }
                    }
                } else {
                    if (this.infiniteScroll === true) {
                        if(value.length>0){
                            this.courses.push(...value);
                        }
                        else{
                            this.courses=[];
                        }
                        this.loading = true;
                        this.noResults = false;
                    }
                    else{//tags
                        this.courses=value;
                        this.loading = true;
                        this.noResults = false;
                        if('length' in old && 'length' in value){
                            if(old.length>=0 && value.length===0 && this.pagination.total<=0){
                                // this.loading = false;
                                this.noResults = true;
                            }
                        }
                        if('data' in old && 'length' in value){
                            if(old.data.length>0 && value.length===0 && this.pagination.total<=0){
                                // this.loading = false;v
                                this.noResults = true;
                            }
                        }
                    }
                    if(this.page && 'total' in this.page){
                        this.pagination.total= this.page.total;
                    }
                    if(this.page && 'current' in this.page){
                        this.pagination.current= this.page.current;
                    }
                    if(value.length>=0 && this.page === undefined){
                        this.loading = true
                    }
                }
            }
        },
    },
    methods: {
        onPageChange() {
            let vm = this;
            vm.loadPagination =  false;
            this.$emit('onPageChange', vm.pagination)
            // this.loading = false;
        },
        async infiniteHandler($state) {
            let vm = this;
            vm.pagination.current = vm.pagination.current + 1;
            this.$emit('onScrollInfiniteChange', $state, vm.pagination);
            // this.loading = false;
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

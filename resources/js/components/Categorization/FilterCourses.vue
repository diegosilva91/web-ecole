<template>
    <div>
        <!-- BREADCRUMB -->
        <div class="breadcrumb-courses mt-md-10">
            <v-container fluid ref="breadcrumbCourses" :class="{'d-none':filters}" class="overflow-menu">
                    <div class="breadcrumb-courses__container">
                        <div class="d-flex ml-3 ml-md-0 mr-6">
                            <a href="/es"><img class="breadcrumb-courses__home-icon" src="/assets/images/icons/house.svg" alt=""></a>
                            <template v-for="(breads, i) in breadCrumb">
                                <img class="mx-2" src="/assets/images/icons/arrow_menu.svg" alt="">
                                <h2
                                    :class="{ 'text-muted no-pointer': !breads.title }"
                                    class="breadcrumb-courses__text"
                                    @click="
                                        queryList = '';
                                        activeTitle = false;
                                        filterCourseTypes(courseType);
                                        eventOnBreadCrumbIsMobile();
                                        applyFilters()
                                    "
                                >
                                    {{ courseType === 'filter_trajectories' ? 'Trayectorias' : 'Cursos intensivos' }}
                                </h2>
                                <img v-show="breads.title" class="mx-2" src="/assets/images/icons/arrow_menu.svg" alt="">
                                <h2
                                    v-show="breads.title"
                                    :class="{ 'text-muted no-pointer': !breads.categories.title }"
                                    class="breadcrumb-courses__text"
                                    @click="
                                        eventOnBreadCrumb(breads.title, breads.slug,'areas');
                                        eventOnBreadCrumbIsMobile();
                                    "
                                >
                                    {{ breads.title }}
                                </h2>
                                <template v-if="breads.categories!==undefined">
                                    <img v-show="breads.categories.title" class="mx-2"
                                        src="/assets/images/icons/arrow_menu.svg" alt="">
                                    <h2 v-show="breads.categories.title"
                                        :class="{'text-muted no-pointer':!breads.categories.specializations.title}"
                                        class="breadcrumb-courses__text"
                                        @click="eventOnBreadCrumb(breads.categories.title, breads.categories.slug,'categories');eventOnBreadCrumbIsMobile();">
                                        {{ breads.categories.title }}</h2>
                                    <template v-if="breads.categories.specializations.title!==undefined">
                                        <img v-show="breads.categories.specializations.title" class="mx-2"
                                            src="/assets/images/icons/arrow_menu.svg" alt="">
                                        <h2 v-show="breads.categories.specializations.title"
                                            class="breadcrumb-courses__text text-muted no-pointer">
                                            {{ breads.categories.specializations.title }}</h2>
                                    </template>
                                </template>
                                <template v-if="breads.tag!==undefined">
                                    <img v-show="breads.tag.title" class="mx-2"
                                        src="/assets/images/icons/arrow_menu.svg" alt="">
                                    <h2 v-show="breads.tag.title" class="breadcrumb-courses__text">
                                        {{ breads.tag.title }}</h2>
                                </template>
                                <template v-if="breads.search!==undefined">
                                    <img v-show="breads.search.title" class="mx-2"
                                        src="/assets/images/icons/arrow_menu.svg" alt="">
                                    <h2 v-show="breads.search.title" class="breadcrumb-courses__text">
                                        {{ breads.search.title }}</h2>
                                </template>
                            </template>
                        </div>
                    </div>
            </v-container>
        </div>

        <!-- FILTER BUTTON MOBILE -->
        <div class="d-block d-lg-none">
            <div v-show="filters" class="text-center">
                <div :class="fixedTop?'fixed-top bg-white pb-3':''" class="row">
                    <div @click="showSearch()" class="col-4 pb-0 return">
                        <img class="vertical-align-icon" src="/assets/images/icons/arrow_back.svg" alt=""> Filtros
                    </div>
                    <div class="col-7 pb-0 apply text-right my-auto" @click="applyFilters()">Aplicar</div>
                </div>
            </div>

            <div
                :class="[filters ? 'd-none' : 'd-flex justify-content-center', fixedTop ? 'fixed-top bg-white pb-3' : '']"
                class="container mt-0"
            >
                <input
                    v-model="search"
                    id="searchInpt"
                    class="search-input text-dark col-7 mr-3"
                    type="text"
                    placeholder="Buscar Cursos"
                    @input="updateSearch"
                    @keyup.enter="updateSearch('enter')"
                />
                <div @click="handlePanelFilter()" class="filters col-3 d-flex">
                    <img class="my-auto mr-2" src="/assets/images/icons/filters.svg" width="16" height="11" alt=""/> Filtros
                </div>
            </div>
        </div>

        <!-- CONTENT -->
        <v-container fluid class="mt-2 mt-lg-10">
            <div class="row">

                <!-- SIDEBAR COL -->
                <div :class="[filters ? '' : 'd-none d-lg-block']" class="col-12 col-lg-4">
                    <div class="sidebar-content">
                        <input
                            v-model="search"
                            id="searchInpt"
                            class="d-none d-lg-block search-input text-dark"
                            type="text"
                            placeholder="Buscar Cursos"
                            @input="updateSearch"
                            @keyup.enter="updateSearch('enter')"
                        />
                        <div class="mt-4">

                            <!-- FILTER -->
                            <v-expansion-panels
                                class="course-filter-expansion-panels"
                                v-model="panel"
                                accordion
                                multiple
                                :flat='mobile'
                            >

                                <!-- COURSE TYPES GROUP EXPANSION PANEL -->
                                <v-expansion-panel id="typeCourse">
                                    <v-expansion-panel-header>
                                        TIPO DE CURSO
                                        <template v-slot:actions>
                                            <v-icon>$expand</v-icon>
                                        </template>
                                    </v-expansion-panel-header>
                                    <v-expansion-panel-content>
                                        <v-radio-group v-model="courseType" hide-details class="px-6 pb-2 mt-0">
                                            <v-radio
                                                label="Trayectorias educativas"
                                                color="#793e87"
                                                id='filter_trajectories'
                                                value='filter_trajectories'
                                                :ripple="false"
                                                @click="
                                                    typeView = 'type_courses';
                                                    activeTitle = false;
                                                    queryList = '';
                                                    filterCourseTypes('filter_trajectories');
                                                "
                                            ></v-radio>
                                            <v-radio
                                                label="Cursos intensivos"
                                                color="#793e87"
                                                id='filter_intensives'
                                                value='filter_intensives'
                                                :ripple="false"
                                                @click="
                                                    typeView = 'type_courses';
                                                    activeTitle = false;
                                                    queryList = '';
                                                    filterCourseTypes('filter_intensives');
                                                "
                                            ></v-radio>
                                        </v-radio-group>
                                    </v-expansion-panel-content>
                                    <hr v-show="mobile">
                                </v-expansion-panel>

                                <!-- AREAS GROUP EXPANSION PANEL -->
                                <v-expansion-panel id="area">
                                    <v-expansion-panel-header>
                                        AREAS
                                        <template v-slot:actions>
                                            <v-icon>
                                                $expand
                                            </v-icon>
                                        </template>
                                    </v-expansion-panel-header>
                                    <v-expansion-panel-content>

                                        <!-- AREAS EXPANSION PANELS -->
                                        <v-expansion-panels v-model="areasExpansionPanels" accordion flat class="area-filter-expansion-panels">
                                            <v-expansion-panel
                                                v-for="(option, i, index) in treeFilters[courseType]"
                                                :key="i"
                                                class="pt-2 px-6"
                                            >
                                                <v-expansion-panel-header
                                                    hide-actions
                                                    class="align-start p-0 mb-2"
                                                    @click="filterAreaClicked(option, i, index)"
                                                >
                                                    <template v-slot:default="{ open }">
                                                        <v-icon small class="flex-grow-0 mr-2">
                                                            {{ open ? mdiMinus : mdiPlus }}
                                                        </v-icon>
                                                        <span>
                                                            {{ option.title }}
                                                        </span>
                                                    </template>
                                                </v-expansion-panel-header>
                                                <v-expansion-panel-content>
                                                    <table
                                                        class="category-filter-radio-button ml-3 mb-2"
                                                        @click='
                                                            typeView = "type_courses";
                                                            activeTitle = true;
                                                            showMore(i, "areas");
                                                            loadList(option.title, i, "areas");
                                                            updateBreadCrumb(option.slug, option.title, "areas")
                                                        '
                                                    >
                                                        <tr>
                                                            <td>
                                                                <input v-model="categoriesInput" type='radio' :id='"all-" + i' :value='"all-" + i' :name='i'>
                                                            </td>
                                                            <td>
                                                                <label class='pl-2 mb-0'>Todos los cursos</label>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <template v-for="(category, j, index) in option.categories">
                                                        <table
                                                            class="category-filter-radio-button ml-3 mb-2"
                                                            :key="j"
                                                            @click="
                                                                typeView = 'type_courses';
                                                                activeTitle = true;
                                                                showMore(j, 'categories');
                                                                loadList(category.title, j, 'categories');
                                                                updateBreadCrumb(category.slug, category.title, 'categories')
                                                            "
                                                        >
                                                            <tr>
                                                                <td>
                                                                    <input v-model="categoriesInput" type='radio' :id='j' :value='j' :name='i'>
                                                                </td>
                                                                <td>
                                                                    <label :for='j' class='pl-2 mb-0'>{{ category.title }}</label>
                                                                </td>

                                                            </tr>
                                                        </table>
                                                        <div class="specialization-filter-selector mb-2" v-show="readMore['categories'] === j" :key="j + index">
                                                            <template v-for="(specialization, h, index) in category.specialization">
                                                                <label
                                                                    v-if="index === 0"
                                                                    v-show="readMore['categories'] === j && readMore['areas'] === i"
                                                                    :key="h"
                                                                    class="specialization-filter-selector__label ml-4 bg-esp"
                                                                    @click='showMore(!readMore[`choose${j}`], `choose${j}`);'
                                                                >
                                                                    <div class="d-flex">
                                                                        <span class="op-65">Elije especialización</span>
                                                                        <span class="ml-10">
                                                                            <v-icon :class="{'arrow-rotate':readMore[`choose${j}`]}" color="#793e87">
                                                                                $expand
                                                                            </v-icon>
                                                                        </span>
                                                                    </div>
                                                                </label>
                                                                <div
                                                                    v-show="readMore['categories'] === j && readMore['areas'] === i && readMore[`choose${j}`]"
                                                                    :key="h+index"
                                                                >
                                                                    <ul class="pl-4">
                                                                        <hr class="mt-0 mb-0 hr-esp">
                                                                        <li
                                                                            :class="{'bg-esp-active': readMore['specializations'] === h}"
                                                                            class="specialization-filter-selector__item-li bg-esp"
                                                                            @click="
                                                                                typeView = 'type_courses';
                                                                                activeTitle = true;
                                                                                showMore(h, 'specializations');
                                                                                loadList(specialization.title, h, 'specializations');
                                                                                updateBreadCrumb(specialization.slug, specialization.title, 'specializations')
                                                                            "
                                                                        >
                                                                            {{ specialization.title }}
                                                                        </li>
                                                                        <hr class="mt-0 mb-0 hr-esp">
                                                                    </ul>
                                                                </div>
                                                            </template>
                                                        </div>
                                                    </template>
                                                </v-expansion-panel-content>
                                            </v-expansion-panel>
                                        </v-expansion-panels>

                                    </v-expansion-panel-content>
                                    <hr v-show="mobile">
                                </v-expansion-panel>

                                <!-- AGES EXPANSION PANEL -->
                                <v-expansion-panel id="age">
                                    <v-expansion-panel-header>
                                        EDAD
                                        <template v-slot:actions>
                                            <v-icon>$expand</v-icon>
                                        </template>
                                    </v-expansion-panel-header>
                                    <v-expansion-panel-content>
                                        <fieldset id='group3' class="age-filter-fieldset pl-6 pr-6">
                                            <input
                                                type='checkbox'
                                                id='6-8'
                                                value='6-8'
                                                v-model="age"
                                                @click="searchAge($event);"
                                            >
                                            <label for='6-8' class='pl-2'>6-8 años</label>
                                            <br>
                                            <input
                                                type='checkbox'
                                                id='8-10'
                                                value='8-10'
                                                v-model="age"
                                                @click="searchAge($event);"
                                            >
                                            <label for='8-10' class='pl-2'>8-10 años</label>
                                            <br>
                                            <input
                                                type='checkbox'
                                                id='10-12'
                                                value='10-12'
                                                v-model="age"
                                                @click="searchAge($event);"
                                            >
                                            <label for='10-12' class='pl-2'>10-12 años</label>
                                            <br>
                                            <input
                                                type='checkbox'
                                                id='12-16'
                                                value='12-16'
                                                v-model="age"
                                                @click="searchAge($event);"
                                            >
                                            <label for='12-16' class='pl-2'>12-16 años</label>
                                        </fieldset>
                                    </v-expansion-panel-content>
                                    <hr v-show="mobile">
                                </v-expansion-panel>
                            </v-expansion-panels>
                        </div>
                    </div>
                </div>

                <!-- MAIN COL -->
                <div
                    v-if="typeView === 'type_courses'"
                    :class="{ 'd-none': filters }"
                     class="col-11 col-lg-8 mx-auto mx-md-none ml-lg-0"
                >
                    <v-row v-if="!filters" align="end">
                        <v-col>
                            <h3 v-if="activeTitle === false && search === ''">
                                {{ courseType === 'filter_trajectories' ? 'Trayectorias' : 'Cursos intensivos' }}
                                <span></span>
                            </h3>
                            <h3 v-else>
                                {{ courseType === 'filter_trajectories' ? 'Trayectorias de' : 'Cursos intensivos de' }}
                                <span>{{ title }}</span>
                            </h3>
                        </v-col>
                        <v-col cols="12" md="auto">
                            <h6
                                v-show="courseType === 'filter_trajectories'"
                                class="text-no-wrap"
                                @click="openModalTrajectory()"
                            >¿Qué son las trayectorias educativas?</h6>
                            <h6
                                v-show="courseType === 'filter_intensives'"
                                class="text-no-wrap"
                                @click="openModalCourse()"
                            >¿Qué son los cursos intensivos?</h6>
                        </v-col>
                    </v-row>

                    <template v-if="courseType==='filter_trajectories' &&  queryList !==null">
                        <TrajectoriesList :hiddentitle="true" :hiddenfilter="true" :morebtn="false"
                                          :paginated="propsView.paginated" :infiniteScroll="propsView.infiniteScroll"
                                          :page="pagination"
                                          :coursesData="courses" :IsActiveQuerySearch="IsActiveQuerySearch" :url="url"
                                          :loadingFather="loadingChild"
                                          :isLoading="getCoursesIsLoading"
                                          @onPageChange="onPageChange" :isMobile="isMobile"
                                          @onScrollInfiniteChange="onScrollInfiniteChange"></TrajectoriesList>
                    </template>
                    <template v-else-if="courseType==='filter_intensives' && queryList !==null">
                        <ListCourses :url="url" :page="pagination"
                                     :paginated="propsView.paginated" :infiniteScroll="propsView.infiniteScroll"
                                     :coursesData="courses" :IsActiveQuerySearch="IsActiveQuerySearch"
                                     :loadingFather="loadingChild" :isMobile="isMobile"
                                     :isLoading="getCoursesIsLoading"
                                     @onPageChange="onPageChange"
                                     @onScrollInfiniteChange="onScrollInfiniteChange"
                        ></ListCourses>
                    </template>
                </div>

                <div
                    v-else-if="!filters && typeView === 'type_tags'"
                    class="col-11 col-lg-8 mx-auto mx-md-none ml-lg-0"
                >
                    <v-row align="end">
                        <v-col>
                            <h3 class="mb-2 mb-lg-0 ml-mob-15">
                                Trayectorias de <span>{{ title }}</span>
                            </h3>
                        </v-col>
                        <v-col cols="12" md="auto">
                            <h6
                                v-show="courseType === 'filter_trajectories'"
                                @click="openModalTrajectory()"
                                class="text-no-wrap"
                            >¿Qué son las trayectorias educativas?</h6>
                        </v-col>
                    </v-row>
                    <template>
                    <TrajectoriesList
                        :hiddentitle="true"
                        :hiddenfilter="true"
                        :morebtn="false"
                        :paginated="propsView.paginated"
                        :infiniteScroll="false"
                        :coursesData="coursesTags.filter_trajectories"
                        :IsActiveQuerySearch="IsActiveQuerySearch"
                        :url="url"
                        :loadingFather="loadingChild"
                        :isMobile="isMobile"
                        :isLoading="getCoursesIsLoading"
                    ></TrajectoriesList>
                    </template>
                    <v-row align="end">
                        <v-col>
                            <h3 class="mb-2 mb-lg-0 ml-mob-15">
                                Intensivos de <span>{{ title }}</span>
                            </h3>
                        </v-col>
                        <v-col cols="12" md="auto">
                            <h6
                                v-show="courseType === 'filter_trajectories'"
                                @click="openModalCourse()"
                                class="text-no-wrap"
                            >¿Qué son los cursos intensivos?</h6>
                        </v-col>
                    </v-row>
                    <template>
                        <ListCourses
                                :queryProps="queryList"
                            :url="url"
                            :paginated="propsView.paginated"
                            :infiniteScroll="false"
                            :coursesData="coursesTags.filter_intensives"
                            :IsActiveQuerySearch="IsActiveQuerySearch"
                            :isMobile="isMobile"
                            :loadingFather="loadingChild"
                            :isLoading="getCoursesIsLoading"
                        ></ListCourses>
                    </template>
                    <v-row align="end">
                        <v-col>
                            <h3 class="mb-2 mb-lg-0 ml-mob-15">
                                Campus de <span>{{ title }}</span>
                            </h3>
                        </v-col>
                        <v-col cols="12" md="auto">
                            <h6
                                v-show="courseType === 'filter_trajectories'"
                                @click="openModalCampus()"
                                class="text-no-wrap"
                            >¿Qué son los campus?</h6>
                        </v-col>
                    </v-row>
                    <template>
                        <ListCourses
                                :queryProps="queryList"
                            :url="url"
                            :paginated="propsView.paginated"
                            :infiniteScroll="false"
                            :coursesData="coursesTags.filter_campus"
                            :IsActiveQuerySearch="IsActiveQuerySearch"
                            :isMobile="isMobile"
                            :loadingFather="loadingChild"
                            :isLoading="getCoursesIsLoading"
                        ></ListCourses>
                    </template>
                </div>
            </div>
            <TrajectoryModal/>
        </v-container>
    </div>
</template>

<script>
import { mapWritableState } from 'pinia';
import { useAppStore } from '../../store/app';
import { mdiMinus, mdiPlus } from '@mdi/js';
import ListCourses from '../Courses/ListCourses.vue'
import TrajectoryModal from '../Modals/TrajectoryModal.vue';
import Event from "../../event";
import TrajectoriesList from "../Trajectories/TrajectoriesList";
import {getCourses, TypeCourse, TypeBackCourse} from "../../courses/courses";
import _debounce from 'lodash/debounce';

const TypeView = {
    type_tags: 'type_tags',
    type_courses: 'type_courses',
}
export default {
    components: {
        ListCourses,
        TrajectoryModal,
        TrajectoriesList
    },
    props: ['treeFilters'],
    data() {
        return {
            areasExpansionPanels: undefined,
            fixedTop: false,
            filters: false,
            courseType: 'filter_trajectories',
            typeView: null,
            propsView: {
                paginated: true,
                infiniteScroll: false,
            },
            pagination: {
                current: 1,
                total: 0
            },
            courses: [],
            coursesTags: {
                'filter_intensives': [],
                'filter_trajectories': [],
                'filter_campus': []
            },
            getCoursesIsLoading: false,
            url: '',
            readMore: {},
            previousTitle:'',
            title: '',
            search: '',
            categoriesInput:[],
            queryList: null,
            queryTree: {},
            querySearch: '',
            queryCourseType: '',
            queryAge: '',
            IsActiveQuerySearch: false,
            mobile: false,
            age: [],
            ageNum: [],
            breadCrumb: {
                'areas': {
                    'categories': {
                        'specializations': {}
                    },
                }
            },
            isMobile: false,
            panel: [0, 1, 2],
            activeTitle : false,
            loadingChild : false,
            mdiMinus,
            mdiPlus
        }
    },

    computed: {
        ...mapWritableState(useAppStore, { appStoreOverlay: 'overlay' }),
    },

    mounted() {
        if (window.innerWidth <= 430) {
            this.mobile = true;
        }
    },

    created() {
        window.addEventListener('scroll', this.onScroll);
        this.onResize();
        window.addEventListener("resize", this.onResize, {passive: true});
        if (window.innerWidth <= 430) {
            this.mobile = true;
        }
        if ('optionsRequestSelected' in this.treeFilters) {
            this.queryList = '';
            this.loadRequestFilters();
        }
    },

    destroyed() {
        window.removeEventListener('scroll', this.onScroll);
    },

    watch: {
        age: function (age) {
            if (this.age.length > 0) {
                this.queryAge = this.parameterizeArray('age', this.age,);
            } else {
                this.queryAge = '';
            }
            if (!this.isMobile) {
                this.applyFilters();
            }
        },
        courseType: function () {
            this.pagination.current = 1;
            if (!this.isMobile) {
                this.applyFilters();
            }
        },

        queryList: async function (value) {
            if (value) {
                if (this.isMobile) {
                    this.courses=[];
                }
                 await this.initQueries();
            }
        }
    },
    methods: {
        async onScrollInfiniteChange($state, value) {
            let vm = this;
            this.pagination.current = value.current;
            if(this.pagination.current  < this.pagination.total+1){
                let data = await this.initQueries();
                if (data.courses) {
                    if (data.courses.data.length > 0) {
                        $state.loaded();
                        vm.courses = data.courses.data;
                    } else {
                        $state.complete();
                    }
                } else {
                    $state.complete();
                }
            }else{
                $state.complete();
            }
        },
        async onPageChange(value) {
            window.scrollTo(0,0);
            this.pagination.current = value.current;
            this.loadingChild =false;
            let data =await this.initQueries();
            this.courses = data.courses ? data.courses : [];
        },
        async initQueries() {
            if(this.propsView.paginated!==true && this.pagination.current===1){
                this.loadingChild = false;
                this.courses = [];
            }else{
                if (Object.keys(this.queryTree).length > 0 || this.queryAge !== '' || this.querySearch !== '') {
                    this.loadingChild =false;
                }else{
                    this.loadingChild =true;
                }
            }
            this.pagination.total = 0;
            let page=null;
            let thread = 'courses';
            if (this.typeView === 'type_courses') {
                page = this.pagination.current;
                this.pagination.current =0;
            }
            this.getCoursesIsLoading = true;
            let data = await getCourses('courses/search', this.queryList, page, TypeBackCourse[this.courseType],thread);
            this.getCoursesIsLoading = false;
            if(data.courses){
                if (this.typeView === TypeView.type_courses) {
                    if (this.courses.length === 0) {
                        this.courses = data.courses ? data.courses : [];
                    } else {
                        this.courses = data.courses.data;
                    }
                    if('last_page' in data.courses ){
                        this.pagination.total = data.courses.last_page;
                    }
                    this.pagination.current = page;
                    this.$forceUpdate();
                } else {
                    if ('items' in data.courses) {
                        if (data.courses.items[0] !== undefined) {
                            this.coursesTags['filter_intensives'] = data.courses.items[0];
                        }
                        if (data.courses.items[1] !== undefined) {
                            this.coursesTags['filter_trajectories'] = data.courses.items[1];
                        }
                        if (data.courses.items[2] !== undefined) {
                            this.coursesTags['filter_campus'] = data.courses.items[2];
                        }
                    }
                }
                this.loadingChild = true;
                this.url = data.url ? data.url : '';
            }
            return data;
        },

        handlePanelFilter() {
            this.filters = true;
            window.scrollTo(0,0);
        },

        showSearch() {
            this.filters = false;
            window.scrollTo(0,0);
        },
        loadRequestFilters() {
            let indexArea;
            let slugArea;
            let titleArea;
            let indexCategories;
            let slugCategories;
            let titleCategories
            let index;
            let slug;
            let title;

            if (this.mobile) {
                this.paginated = false;
                this.propsView.paginated = false;
                this.propsView.infiniteScroll = true;
            } else {
                this.paginated = true;
                this.propsView.paginated = true;
                this.propsView.infiniteScroll = false;
            }
            if ('view_type' in this.treeFilters.optionsRequestSelected) {
                this.typeView = TypeView[this.treeFilters.optionsRequestSelected.view_type];
                if (this.typeView === 'type_courses') {
                    if ('type_course' in this.treeFilters.optionsRequestSelected) {
                        this.courseType = TypeCourse[this.treeFilters.optionsRequestSelected.type_course];
                    } else {
                        this.courseType = 'filter_trajectories';
                    }
                } else {
                    this.courseType = 'filter_trajectories';
                }
            } else {
                this.typeView = TypeView.type_courses;
            }

            if (this.typeView === TypeView.type_courses) {
                this.queryCourseType = `type_course=${TypeBackCourse[this.courseType]}`;
                if ('area' in this.treeFilters.optionsRequestSelected) {
                    indexArea = 'areas'
                    slugArea = this.treeFilters.optionsRequestSelected.area.slug;
                    titleArea = this.treeFilters.optionsRequestSelected.area.title;
                    this.showMore(slugArea, indexArea);
                    this.updateBreadCrumb(slugArea, titleArea, indexArea);
                    this.loadList(titleArea, slugArea, indexArea);
                    this.activeTitle = true;
                    if ('categories' in this.treeFilters.optionsRequestSelected) {
                        indexCategories = 'categories'
                        slugCategories = this.treeFilters.optionsRequestSelected.categories.slug;
                        titleCategories = this.treeFilters.optionsRequestSelected.categories.title;

                        this.showMore(slugCategories, indexCategories);
                        this.updateBreadCrumb(slugCategories, titleCategories, indexCategories);
                        this.loadList(titleCategories, slugCategories, indexCategories);
                    }
                    if (this.treeFilters.optionsRequestSelected.specializations) {
                        index = 'specializations'
                        slug = this.treeFilters.optionsRequestSelected.specializations.slug;
                        title = this.treeFilters.optionsRequestSelected.specializations.title;
                        this.showMore(slug, index);
                        this.updateBreadCrumb(slug, title, index);
                        this.loadList(title, slug, index);
                    }

                }
                // else{
                //     this.applyFilters();
                // }
            } else {
                if ('tag' in this.treeFilters.optionsRequestSelected) {
                    title = slug = this.treeFilters.optionsRequestSelected.tag[0].title;
                    slug = slug = this.treeFilters.optionsRequestSelected.tag[0].slug;
                    index = 'tag';
                    this.showMore(slug, index);
                    this.updateBreadCrumb(slug, title, index);
                    this.loadList(title, slug, index);
                }
            }
            this.applyFilters();

        },
        applyFilters() {
            let query = '';
            if (this.queryCourseType !== '') {
                query += this.queryCourseType;
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
            if (this.querySearch !== '') {
                query += this.querySearch;
            }
            if (this.queryAge !== '') {
                query += this.queryAge;
            }
            this.queryList = '?' + query;
            this.filters = false;
            window.scrollTo(0,0);
            if (this.$refs.breadcrumbCourses) {
                this.$nextTick(() => {
                    this.$refs.breadcrumbCourses.scrollLeft = this.$refs.breadcrumbCourses.scrollWidth;
                })
            }
        },

        openModalTrajectory() {
            Event.$emit('openModalTrajectory');
        },
        openModalCourse() {
            Event.$emit('openModalCourse');
        },
        openModalCampus() {
            Event.$emit('openModalCampus');
        },

        /**
         * Actions to run when a filter 'area' is clicked
         * @param {Object} option Tree filter 'area' option
         * @param {string} key Key of tree filter 'area' option
         * @param {number} index Index of 'areas' expansion panels
         * @returns {void}
         */
        filterAreaClicked(option, key, index) {
            this.typeView = 'type_courses';
            this.activeTitle = true;
            this.querySearch = '';
            this.showMore(key, 'areas');
            this.loadList(option.title, key, 'areas');
            this.updateBreadCrumb(option.slug, option.title, 'areas');

            // If filter 'area' clicked is opened
            if (this.areasExpansionPanels === index) {
                this.categoriesInput = null;
                this.readMore = {};
                this.queryTree = {};
                this.queryList = '';
                this.activeTitle = false;
                this.$set(this.breadCrumb['areas'], 'title', null);
                this.$set(this.breadCrumb['areas'], 'slug', null);

                if (!this.isMobile) {
                    this.applyFilters();
                }
            }
        },

        filterCourseTypes(type_course) {
            this.areasExpansionPanels = false;
            this.pagination.current = 1;
            this.courseType='';
            this.courseType=type_course;
            this.breadCrumb = {'areas': {'categories': {'specializations': {}},}};
            this.search = '';
            this.categoriesInput=[];
            this.title = '';
            this.previousTitle='';
            this.readMore = this.queryTree = {};
            this.querySearch = '';
            this.queryCourseType = `type_course=${TypeBackCourse[type_course]}`;
            this.$forceUpdate();
        },

        showMore(id, type) {
            if (type === 'areas') {
                this.categoriesInput = 'all-' + id;
                this.queryTree = {};
            } else {
                this.categoriesInput = [];
            }

            if (type === 'categories') {
                this.readMore = {
                    areas: this.readMore['areas']
                };
                this.queryTree = {
                    areas: this.queryTree['areas']
                };
                this.categoriesInput = id;
            }
            this.$set(this.readMore, type, id);
        },

        loadList(title, slug, index) {
            this.title = title;
            if (this.readMore[index] === slug) {
                this.queryTree[index] = `&${index}=${slug}`;
                if (index === 'tag') {
                    this.queryTree[index] = `&${index}[]=${slug}`;
                }
            }
            if (!this.isMobile) {
                this.applyFilters();
            } else {
                window.scrollTo(0,0);
            }
        },

        updateBreadCrumb(slug, title, index) {
            this.pagination.current = 1;
            if (index === 'areas') {
                this.$set(this.breadCrumb['areas'], 'title', title);
                this.$set(this.breadCrumb['areas'], 'slug', slug);
                this.$set(this.breadCrumb['areas'], 'categories', {'specializations': {} });                    
                this.readMore['categories'] = null;
            } else if (index === 'categories') {
                this.breadCrumb['areas'][index]['title'] = title;
                this.breadCrumb['areas'][index]['slug'] = slug;
                this.$set(this.breadCrumb['areas'][index], 'specializations', {});
            } else if (index === 'specializations') {
                this.breadCrumb['areas']['categories']['specializations']['title'] = title;
                this.breadCrumb['areas']['categories']['specializations']['slug'] = slug;
            }
            if (index !== 'search' && index !== 'tag') {
                this.querySearch = '';
                this.previousTitle = '';
                this.search='';
                this.$set(this.breadCrumb['areas'], 'search', {});
            } else if (index === 'search' || index === 'tag') {
                this.$set(this.breadCrumb['areas'], 'search', {'title': title});
            }
            this.$forceUpdate();
        },

        updateSearch: _debounce(function(method) {
            this.pagination.current=1;
            if (this.search.length >= 3 || method === 'enter') {
                if(Object.keys(this.readMore).length!==0  && this.previousTitle===''){
                    this.previousTitle = this.title;
                    this.title= this.search;
                }else{
                    this.title= this.search;
                }
                this.querySearch = '&search=' + this.search;
                this.updateBreadCrumb(this.search, this.search, "search");
                this.applyFilters();
                //this.IsActiveQuerySearch=true;
            } else {
                this.querySearch = '';
                if(Object.keys(this.readMore).length===0){
                    this.title = this.search;
                    this.previousTitle= '';
                }
                if(this.previousTitle==='' && this.search !== this.title){
                    this.previousTitle = this.title;
                    this.title = this.search;
                }
                this.updateBreadCrumb('', '', "search");
                this.applyFilters();
                //this.IsActiveQuerySearch=false;
            }
        }, 600),

        searchAge(event) {
            this.pagination.current=1;
        },
        eventOnBreadCrumb(title, slug, index) {
            this.pagination.current=1;
            this.typeView = TypeView.type_courses;
            // showMore(j,'categories');loadList(category.title,j,'categories');updateBreadCrumb(category.slug,category.title,'categories')
            this.showMore(slug, index);
            this.loadList(title, slug, index);
            this.updateBreadCrumb(slug, title, index);
            if(index!=='areas'){
                this.categoriesInput=[];
            }
        },
        eventOnBreadCrumbIsMobile(){
            if(this.isMobile){
                this.applyFilters();
            }
        },
        onScroll() {
            this.fixedTop = window.scrollY >= 90;
        },
        onResize() {
            this.isMobile = window.innerWidth < 768;
        },
        parameterizeArray(key, arr, operator) {
            if (arr.length === 0)
                return ''
            if (operator === '&')
                return '&' + key + '[]=' + arr.join(',')
            return '&' + key + '[]=' + arr.join('&' + key + '[]=')
        },
    }
}
</script>

<style lang="scss" scoped>
@import '~vuetify/src/styles/styles.sass';

.container--fluid {
    @media #{map-get($display-breakpoints, 'sm-and-up')} {
        padding-right: 9%;
        padding-left: 9%;
    }

    @media #{map-get($display-breakpoints, 'xl-only')} {
        padding-right: 15%;
        padding-left: 15%;
    }
}

.sidebar-content {
    margin-bottom: 140px;
    position: sticky;
    top: 24px;
}

.breadcrumb-courses {
    position: relative;

    &:before,
    &:after {
        content: '';
        display: block;
        height: 100%;
        position: absolute;
        top: 0;
        width: 24px;
    }

    &:before {
        background: linear-gradient(90deg, white, transparent);
        left: 0;
    }

    &:after {
        background: linear-gradient(90deg, transparent, white);
        right: 0;
    }
}

.breadcrumb-courses__container {
    min-width: 100%;
    width: max-content;
}

.breadcrumb-courses__home-icon {
    display: block;
    max-width: none;
}

.breadcrumb-courses__text {
    font-size: 14px;
    font-weight: 500;
    color: #29c0d3;
    cursor: pointer;
    margin-top: auto;
    margin-bottom: auto;
    white-space: nowrap;
}

.specialization-filter-selector__label,
.specialization-filter-selector__item-li,
.category-filter-radio-button input,
.category-filter-radio-button label,
.age-filter-fieldset input,
.age-filter-fieldset label {
    cursor: pointer;
}

.course-filter-expansion-panels {
    ::v-deep .v-expansion-panel-content__wrap {
        padding: {
            right: 0;
            left: 0;
        }
    }
}

.area-filter-expansion-panels.theme--light {
    font-weight: 300;

    .v-expansion-panel-header {
        min-height: 0;

        span {
            line-height: 16px;
        }
    }

    ::v-deep .v-expansion-panel--active {
        background-color: #f6f3f7;
        font-weight: 400;
    }
}

.category-filter-radio-button td {
    line-height: 21px;
    vertical-align: top;
}

.search-input {
    width: 320px;
    height: 40px;
    border-radius: 4px;
    padding-left: 40px;
    border: solid 1px rgba(52, 58, 64, 0.3);
    background-color: #ffffff;
    background: url('/assets/images/filters/search.svg') no-repeat;
    background-position: 4% 50% !important;
    font-family: 'Poppins';
    font-size: 14px;
}

.search-input::placeholder {
    padding-left: 0px;
    font-family: 'Poppins';
    font-size: 14px;
    color: rgba(52, 58, 64, 0.41);

}


.search-input::-webkit-input-placeholder { /* Chrome/Opera/Safari */
    padding-left: 0px;
    font-family: 'Poppins';
    font-size: 14px;
    color: rgba(52, 58, 64, 0.41);
}

#searchInpt::-moz-placeholder { /* Firefox 19+ */
    padding-left: 40px;
    font-family: 'Poppins';
    font-size: 14px;
    color: rgba(52, 58, 64, 0.41);
}

#searchInpt:-ms-input-placeholder { /* IE 10+ */
    padding-left: 35px;
    font-family: 'Poppins';
    font-size: 14px;
    color: rgba(52, 58, 64, 0.41);
}

.filters-box {
    width: 283px;
    height: 462px;
    padding: 15px 0;
    box-shadow: 0 0 4px 2px rgba(88, 104, 105, 0.08);
}

.v-expansion-panels {
    width: 320px !important;
}

h3 {
    font-size: 21px;
    font-weight: 600;
}

h3 > span {
    color: #803a91;
}

h6 {
    font-size: 14px;
    font-weight: 500;
    color: #29c0d3;
    text-decoration-line: underline;
    cursor: pointer;
}

.arrow-rotate {
    transform: rotate(180deg);
}

.filters {
    font-family: 'Open Sans';
    font-size: 16px;
    font-weight: 600;
    color: #29c0d3;
    max-width: 100px;
    min-width: 100px;
    height: 40px;
    padding: 6px 12px;
    border-radius: 20px;
    border: solid 1px #29c0d3;
    margin-left: 15px;
}

.apply {
    font-family: 'Poppins';
    font-size: 18px;
    font-weight: 700;
    color: #29c0d3;
}

.return {
    font-family: 'Poppins';
    font-size: 21px;
    font-weight: 600;
}

.vertical-align-icon {
    vertical-align: initial;
}

.v-expansion-panel-header {
    font-family: 'Poppins';
    font-size: 14px;
}

label {
    font-family: 'Poppins';
    font-weight: 300;
    font-size: 14px;
}

input[type=radio]:checked + label {
    font-weight: 400;
}

input[type=radio], input[type=checkbox] {
    accent-color: #793e87;
}

li {
    font-family: 'Poppins';
    font-size: 14px;
    font-weight: 300;
    cursor: default;
}

.fw-400 {
    font-weight: 400;
}

.fw-300 {
    font-weight: 300;
}

.inpt-category {
    display: inline;
}

.bg-active {
    background-color: #f6f3f7;
    padding-top: 10px;
    padding-bottom: 10px;
}

.op-65 {
    opacity: .65;
}

.pointer {
    cursor: pointer;
}

.single_courses {
    min-width: 256px;
}

.fixed-top {
    box-shadow: 0 1px 9px 0 rgba(86, 45, 96, 0.1);
}

.bg-esp {
    background-color: #fff;
    padding: 4px 8px;
    width: 220px;
}

.overflow-menu {
    overflow-x: auto;
    -ms-overflow-style: none;
    scrollbar-width: none;
}

.overflow-menu::-webkit-scrollbar {
    display: none;
}

.tag-button {
    width: 119px;
    height: 31px;
    border-radius: 8px;
    box-shadow: 0 2px 8px 0 rgba(35, 158, 173, 0.27);
    border: solid 1px #29c0d3;
    background-color: #fff;
    font-family: 'Open sans';
    font-size: 14px;
    font-weight: 600;
    color: #29c0d3;
}

.hr-esp {
    width: 220px;
}

.no-pointer {
    cursor: default !important;
}

.bg-esp-active {
    color:#793e87 !important;
    font-weight: 500;
}

@media (max-width: 430px) {
    .v-expansion-panels {
        width: 100% !important;
    }

    .course-filter-expansion-panels > .v-expansion-panel > .v-expansion-panel-header {
        opacity: .5;
    }

}

@media (min-width: 431px) {
    .fixed-top {
        position: relative;
    }

    .v-expansion-panel-content {
        height: auto;
        overflow-y: auto;
    }
}
</style>

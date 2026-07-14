<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-8">

                <!-- HEADER -->
                <h2 class="h2-txt mb-8 mt-lg-40">Disponibilidad</h2>
                <p class="d-none d-lg-block p2-txt mb-0">Elige el horario que mejor se adapte a tu disponibilidad</p>

                <div>

                    <!-- DESKTOP FILTER -->
                    <v-row class="d-none d-lg-block mb-8">
                        <v-col>
                            <v-expansion-panels
                                    class="promotions-filter-desktop d-flex justify-content-start"
                            >
                                <v-col
                                        :class="selectedFilter?'col-7':'col-3'"
                                        class="pt-0 pl-0"
                                >

                                    <v-expansion-panel
                                            class="filter-item"
                                            v-show="!trajectory"
                                    >
                                        <v-expansion-panel-header class="p-0 pl-2" @click="activeModal">Fecha de inicio
                                        </v-expansion-panel-header>
                                        <v-expansion-panel-content>
                                            <v-row>
                                                <v-col
                                                        cols="6"
                                                        class="pt-0 pr-0"
                                                >
                                                    <v-checkbox
                                                            @change="updateStartAt(true)"
                                                            v-model="selectedStartAt"
                                                            label="Esta semana"
                                                            color="#793e87"
                                                            value="Esta semana"
                                                            hide-details
                                                    ></v-checkbox>
                                                    <v-checkbox
                                                            @change="updateStartAt(true)"
                                                            v-model="selectedStartAt"
                                                            label="Próxima semana"
                                                            color="#793e87"
                                                            value="Próxima semana"
                                                            hide-details
                                                    ></v-checkbox>
                                                </v-col>
                                                <v-col
                                                        cols="6"
                                                        class="pt-0"
                                                >
                                                    <v-checkbox
                                                            @change="updateStartAt(true)"
                                                            v-model="selectedStartAt"
                                                            label="Próximo mes"
                                                            color="#793e87"
                                                            value="Próximo mes"
                                                            hide-details
                                                    ></v-checkbox>
                                                    <v-checkbox
                                                            @change="updateStartAt(true)"
                                                            v-model="selectedStartAt"
                                                            label="Más adelante"
                                                            color="#793e87"
                                                            value="Más adelante"
                                                            hide-details
                                                    ></v-checkbox>
                                                </v-col>
                                            </v-row>
                                        </v-expansion-panel-content>
                                    </v-expansion-panel>

                                    <v-expansion-panel
                                            class="filter-item"
                                            v-show="trajectory"
                                    >
                                        <v-expansion-panel-header class="p-0 pl-2" @click="activeModal">Mes de inicio
                                        </v-expansion-panel-header>
                                        <v-expansion-panel-content>
                                            <v-row>
                                                <v-col
                                                        cols="4"
                                                        class="pt-0 pr-0"
                                                >
                                                    <v-checkbox
                                                            @change="updateStartAt(true)"
                                                            v-model="selectedStartAt"
                                                            :label="next_months[0].name"
                                                            color="#793e87"
                                                            :value="next_months[0].date"
                                                            hide-details
                                                    ></v-checkbox>
                                                    <v-checkbox
                                                            @change="updateStartAt(true)"
                                                            v-model="selectedStartAt"
                                                            :label="next_months[1].name"
                                                            color="#793e87"
                                                            :value="next_months[1].date"
                                                            hide-details
                                                    ></v-checkbox>
                                                </v-col>
                                                <v-col
                                                        cols="4"
                                                        class="pt-0"
                                                >
                                                    <v-checkbox
                                                            @change="updateStartAt(true)"
                                                            v-model="selectedStartAt"
                                                            :label="next_months[2].name"
                                                            color="#793e87"
                                                            :value="next_months[2].date"
                                                            hide-details
                                                    ></v-checkbox>
                                                    <v-checkbox
                                                            @change="updateStartAt(true)"
                                                            v-model="selectedStartAt"
                                                            :label="next_months[3].name"
                                                            color="#793e87"
                                                            :value="next_months[3].date"
                                                            hide-details
                                                    ></v-checkbox>
                                                    <div></div>
                                                </v-col>
                                                <v-col
                                                        cols="4"
                                                        class="pt-0"
                                                >
                                                    <v-checkbox
                                                            @change="updateStartAt(true)"
                                                            v-model="selectedStartAt"
                                                            :label="next_months[4].name"
                                                            color="#793e87"
                                                            :value="next_months[4].date"
                                                            hide-details
                                                    ></v-checkbox>
                                                </v-col>
                                            </v-row>
                                        </v-expansion-panel-content>
                                    </v-expansion-panel>

                                </v-col>

                                <v-col
                                        :class="[selectedFilter || selectedFilter3?'d-none':'col-4',selectedFilter2?'col-7':'']"
                                        class="pt-0 pl-0"
                                >

                                    <v-expansion-panel
                                            class="filter-item"
                                    >
                                        <v-expansion-panel-header class="p-0 pl-2" @click="activeModal2">Días de la semana
                                        </v-expansion-panel-header>
                                        <v-expansion-panel-content class="mt-5">
                                            <v-row class="pl-4">
                                                <v-col @click="activeDay0(true)" :class="{'day-box-active':day0}" class="day-box"
                                                    cols="3">Lunes
                                                </v-col>
                                                <v-col @click="activeDay1(true)" :class="{'day-box-active':day1}" class="day-box"
                                                    cols="3">Martes
                                                </v-col>
                                                <v-col @click="activeDay2(true)" :class="{'day-box-active':day2}" class="day-box"
                                                    cols="4">Miercoles
                                                </v-col>
                                                <v-col @click="activeDay3(true)" :class="{'day-box-active':day3}" class="day-box"
                                                    cols="3">Jueves
                                                </v-col>
                                                <v-col @click="activeDay4(true)" :class="{'day-box-active':day4}" class="day-box"
                                                    cols="3">Viernes
                                                </v-col>
                                                <v-col @click="activeDay5(true)" :class="{'day-box-active':day5}" class="day-box"
                                                    cols="3">Sábado
                                                </v-col>
                                                <v-col @click="activeDay6(true)" :class="{'day-box-active':day6}" class="day-box"
                                                    cols="4">Domingo
                                                </v-col>
                                            </v-row>
                                        </v-expansion-panel-content>
                                    </v-expansion-panel>

                                </v-col>

                                <v-col
                                        :class="[selectedFilter2?'d-none':'col-3',selectedFilter3?'col-7':'']"
                                        class="pt-0 pl-0"
                                >

                                    <v-expansion-panel
                                            class="filter-item"
                                            v-show="!trajectory"
                                    >
                                        <v-expansion-panel-header class="p-0 pl-2" @click="activeModal3">Turno del día
                                        </v-expansion-panel-header>
                                        <v-expansion-panel-content>
                                            <v-row>
                                                <v-col cols="6" class="pt-0">
                                                    <div class="dayTime-box" :class="{'dayTime-box-active':dayTime0}"
                                                        @click="activeDayTime0(true)"><img class="mr-mob-5 mr-tb-5"
                                                                                    src="/assets/images/filters/sun1.svg"
                                                                                    alt=""/>Mañana<br><span>9:00h - 14:00h</span>
                                                    </div>
                                                </v-col>
                                                <v-col cols="6" class="pt-0">
                                                    <div class="dayTime-box" :class="{'dayTime-box-active':dayTime1}"
                                                        @click="activeDayTime1(true)"><img class="mr-mob-5 mr-tb-5"
                                                                                    src="/assets/images/filters/sun2.svg"
                                                                                    alt=""/>Tarde<br><span>15:00h - 20:00h</span>
                                                    </div>
                                                </v-col>
                                            </v-row>
                                        </v-expansion-panel-content>
                                    </v-expansion-panel>

                                </v-col>
                            </v-expansion-panels>
                        </v-col>

                        <v-col class="pt-0">
                            <div v-show="!trajectory">
                                <div v-if="selectedStartAt.includes('Esta semana')" class="checkedValues mr-2">Esta
                                    Semana<span @click="closeFilter('Esta semana','start')">&times;</span></div>
                                <div v-if="selectedStartAt.includes('Próxima semana')" class="checkedValues mr-2">
                                    Próxima semana<span @click="closeFilter('Próxima semana','start')">&times;</span>
                                </div>
                                <div v-if="selectedStartAt.includes('Próximo mes')" class="checkedValues mr-2">Próximo
                                    mes<span @click="closeFilter('Próximo mes','start')">&times;</span></div>
                                <div v-if="selectedStartAt.includes('Más adelante')" class="checkedValues mr-2">Más
                                    adelante<span @click="closeFilter('Más adelante','start')">&times;</span></div>
                            </div>
                            <div v-show="trajectory">
                                <div v-if="selectedStartAt.includes(next_months[0].date)" class="checkedValues mr-2">{{next_months[0].name}}<span
                                        @click="closeFilter(next_months[0].date,'start')">&times;</span></div>
                                <div v-if="selectedStartAt.includes(next_months[1].date)" class="checkedValues mr-2">
                                    {{next_months[1].name}}<span @click="closeFilter(next_months[1].date,'start')">&times;</span></div>
                                <div v-if="selectedStartAt.includes(next_months[2].date)" class="checkedValues mr-2">
                                    {{next_months[2].name}}<span @click="closeFilter(next_months[2].name,'start')">&times;</span></div>
                                <div v-if="selectedStartAt.includes(next_months[3].date)" class="checkedValues mr-2">{{next_months[3].name}}<span
                                        @click="closeFilter(next_months[3].name,'start')">&times;</span></div>
                                <div v-if="selectedStartAt.includes(next_months[4].date)" class="checkedValues mr-2">{{next_months[4].name}}<span
                                        @click="closeFilter(next_months[4].name,'start')">&times;</span></div>
                            </div>
                            <div v-if="selectDaily.includes(0)" class="checkedValues mr-2">Lunes<span
                                    @click="closeFilter(0,'day')">&times;</span></div>
                            <div v-if="selectDaily.includes(1)" class="checkedValues mr-2">Martes<span
                                    @click="closeFilter(1,'day')">&times;</span></div>
                            <div v-if="selectDaily.includes(2)" class="checkedValues mr-2">Miércoles<span
                                    @click="closeFilter(2,'day')">&times;</span></div>
                            <div v-if="selectDaily.includes(3)" class="checkedValues mr-2">Jueves<span
                                    @click="closeFilter(3,'day')">&times;</span></div>
                            <div v-if="selectDaily.includes(4)" class="checkedValues mr-2">Viernes<span
                                    @click="closeFilter(4,'day')">&times;</span></div>
                            <div v-if="selectDaily.includes(5)" class="checkedValues mr-2">Sábado<span
                                    @click="closeFilter(5,'day')">&times;</span></div>
                            <div v-if="selectDaily.includes(6)" class="checkedValues mr-2">Domingo<span
                                    @click="closeFilter(6,'day')">&times;</span></div>
                            <div v-if="printDayTime" class="checkedValues mr-2">{{ printDayTime }}<span
                                    @click="closeFilter('','dayTime')">&times;</span></div>
                        </v-col>
                    </v-row>

                    <!-- MOBILE FILTER -->
                    <div class="d-lg-none">
                        <div :class="{ 'd-none' : hiddenSearch }" class="container">
                            <div @click="handlePanelFilter" class="container pt-0 filters text-right"><img
                                    src="/assets/images/filters/filter-icon.svg" alt=""/> Filtrar
                            </div>
                        </div>
                        <div :class="{'d-none':hiddenFilters}" id="filters">
                            <div class="container text-dark pb-0">
                                <div class="row">
                                    <div @click="showSearch" class="col-4 pb-0 cancel text-left ml-5">Cancelar</div>
                                    <div class="col-6 pb-0 apply text-right ml-4" @click="applyFilters('applyFilter')">Aplicar
                                    </div>
                                </div>
                            </div>
                            <div class="container mb-6">
                                <v-row justify="center">
                                    <v-expansion-panels
                                            class="filters-panel"
                                            accordion
                                    >
                                        <v-expansion-panel
                                                class="filter-item"
                                                v-show="!trajectory"
                                        >
                                            <v-expansion-panel-header @click="activeModal">Fecha de inicio
                                            </v-expansion-panel-header>
                                            <div class="checkedValuesMobile">{{ selectedStartAt.join(" / ") }}</div>
                                            <v-expansion-panel-content>
                                                <v-row>
                                                    <div class="pl-3">
                                                        <v-checkbox
                                                                @change="updateStartAt(false)"
                                                                v-model="selectedStartAt"
                                                                label="Esta semana"
                                                                color="#793e87"
                                                                value="Esta semana"
                                                                hide-details
                                                        ></v-checkbox>
                                                        <v-checkbox
                                                                @change="updateStartAt(false)"
                                                                v-model="selectedStartAt"
                                                                label="Próxima semana"
                                                                color="#793e87"
                                                                value="Próxima semana"
                                                                hide-details
                                                        ></v-checkbox>
                                                    </div>
                                                    <div class="pl-4">
                                                        <v-checkbox
                                                                @change="updateStartAt(false)"
                                                                v-model="selectedStartAt"
                                                                label="Próximo mes"
                                                                color="#793e87"
                                                                value="Próximo mes"
                                                                hide-details
                                                        ></v-checkbox>
                                                        <v-checkbox
                                                                @change="updateStartAt(false)"
                                                                v-model="selectedStartAt"
                                                                label="Más adelante"
                                                                color="#793e87"
                                                                value="Más adelante"
                                                                hide-details
                                                        ></v-checkbox>
                                                    </div>
                                                </v-row>
                                            </v-expansion-panel-content>
                                        </v-expansion-panel>

                                        <v-expansion-panel
                                                class="filter-item"
                                                v-show="trajectory"
                                        >
                                            <v-expansion-panel-header @click="activeModal">Mes de inicio
                                            </v-expansion-panel-header>
                                            <div class="checkedValuesMobile">{{ selectedStartAt.join(" / ") |getMonthNameFromDates('M')  }}</div>
                                            <v-expansion-panel-content>
                                                <v-row>
                                                    <div class="pl-3">
                                                        <v-checkbox
                                                                    @change="updateStartAt(false)"
                                                                    v-model="selectedStartAt"
                                                                    :label="next_months[0].name"
                                                                    color="#793e87"
                                                                    :value="next_months[0].date"
                                                                    hide-details
                                                        ></v-checkbox>
                                                        <v-checkbox
                                                                @change="updateStartAt(false)"
                                                                v-model="selectedStartAt"
                                                                :label="next_months[1].name"
                                                                color="#793e87"
                                                                :value="next_months[1].date"
                                                                hide-details
                                                        ></v-checkbox>
                                                    </div>
                                                    <div class="pl-4">
                                                        <v-checkbox
                                                                @change="updateStartAt(false)"
                                                                v-model="selectedStartAt"
                                                                :label="next_months[2].name"
                                                                color="#793e87"
                                                                :value="next_months[2].date"
                                                                hide-details
                                                        ></v-checkbox>
                                                        <v-checkbox
                                                                @change="updateStartAt(false)"
                                                                v-model="selectedStartAt"
                                                                :label="next_months[3].name"
                                                                color="#793e87"
                                                                :value="next_months[3].date"
                                                                hide-details
                                                        ></v-checkbox>
                                                    </div>
                                                    <div class="pl-4">
                                                        <v-checkbox
                                                                @change="updateStartAt(false)"
                                                                v-model="selectedStartAt"
                                                                :label="next_months[4].name"
                                                                color="#793e87"
                                                                :value="next_months[4].date"
                                                                hide-details
                                                        ></v-checkbox>
                                                    </div>
                                                </v-row>
                                            </v-expansion-panel-content>
                                        </v-expansion-panel>

                                        <v-expansion-panel
                                                class="filter-item"
                                        >
                                            <v-expansion-panel-header @click="activeModal2">Días de la semana
                                            </v-expansion-panel-header>
                                            <div class="checkedValuesMobile" v-if="selectDaily.length">
                                                <span v-for="(selectDay, i) in selectDaily" :key="i" class="text-capitalize">
                                                    <span v-if="i > 0" class="pl-1">/</span>
                                                    {{ $moment().day(selectDay + 1).format('dddd') }}
                                                </span>
                                            </div>
                                            <v-expansion-panel-content class="container">
                                                <v-row>
                                                    <v-col @click="activeDay0(false)" :class="{'day-box-active':day0}" class="day-box"
                                                        cols="3">Lunes
                                                    </v-col>
                                                    <v-col @click="activeDay1(false)" :class="{'day-box-active':day1}" class="day-box"
                                                        cols="3">Martes
                                                    </v-col>
                                                    <v-col @click="activeDay2(false)" :class="{'day-box-active':day2}" class="day-box"
                                                        cols="3">Miércoles
                                                    </v-col>
                                                    <v-col @click="activeDay3(false)" :class="{'day-box-active':day3}" class="day-box"
                                                        cols="3">Jueves
                                                    </v-col>
                                                </v-row>
                                                <v-row>
                                                    <v-col @click="activeDay4(false)" :class="{'day-box-active':day4}" class="day-box"
                                                        cols="3">Viernes
                                                    </v-col>
                                                    <v-col @click="activeDay5(false)" :class="{'day-box-active':day5}" class="day-box"
                                                        cols="3">Sábado
                                                    </v-col>
                                                    <v-col @click="activeDay6(false)" :class="{'day-box-active':day6}" class="day-box"
                                                        cols="3">Domingo
                                                    </v-col>
                                                </v-row>
                                            </v-expansion-panel-content>
                                        </v-expansion-panel>

                                        <v-expansion-panel
                                                class="filter-item"
                                                v-show="!trajectory"
                                        >
                                            <v-expansion-panel-header @click="activeModal3">Turno del día
                                            </v-expansion-panel-header>
                                            <div class="checkedValuesMobile">{{ printDayTime }}</div>
                                            <v-expansion-panel-content>
                                                <v-row>
                                                    <v-col cols="6" class="pt-0">
                                                        <div class="dayTime-box" :class="{'dayTime-box-active':dayTime0}"
                                                            @click="activeDayTime0(false)"><img class="mr-mob-5 mr-tb-5"
                                                                                        src="/assets/images/filters/sun1.svg"
                                                                                        alt=""/>Mañana<br><span>9:00h - 14:00h</span>
                                                        </div>
                                                    </v-col>
                                                    <v-col cols="6" class="pt-0">
                                                        <div class="dayTime-box" :class="{'dayTime-box-active':dayTime1}"
                                                            @click="activeDayTime1(false)"><img class="mr-mob-5 mr-tb-5"
                                                                                        src="/assets/images/filters/sun2.svg"
                                                                                        alt=""/>Tarde<br><span>15:00h - 20:00h</span>
                                                        </div>
                                                    </v-col>
                                                </v-row>
                                            </v-expansion-panel-content>
                                        </v-expansion-panel>
                                    </v-expansion-panels>
                                </v-row>
                            </div>
                        </div>
                    </div>

                    <!-- PROMOTION CARDS -->
                    <div v-show="promotions" class="mb-4">
                        <template v-for="promotion in promotions">
                            <course-promotion-card
                                :key="promotion.id"
                                :promotion="promotion"
                            ></course-promotion-card>
                        </template>
                    </div>

                    <!-- FOOTER: NO DATE NOTICE AND PAGINATION -->
                    <div class="d-flex justify-space-between align-items-center">
                        <div>
                            <div
                                v-if="promotions.length === 0 || pagination.current >= pagination.total"
                                class="text-body-2"
                            >
                                ¿No ves un horario que te funcione?<br>
                                <a class="p3-txt" href="/es/contacto">
                                    <strong class="blue-title">¡Solicita otro nuevo!</strong>
                                </a>
                            </div>
                        </div>
                        <v-pagination
                                color="#29c0d3"
                                v-model="pagination.current"
                                :length="pagination.total"
                                total-visible="4"
                                @input="onPageChange"
                        ></v-pagination>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
import CoursePromotionCard from './Course/CoursePromotionCard.vue'
import Event from "../event";
import {GetObject} from '../axios-services'

const today = new Date();

export default {
    components: {
        CoursePromotionCard
    },

    props: [ 'course', 'course_url', 'trajectory', 'next_months'],

    data() {
        return {
            pagination: {
                current: 1,
                total: 0
            },
            page: 1,
            daily: '',
            promotions: [],
            selectedFilter: false,
            selectedFilter2: false,
            selectedFilter3: false,
            selectedStartAt: [],
            queryStartAt: [],
            selectDaily: [],
            selectDateTime: [],
            printDayTime: null,
            day0: false,
            day1: false,
            day2: false,
            day3: false,
            day4: false,
            day5: false,
            day6: false,
            dayTime0: false,
            dayTime1: false,
            query: '',

            // EXCLUSIVE DATA FOR MOBILE FILTER
            hiddenFilters: true,
            hiddenSearch: false,
        }
    },

    mounted() {
        this.getPromotions(this.query);
        Event.$on('filter-promotions', (query) => {
            this.pagination.current = 1
            console.log('emit-receive')
            this.query = query
            this.getPromotions(query);
        });
    },

    filters: {
        // EXCLUSIVE FILTERS FOR MOBILE FILTER

        getMonthNameFromDates(date,format){
            if(date){
                if(format==='M'){
                    let value = date.split(',');
                    if (new Date(date) !== "Invalid Date") {
                        let new_date=new Date(value[0]);
                        return  new_date.toLocaleString('Es', { month: 'long' })
                    }
                }
            }
            return date;
        },
    },

    methods: {
        getPromotions(query) {
            let queryPromotionsFull='';
            if(this.trajectory!==1){
                queryPromotionsFull='&FilterByStudents=not_full';
            }
            GetObject(`promotions?include=promotionPurchases${queryPromotionsFull}&is_purchasable=true&filter[course_id]=${this.course.id}&page=${this.pagination.current}${query}`, (error, data) => {
                if (error) {
                    console.log(error)
                    this.pagination = {
                        current: 1,
                        total: 0
                    }
                    this.page = 1
                    this.promotions = []
                } else {
                    console.log(data)
                    this.promotions = data.promotions.data;
                    console.log("count promotions", this.promotions.length)
                    this.pagination.current = data.promotions.current_page;
                    this.pagination.total = data.promotions.last_page;
                }
            })
        },
        onPageChange() {
            this.getPromotions(this.query);
        },
        activeModal() {
            this.selectedFilter = !this.selectedFilter;
            this.selectedFilter2 = false;
            this.selectedFilter3 = false;
        },
        activeModal2() {
            this.selectedFilter2 = !this.selectedFilter2;
            this.selectedFilter = false;
            this.selectedFilter3 = false;
        },
        activeModal3() {
            this.selectedFilter3 = !this.selectedFilter3;
            this.selectedFilter2 = false;
            this.selectedFilter = false;
        },

        applyFilters(eventTarget = null) {
            let query = this.parameterizeArray('starts_after', this.queryStartAt,) + this.parameterizeArray('daily', this.selectDaily, '&') + this.selectDateTime
            Event.$emit('filter-promotions', query);
            if (eventTarget === 'applyFilter') {
                this.hiddenFilters = true;
                this.hiddenSearch = false
            }
        },

        getRelativeDayInWeek(d, dy) {
            d = new Date(d);
            let day = d.getDay(),
                diff = d.getDate() - day + (day === 0 ? -6 : dy); // adjust when day is sunday
            return new Date(d.setDate(diff));
        },
        getDaysMonth(date, month, days) {
            date = new Date(date)
            let y = date.getFullYear(), m = date.getMonth();
            if (days !== '')
                return new Date(y, m + month, days);
        },

        parameterizeArray(key, arr, operator) {
            if (arr.length === 0)
                return ''
            if (operator === '&')
                return '&filter[' + key + ']=' + arr.join(',')
            return '&filter[' + key + ']=' + arr.join('&filter[' + key + ']=')
        },

        isDate: function (date) {
            return (new Date(date) !== "Invalid Date") && !isNaN(new Date(date));
        },

        updateStartAt(applyDirectly = false) {
            let vm = this
            vm.queryStartAt = []
            console.log(this.selectedStartAt, this.queryStartAt)
            let thisWeek = this.getRelativeDayInWeek(today, 0).toISOString().split('T')[0] + ',' + this.getRelativeDayInWeek(today, 7).toISOString().split('T')[0]
            console.log(thisWeek)
            this.selectedStartAt.filter((value) => {
                if (value) {
                    let date = value.split(',');
                    if (this.isDate(date[0])) {
                        vm.queryStartAt.push(value)
                    }
                }
                if (value === "Esta semana") vm.queryStartAt.push(thisWeek)
            })
            let nextWeek = this.getRelativeDayInWeek(today, 7).toISOString().split('T')[0] + ',' + this.getRelativeDayInWeek(today, 14).toISOString().split('T')[0]
            this.selectedStartAt.filter((value) => {
                if (value === 'Próxima semana') this.queryStartAt.push(nextWeek)
            })
            let nextMonth = this.getDaysMonth(today, 1, 1).toISOString().split('T')[0] + ',' + this.getDaysMonth(today, 2, 0).toISOString().split('T')[0]
            this.selectedStartAt.filter((value) => {
                if (value === 'Próximo mes') this.queryStartAt.push(nextMonth)
            })
            let later = this.getDaysMonth(today, 2, 1).toISOString().split('T')[0] + ',' + this.getDaysMonth(today, 3, 0).toISOString().split('T')[0]
            this.selectedStartAt.filter((value) => {
                if (value === 'Más adelante') this.queryStartAt.push(later)
            })
            if (applyDirectly) {
                this.applyFilters()
            }
        },
        activeDay0(applyDirectly = false) {
            this.day0 = !this.day0;
            this.day0 ? this.selectDaily.push(0) : this.selectDaily.splice(this.selectDaily.indexOf(0), 1)
            console.log(this.selectDaily)
            if (applyDirectly) {
                this.applyFilters()
            }
        },
        activeDay1(applyDirectly = false) {
            this.day1 = !this.day1;
            this.day1 ? this.selectDaily.push(1) : this.selectDaily.splice(this.selectDaily.indexOf(1), 1)
            console.log(this.selectDaily)
            if (applyDirectly) {
                this.applyFilters()
            }
        },
        activeDay2(applyDirectly = false) {
            this.day2 = !this.day2;
            this.day2 ? this.selectDaily.push(2) : this.selectDaily.splice(this.selectDaily.indexOf(2), 1)
            console.log(this.selectDaily)
            if (applyDirectly) {
                this.applyFilters()
            }
        },
        activeDay3(applyDirectly = false) {
            this.day3 = !this.day3;
            this.day3 ? this.selectDaily.push(3) : this.selectDaily.splice(this.selectDaily.indexOf(3), 1)
            console.log(this.selectDaily)
            if (applyDirectly) {
                this.applyFilters()
            }
        },
        activeDay4(applyDirectly = false) {
            this.day4 = !this.day4;
            this.day4 ? this.selectDaily.push(4) : this.selectDaily.splice(this.selectDaily.indexOf(4), 1)
            console.log(this.selectDaily)
            if (applyDirectly) {
                this.applyFilters()
            }
        },
        activeDay5(applyDirectly = false) {
            this.day5 = !this.day5;
            this.day5 ? this.selectDaily.push(5) : this.selectDaily.splice(this.selectDaily.indexOf(5), 1)
            console.log(this.selectDaily)
            if (applyDirectly) {
                this.applyFilters()
            }
        },
        activeDay6(applyDirectly = false) {
            this.day6 = !this.day6;
            this.day6 ? this.selectDaily.push(6) : this.selectDaily.splice(this.selectDaily.indexOf(6), 1)
            console.log(this.selectDaily)
            if (applyDirectly) {
                this.applyFilters()
            }
        },
        activeDayTime0(applyDirectly = false) {
            this.dayTime0 = !this.dayTime0;
            this.dayTime1 = false;
            this.dayTime0 ? this.printDayTime = 'Mañana' : this.printDayTime = '';
            this.dayTime0 ? this.selectDateTime = '&filter[starts_after_hour]=09:00:00,14:00:00' : this.selectDateTime = ''
            if (applyDirectly) {
                this.applyFilters()
            }
        },
        activeDayTime1(applyDirectly = false) {
            this.dayTime1 = !this.dayTime1;
            this.dayTime0 = false;
            this.dayTime1 ? this.printDayTime = 'Tarde' : this.printDayTime = '';
            this.dayTime0 ? this.selectDateTime = '&filter[starts_after_hour]= 15:00:00,20:00:00' : this.selectDateTime = ''
            if (applyDirectly) {
                this.applyFilters()
            }
        },

        closeFilter(item, filter) {
            let list = null;

            if (filter === 'start') {
                list = this.selectedStartAt;
            }
            if (filter === 'day') {
                list = this.selectDaily;
                if (item === 0) {
                    this.day0 = false;
                }
                if (item === 1) {
                    this.day1 = false;
                }
                if (item === 2) {
                    this.day2 = false;
                }
                if (item === 3) {
                    this.day3 = false;
                }
                if (item === 4) {
                    this.day4 = false;
                }
                if (item === 5) {
                    this.day5 = false;
                }
                if (item === 6) {
                    this.day6 = false;
                }
            }
            if (item !== '')
                list.splice(list.indexOf(item), 1);
            else {
                if (filter === 'dayTime') {
                    this.dayTime1 = false;
                    this.dayTime0 = false;
                    this.selectDateTime = '';
                    this.printDayTime = null;
                }
            }
            this.updateStartAt()
            this.applyFilters()
        },


        // EXCLUSIVE METHODS FOR MOBILE FILTER

        handlePanelFilter() {
            this.hiddenFilters = false;
            this.hiddenSearch = true;
        },

        showSearch() {
            this.hiddenFilters = true;
            this.hiddenSearch = false;
        },
    }
}
</script>

<style scoped>

.promotions-filter-desktop .dayTime-box {
    cursor: pointer;
    width: 114px;
    height: 58px;
    margin: 20px 42px 0 0;
    padding: 10px 11.3px 8px 11px;
    border-radius: 1px;
    border: solid 1px rgba(194, 195, 197, 0.55);
}

.promotions-filter-desktop .v-expansion-panel-header {
    width: 100%;
    margin: 11px 0 0;
    border-radius: 4px !important;
    border: solid 1.5px #343a40;
    box-shadow: none !important;
    min-height: 40px !important;
}

.promotions-filter-desktop .v-expansion-panel-header.v-expansion-panel-header--active {
    color: #793e87;
    font-weight: 500;
    border: none !important;
}

.promotions-filter-desktop .dayTime-box > span {
    font-size: 12px;
}

.promotions-filter-desktop .dayTime-box-active {
    border: solid 1px #793e87 !important;
}

.promotions-filter-desktop .v-expansion-panel-header.v-expansion-panel-header--active {
    color: #793e87;
    padding-left: 24px !important;
    padding-right: 8px !important;
    margin-top: 0px !important;
}

.promotions-filter-desktop .v-expansion-panel--active {
    border-radius: 4px !important;
    box-shadow: 0 4px 10px 0 rgba(121, 62, 135, 0.2);
    border: solid 1px #793e87;
    margin-top: 11px !important;
}

.promotions-filter-desktop .v-expansion-panel--active.filter-large {
    height: 235px !important;
}

.promotions-filter-desktop .v-expansion-panel--active.filter-small {
    height: 150px !important;
}

.promotions-filter-desktop .v-expansion-panel:before {
    box-shadow: none !important;
}

.promotions-filter-desktop .filter-item {
    padding: 0 !important;
    color: #343a40 !important;
    opacity: 0.8;
    font-family: 'Poppins' !important;
    font-size: 14px;
    height: 40px;
}

.promotions-filter-desktop .v-expansion-panel.filter-item.v-expansion-panel--active.v-item--active {
    height: auto;
}

.promotions-filter-desktop .day-box {
    cursor: pointer;
    padding: 4px 10px;
    border-radius: 3px;
    border: solid 1px #c2c3c5;
    text-align: center;
    margin-right: 5px;
    margin-bottom: 5px;
    font-size: 13px;
}

.promotions-filter-desktop .day-box-active {
    background-color: #793e87;
    color: #ffffff;
}

.promotions-filter-desktop .v-expansion-panel--active.filter-large {
    height: 235px !important;
}

.promotions-filter-desktop .v-expansion-panel--active.filter-small {
    height: 150px !important;
}

.checkedValues {
    height: 27px;
    padding: 5px 10px;
    object-fit: contain;
    border-radius: 14px;
    box-shadow: 0 4px 10px 0 rgba(40, 191, 210, 0.2);
    border: solid 1px #28bfd2;
    background-color: #ffffff;
    font-family: Poppins;
    font-size: 12px;
    font-weight: 600;
    color: #28bfd2;
    display: inline;
}

.checkedValues > span {
    cursor: pointer;
    font-size: 28px;
    font-weight: 200;
    vertical-align: middle;
    margin-left: 4px;
}

.promotions-filter-desktop .v-expansion-panel-header__icon {
    margin-right: 4px !important;
}

</style>

<style>

.v-label.theme--light {
    color: #5d6166 !important;
    font-size: 14px !important;
    margin-bottom: 0 !important;
}

.v-expansion-panel--active > .v-expansion-panel-header--active .v-expansion-panel-header__icon:not(.v-expansion-panel-header__icon--disable-rotate) .v-icon {
    color: #793e87 !important;
}

.v-pagination__navigation {
    box-shadow: none !important;
}

.v-pagination__item {
    width: 28px !important;
    height: 28px !important;
    min-width: 28px !important;
    box-shadow: none !important;
}

.v-pagination__item.v-pagination__item--active {
    color: #29c0d3 !important;
    border-radius: 2px !important;
    border: solid 1.5px #29c0d3 !important;
    box-shadow: none !important;
    background-color: #fff !important;
}
</style>

<style scoped>

/* EXCLUSIVE STYLES FOR MOBILE FILTER */
.filters {
    font-family: 'Open Sans';
    font-size: 16px;
    font-weight: 600;
    color: #29c0d3;
}

.apply {
    font-family: Poppins;
    font-size: 16px;
    font-weight: 500;
    color: #29c0d3;
}

.cancel {
    font-family: Poppins;
    font-size: 16px;
    font-weight: 400;
}

.filters-panel {
    width: 100%;
    margin: 11px 15px 0;
    border-radius: 12px;
    box-shadow: 0 4px 18px 0 rgba(0, 0, 0, 0.2);
}

.filter-item {
    padding: 15px 0 25px;
    color: #343a40 !important;
    opacity: 0.8;
    font-family: 'Poppins' !important;
    font-size: 14px;
}

.v-label.theme--light {
    color: #5d6166 !important;
    font-size: 12px !important;
    margin-bottom: 0 !important;
}

.day-box {
    padding: 4px 10px;
    border-radius: 3px;
    border: solid 1px #c2c3c5;
    text-align: center;
    font-size: 12px;
}

.day-box-active {
    background-color: #793e87;
    color: #ffffff;
}

.dayTime-box {
    width: 114px;
    height: 58px;
    margin: 20px 42px 0 0;
    padding: 10px 11.3px 8px 11px;
    border-radius: 1px;
    border: solid 1px rgba(194, 195, 197, 0.55);
}

.v-expansion-panel-header {
    padding: 14px 24px 0px 24px;
}

.v-expansion-panel-header.v-expansion-panel-header--active {
    color: #793e87;
    font-weight: 500;
    padding: 16px 24px !important;
}

.dayTime-box > span {
    font-size: 12px;
}

.dayTime-box-active {
    border: solid 1px #793e87 !important;
}

.v-expansion-panel-header.v-expansion-panel-header--active {
    color: #793e87;
}

.v-expansion-panel--active {
    border-radius: 4px !important;
    box-shadow: 0 4px 10px 0 rgba(121, 62, 135, 0.2);
    border: solid 1px #793e87;
}

.v-expansion-panel--active.filter-large {
    height: 235px !important;
}

.v-expansion-panel--active.filter-small {
    height: 150px !important;
}

.v-expansion-panel:before {
    box-shadow: none !important;
}

.v-expansion-panel--active > .v-expansion-panel-header--active .v-expansion-panel-header__icon:not(.v-expansion-panel-header__icon--disable-rotate) .v-icon {
    color: #793e87 !important;
}

.v-input {
    padding-top: 0px !important;
}

.v-messages.theme--light {
    display: none !important;
}

.checkedValuesMobile {
    font-size: 12px !important;
    color: gray !important;
    margin-left: 24px;
    padding-bottom: 8px;
}

.v-expansion-panel--active .checkedValuesMobile {
    display: none;
}

.theme--light.v-btn:not(.v-btn--flat):not(.v-btn--text):not(.v-btn--outlined) {
    background-color: white !important;
}
</style>

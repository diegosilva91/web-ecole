<template>
    <div class="container mt-10">
        <h1 class="h2-txt-med text-center">Mis Cursos</h1>
        <div class="bg-nav-mobile mt-5 d-flex center-mob mx-auto">
            <h6 @click="activeFilter('activos')" :active='active1'>Activos</h6>
            <h6 @click="activeFilter('next')" :active='active2'>Próximos</h6>
            <h6 @click="activeFilter('completados')" :active='active3'>Completados</h6>
        </div>
        <div class="row">
            <div v-for="course in courses" :key="course.id" class="col-12 col-sm-6">
                <div class="card-mycourse-mob mt-10 center-mob">
                    <img class="img-mycourse p-0" :src="`${url}${course.courses.cover_image}`" alt="">
                    <div class="ml-7 mr-3 mt-3">
                        <p class="mb-1"><span>{{ course.courses.categoryName }}</span></p>
                        <h2 class="mb-1">{{ course.courses.title }}</h2>
                        <p v-if="active2===true" class="teacher-name mb-1">Pendiente de asignación</p>
                        <p v-else class="teacher-name mb-1"></p>
                        <div class="d-inline">
                            <img height="14px" class="d-inline" src="/assets/images/course/icons/star.svg">
                            <p class="d-inline"><span>{{ course.courses.avg_reviews|formatDouble }}</span><span
                                class="valorations-text ml-1">({{ course.courses.total_reviews }})</span></p>
                        </div>
                        <p class="mb-0 mt-2 mb-2">Proxima clase:</p>
                        <div class="d-flex">
                            <p class="col-4 p-0 mr-1">
                                <v-icon small>{{ mdiCalendarRange }}</v-icon>
                                <template v-if="!course.completed">
                                    {{ course.date | formatted('yyyy-MM-dd') }}
                                </template>
                                <template v-else>
                                    -- --
                                </template>
                            </p>
                            <p class="col-3 p-0 pl-1">
                                <v-icon small>{{ mdiClockOutline }}</v-icon>
                                <template v-if="!course.completed">
                                    {{ course.time | formatted('hh:mm') }}
                                </template>
                                <template v-else>
                                    -- --
                                </template>
                            </p>
                            <p class="col-4 p-0" v-if="course.courses.is_subscription!==1">
                                <v-icon small>{{ mdiContentPaste }}</v-icon>
                                {{ course.courses.duration }} sesiones
                            </p>
                        </div>
                        <!-- <button class="btn-content mb-5 mt-2 mr-4">Contenido</button> -->
                        <button v-show="course.completed"
                                @click="openReceipt(course.courses,course.end_at,course.user_assistant)"
                                class="btn-content mb-5 mt-2">Certificado
                        </button>
                        <div class="mt-6">
                            <div v-show="course.actual">
                                <button class="btn-toClass">Acceder a la clase</button>
                            </div>
                            <div v-show="course.completed">
                                <button class="btn-completed">Curso Completado</button>
                            </div>
                            <div><a href="/es/contacto">
                                <button class="btn-contactTeacher mt-3 mb-5">
                                    <v-icon dark class="mr-2">{{ mdiEmailOutline }}</v-icon>
                                    Contactar
                                </button>
                            </a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mdiCalendarRange, mdiClockOutline, mdiContentPaste, mdiEmailOutline } from "@mdi/js";
import Event from "../../event";

export default {
    data: () => ({
        queryDate: '',
        url: '',
        active1: true,
        active2: false,
        active3: false,
        courses: [],
        mdiCalendarRange,
        mdiClockOutline,
        mdiContentPaste,
        mdiEmailOutline
    }),
    mounted() {
        this.getDataCourses()
    },
    methods: {
        mounted() {
            this.getDataCourses()
        },
        getDataCourses() {
            const vm = this
            Event.$on('data-courses', ({courses, url}) => {
                console.log(courses)
                vm.courses = courses
                this.url = url
                this.loading = true
            })
        },
        activeFilter(v) {
            switch (v) {
                case 'activos':
                    this.active1 = true;
                    this.active2 = this.active3 = false;
                    this.queryDate = `&filter[start_at_end_at]=active`
                    break;
                case 'next':
                    this.active2 = true;
                    this.active1 = this.active3 = false;
                    this.queryDate = `&filter[start_at_end_at]=next`
                    break;
                case 'completados':
                    this.active3 = true;
                    this.active2 = this.active1 = false;
                    this.queryDate = `&filter[start_at_end_at]=finished`
            }
            Event.$emit('filter-title-my-courses', v);
            this.applyFilters()
        },
        applyFilters() {
            let query = this.queryDate
            Event.$emit('filter-my-courses', query);
        },
        openReceipt(course, date, user_assistant) {
            if (user_assistant) {
                if (user_assistant.length > 0) {
                    let ids = user_assistant.map((value) => value.id);
                    for (let id of ids) {
                        window.open(`/es/courses/complete/export/pdf/${this.$route.params.id}?course_id=${course.id}&date=${date}&user_assistant_id=${id}`, '_blank')
                    }
                } else {
                    window.open(`/es/courses/complete/export/pdf/${this.$route.params.id}?course_id=${course.id}&date=${date}`, '_blank')
                }
            } else {
                window.open(`/es/courses/complete/export/pdf/${this.$route.params.id}?course_id=${course.id}&date=${date}`, '_blank');
            }
        }
    },
    filters: {
        formatDouble(value) {
            if (value - Math.floor(value) !== 0) {
                return parseFloat(value).toFixed(1)
            } else {
                return parseFloat(value).toFixed(0)
            }
        },
        formatted(date, format) {
            if (date) {
                if (format === 'yyyy-MM-dd' && date !== '') {
                    let month = (date.getMonth() + 1)
                    let day = date.getDate()
                    if (month < 10)
                        month = '0' + month
                    if (day < 10)
                        day = `0${day}`
                    return `${day}-${month}-${date.getFullYear()}`
                }
                if (format === 'hh:mm' && date !== '') {
                    let minutes = date.getMinutes()
                    if (minutes < 10)
                        minutes = `0${minutes}`
                    return `${date.getHours()}:${minutes}`
                }
                return date;
            }
            return date;
        },
    }
}
</script>

<style scoped>
h6 {
    color: rgba(52, 58, 64, 0.7);
    cursor: pointer;
    font-size: 16px;
    margin: 10px 15px;
}

h6[active] {
    height: 40px;
    padding: 10px 15px;
    color: #5c2767;
    border-radius: 20px;
    border: solid 1.5px #5c2767;
    background-color: #ffffff;
    margin: 0px;
}

h1 {
    line-height: 2.36;
}

h2 {
    font-size: 16px;
    font-weight: 600;
}


.bg-nav-mobile {
    max-width: 332px;
    height: 40px;
    border-radius: 20px;
    background-color: rgba(52, 58, 64, 0.1);
}

.card-mycourse-mob {
    max-width: 334px;
    height: auto;
    padding: 0 0 20px;
    border-radius: 12px;
    box-shadow: 0 4px 18px 0 rgba(0, 0, 0, 0.15);
}

.img-mycourse {
    height: auto;
    width: max-content;
    border-top-left-radius: 12px;
    border-top-right-radius: 12px;
}

p {
    font-family: 'Open Sans';
    font-size: 14px;
    color: rgba(52, 58, 64, 0.7);
}

p > span {
    font-size: 12px;
    font-weight: 600;
    color: #793e87;
}

.valorations-text {
    font-weight: 400;
    opacity: 0.5;
    color: #343a40;
}

.teacher-name {
    font-size: 12px;
    font-weight: 600;
    color: #343a40;
    opacity: 0.7;
}

.btn-content {
    font-family: 'Poppins';
    font-size: 14px;
    font-weight: 500;
    color: #29c0d3;
}

.btn-toClass {
    width: 274px;
    height: 40px;
    border-radius: 8px;
    box-shadow: 0 2px 5px 0 rgba(41, 192, 211, 0.3);
    border: solid 1px #29c0d3;
    font-family: 'Open Sans';
    font-size: 16px;
    font-weight: 600;
    color: #29c0d3;
}

.btn-contactTeacher {
    width: 274px;
    height: 40px;
    border-radius: 8px;
    box-shadow: 0 2px 8px 0 rgba(35, 158, 173, 0.5);
    background-color: #29c0d3;
    font-family: 'Open Sans';
    font-size: 16px;
    font-weight: 600;
    color: #ffffff;
}

.btn-completed {
    width: 274px;
    height: 40px;
    font-family: 'Open Sans';
    font-size: 16px;
    font-weight: 600;
    color: #793e87;
    cursor: default;
}

@media (max-width: 500px) {
    .center-mob {
        margin-left: auto;
        margin-right: auto;
    }
}
</style>

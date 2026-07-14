<template>
<div>
    <div :class="collapsed" class="bg-header row align-items-center">
        <div class="container">
            <div class="row">
                <div class="col-7">
                    <div class="h6-txt mb-2 text-light"><span>{{ description_type_course }}</span> {{ category.title }}</div>
                    <h1 class="text-light" :class="[{'mb-20':trajectory},title?'h2-txt-bold w-100':'h3-txt']">{{ course.title }}</h1>
                    <div v-show="!trajectory" :class="[teacherFont[0], dNone]" class="h4-txt-elight text-light mb-8 mt-2">Impartido por <span :class="teacherFont[1]" class="h4-txt-sbold">{{ course.count_teachers }}</span> <template v-if="course.count_teachers>1">profesores </template> <template v-else>profesor</template></div>
                    <div :class="dNone">
                        <v-btn
                            class="mr-4"
                            color="accent"
                            @click="courseStoreOnSubscribeClick($gtm)"
                        >
                            <v-icon left>$cartIcon</v-icon>
                            {{ trajectory ? 'Suscribirme' : 'Comprar' }}
                        </v-btn>

                        <favorite-button
                            :user_id="user_id"
                            :label="likes"
                            :course_id="course.id" color="white"
                            :text="'Favoritos'"
                        ></favorite-button>

                        <share-button class="col-4" :course_url="course_url" color="white"></share-button>
                    </div>
                </div>
                <div :class="dNone" class="img-container">
                    <img class="img-expand" :src="url+course.cover_image" alt=""/>
                </div>
            </div>
        </div>
    </div>
    <div class="container">

        <!-- COURSE SUB-MENU (STICKY POSITION) -->
        <div :class="{'menu-position': menu,'d-none': hiddenNavbar}" class="row col align-items-center h7-txt">
            <div class="d-inline mr-5">
                <a
                    @click="$vuetify.goTo('#description', { offset: 120 })"
                    class="text-secondary menu-actived"
                >
                    Descripción
                </a>
            </div>
            <div class="d-inline mr-5">
                <a
                    @click="$vuetify.goTo('#info', { offset: 120 })"
                    class="text-secondary menu-actived"
                >
                    ¿Por qué hacer este curso?
                </a>
            </div>
            <div class="d-inline mr-5">
                <a
                    @click="$vuetify.goTo('#promotions', { offset: 120 })"
                    class="text-secondary menu-actived"
                >
                    Disponibilidad
                </a>
            </div>
            <div class="d-inline mr-5">
                <a
                    @click="$vuetify.goTo('#requirements', { offset: 120 })"
                    class="text-secondary menu-actived"
                >
                    Requisitos
                </a>
            </div>
            <div v-if="hasTeachers" class="d-inline mr-5">
                <a
                    @click="$vuetify.goTo('#teachers', { offset: 120 })"
                    class="text-secondary menu-actived"
                >
                    Profesores
                </a>
            </div>
            <div v-if="hasOpinions" class="d-inline mr-5">
                <a
                    @click="$vuetify.goTo('#opinions', { offset: 120 })"
                    class="text-secondary menu-actived"
                >
                    Opiniones
                </a>
            </div>
            <div class="d-inline mr-5">
                <a
                    @click="$vuetify.goTo('#faq', { offset: 120 })"
                    class="text-secondary menu-actived"
                >
                    FAQ
                </a>
            </div>
        </div>

        <!-- COURSE SUB-MENU (STATIC POSITION) -->
        <div :class="initialMenu" class="row col align-items-center h7-txt">
            <div class="d-inline mr-5">
                <a
                    @click="$vuetify.goTo('#description', { offset: 350 })"
                    class="text-secondary menu-actived"
                >
                    Descripción
                </a>
            </div>
            <div class="d-inline mr-5">
                <a
                    @click="$vuetify.goTo('#info', { offset: 410 })"
                    class="text-secondary menu-actived"
                >
                    ¿Por qué hacer este curso?
                </a>
            </div>
            <div class="d-inline mr-5">
                <a
                    @click="$vuetify.goTo('#promotions', { offset: 410 })"
                    class="text-secondary menu-actived"
                >
                    Disponibilidad
                </a>
            </div>
            <div class="d-inline mr-5">
                <a
                    @click="$vuetify.goTo('#requirements', { offset: 410 })"
                    class="text-secondary menu-actived"
                >
                    Requisitos
                </a>
            </div>
            <div v-if="hasTeachers" class="d-inline mr-5">
                <a
                    @click="$vuetify.goTo('#teachers', { offset: 410 })"
                    class="text-secondary menu-actived"
                >
                    Profesores
                </a>
            </div>
            <div v-if="hasOpinions" class="d-inline mr-5">
                <a
                    @click="$vuetify.goTo('#opinions', { offset: 410 })"
                    class="text-secondary menu-actived"
                >
                    Opiniones
                </a>
            </div>
            <div class="d-inline mr-5">
                <a
                    @click="$vuetify.goTo('#faq', { offset: 410 })"
                    class="text-secondary menu-actived"
                >
                    FAQ
                </a>
            </div>
        </div>
    </div>

    <course-sidebar
      class="course-sidebar"
      :class="visible"
      :category="category"
      :course="course"
      :lastPromotion="last_promotion"
      :login="login"
      :promotion="promotion"
      :session="session"
      :trajectory="trajectory"
      :visible="visible"
    ></course-sidebar>
</div>
</template>

<script>
import { mapActions, mapWritableState } from 'pinia';
import { useCourseStore } from '../store/course';
import CourseSidebar from './Course/CourseSidebar.vue'

export default {
    components: {
        CourseSidebar
    },

    props:[
        'category',
        'course_url',
        'course',
        'description_type_course',
        'hasOpinions',
        'last_promotion',
        'likes',
        'promotion',
        'session',
        'trajectory',
        'url',
        'user_id'
    ],

    mounted() {
        // Set store data
        this.courseStoreCategory = this.category;
        this.courseStoreCourse = this.course;
        if (this.course.prices_packs) {
            this.courseStorePlanBasic = {
                ...this.courseStorePlanBasic,
                priceAmount: Number(this.course.prices_packs[0].price_subscription),
                priceId: Number(this.course.prices_packs[0].prices_id_stripe_basic),
            };
            this.courseStorePlanLifecooler = {
                ...this.courseStorePlanLifecooler,
                priceAmount: Number(this.course.prices_packs[1].price_subscription),
                priceId: Number(this.course.prices_packs[1].prices_id_stripe_lifecooler),
            };
            this.courseStoreSelectePlan(2);
        }

        this.login = true
        this.dataTarget = this.login ? '' : '#RegisterPayment'
        if (this.trajectory === 1) {
            this.redirectCheckout = `/es/cursos-anuales/payment/${this.course.id}`;
        } else {
            this.redirectCheckout = `/es/payment/${this.course.id}`;
        }
    },

    data () {
        return{
            redirectCheckout:`/es/payment/${this.course.id}`,
            dataTarget:'#RegisterPayment',
        login:false,
        collapsed:"",
        dNone:"",
        teacherFont:["",""],
        position:"fixed-top",
        visible:"card-position",
        lastScrollPosition: 0,
        hiddenNavbar:true,
        menu:false,
        initialMenu:"",
        title:true
        }
    },

    computed: {
        ...mapWritableState(useCourseStore, {
            courseStoreCategory: 'category',
            courseStoreCourse: 'course',
            courseStorePlanBasic: "planBasic",
            courseStorePlanLifecooler: "planLifecooler",
        }),

        hasTeachers() {
            return Boolean(this.course.count_teachers);
        }
    },

    created () {
        window.addEventListener('scroll', this.handleScroll);
        window.addEventListener('scroll', this.onScroll);
        window.addEventListener('scroll', this.hiddenCard);
    },
    destroyed () {
        window.removeEventListener('scroll', this.handleScroll);
        window.removeEventListener('scroll', this.onScroll);
        window.removeEventListener('scroll', this.hiddenCard);
    },
    methods: {
        ...mapActions(useCourseStore, {
            courseStoreOnSubscribeClick: 'onSubscribeClick',
            courseStoreSelectePlan: 'selectePlan'
        }),

        handleScroll (event) {
            if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
                this.collapsed = "collapsed fixed-top";
                this.dNone = "d-none";
                this.title = false;
                this.teacherFont = ["h5-txt-elight","h5-txt-sbold"];
                this.visible = "";
                this.menu = true;
                this.initialMenu = "d-none";
                this.hiddenNavbar = false;
            } else {
                this.collapsed = "";
                this.dNone = "";
                this.title = true;
                this.teacherFont = ["",""];
                this.visible = "card-position";
                this.menu = false;
                this.initialMenu = "";
                this.hiddenNavbar = true;
            }
        },

        hiddenCard () {
            let doc = document.documentElement;
            let value = parseInt(100 * doc.scrollTop / (doc.scrollHeight - doc.clientHeight));

            if(value > 95 ) {
                this.visible ="d-none";
            }
        },

        onScroll () {
            const currentScrollPosition = window.pageYOffset || document.documentElement.scrollTop;
            if (window.scrollY > 50){
            if(currentScrollPosition >= this.lastScrollPosition) {
                this.hiddenNavbar = true;
                this.lastScrollPosition = currentScrollPosition;
            }else {
                this.hiddenNavbar = false;
                this.lastScrollPosition = currentScrollPosition;
            }
            }
        },
    }

}
</script>

<style scoped>

    .bg-header{
        height: 300px;
        background: linear-gradient(to left, #2f353a 25%, #21252a 75%);
    }

    .collapsed{
        z-index: 3;
        height: 110px !important;
        margin-top: 0px !important;
    }

    .img-container{
        position: absolute;
        right:0;
        top: 61px;
        width: 458px;
        height: 300px;
        overflow: hidden;
    }

    .img-expand{
        width: 650px;
    }

    .menu-position{
        position: fixed;
        top: 110px;
        width:100%;
        height: 80px;
        background-color: #FFFFFF;
	    z-index: 3;
    }

    .menu-actived:hover, .menu-actived:active {
	border-bottom: 2px solid #793e87;
    }

    .btn-price{
        text-transform: capitalize;
    }

    .h6-txt>span{
        font-weight: 600;
        color: #29c0d3;
        margin-right: 10px;
    }

    .h4-txt-elight {
        font-size: 16px;
    }

    .h4-txt-sbold {
        font-size: 16px;
    }
</style>


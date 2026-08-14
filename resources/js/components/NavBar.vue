<template>
    <LazyHydrate when-visible>
        <div :class="{'navbar-hidden':hiddenNavbar, 'navbar-fixed':fixedTop}" class="row navbar py-0 align-items-center text-purple">
            <div class="col-9 py-2">
                <a href="/es" class="d-inline text">
                    <img class="nav-item ml-dk-5" src="/assets/images/home/logo_life_purple.svg" height="22" width="120"
                         alt="">
                </a>
                <nav-bar-menu></nav-bar-menu>
            </div>

            <div v-if="!login" class="col-3 d-flex align-items-center justify-content-end">
                <h6 class="d-inline text-purple cursor-pointer"><a data-toggle="modal" data-target="#Login" @click="hiddenScroll"
                                                                    style="width: max-content;">Iniciar Sesión</a></h6>
                <h6 class="d-inline btn-register mr-dk-15 text-purple cursor-pointer"><a data-toggle="modal" data-target="#Register"
                                                                                            @click="hiddenScroll">Registrarse</a></h6>
            </div>
            <div v-else>
                <a>
                    <img @click="showMenu();hiddenScroll();" class="avatar mr-20 cursor-pointer" :src="user_avatar" alt="">
                </a>
                <div :class="{'d-none':dropdownmenu}" class="sidebar" style="width:400px !important;">

                    <!-- MENU TEACHER  -->
                    <div v-if="teacher">
                        <div class="closebtn text-light" @click="dropdownmenu=true;showScroll();">&times;</div>
                        <div class="perfil-position">
                            <img :src="user_avatar" alt=""
                                    style="vertical-align: middle; width: 35px; height: 35px; border-radius: 50%;">
                            <span class="guest-name text-light pl-2">{{ user_name }}</span>
                            <template v-if="teacher">
                                <a :href="`/es/lf/profesor/${user_id}/model`"
                                    class="h8-txt-reg text-light p-0 ml-45 ml-dk-50">Ver perfil</a>
                            </template>
                        </div>

                        <div class="col-10 mx-auto mt-70 mt-dk-30" style="opacity: 0.36;border-bottom: solid 1px #979797;"></div>
                        <template v-if="teacher">
                            <a class="text-right" href="/es/mis-cursos?subject=portal-professor"><span class="link-menu-mob mr-20 mt-20 mt-tb-60 mb-mob-10 mb-tb-10"> Mis Cursos </span></a>
                            <a class="text-right" :href="`/es/lf/promociones/${user_id}`"><span class="link-menu-mob mr-20 mb-mob-10 mb-tb-10">Disponibilidad</span></a>
                        </template>
                        <!-- <a class="text-right" href="#"><span class="link-menu-mob mr-20 mb-mob-10 mb-tb-10">Ventas</span></a>  -->
                        <!-- <a class="text-right" href="#"><span class="link-menu-mob mr-20 mb-mob-10 mb-tb-10">Notificaciones</span></a> -->
                        <a class="text-right" href="/es/contacto"><span class="link-menu-mob mr-20 mb-300">Contacto</span></a>

                        <div class="row justify-content-end pt-0 pb-0 pr-30">
                            <div class="d-inline mr-4"><a class="d-inline"
                                                            href="https://wa.me/+34633651856?text=Hola!%20Estoy%20intersado%20en%20hacer%20un%20curso%20en%20Mi-empresa"><img
                                src="/assets/images/menu/whatsapp.svg" alt="icon"></a></div>
                            <div class="d-inline mr-4"><a class="d-inline" href="https://www.facebook.com/LifeColeEdu/"><img
                                src="/assets/images/menu/facebook.svg" alt="icon"></a></div>
                            <div class="d-inline mr-4"><a class="d-inline"
                                                            href="https://www.instagram.com/mi-empresaedu/"><img
                                src="/assets/images/menu/instagram.svg" alt="icon"></a></div>
                            <div class="d-inline"><a class="d-inline" href="https://twitter.com/mi-empresaedu"><img
                                src="/assets/images/menu/twitter.svg" alt="icon"></a></div>
                        </div>

                        <a class="text-right mt-30" @click="logout"><span
                            class="link-menu-mob mr-20 mb-100 cursor-pointer" style="font-size: 14px !important">Cerrar sesión</span></a>

                        <form id="logout-form"
                                action="/logout"
                                method="POST"
                                style="display: none;">
                            <input type="hidden" name="_token" :value="csrf">
                        </form>
                    </div>

                    <!-- MENU STUDENT  -->
                    <div v-else>
                        <div class="closebtn text-light" @click="dropdownmenu=true;showScroll();">&times;</div>
                        <div class="perfil-position">
                            <img :src="user_avatar" alt=""
                                    style="vertical-align: middle; width: 35px; height: 35px; border-radius: 50%;">
                            <span class="guest-name text-light pl-2">{{ user_name }}</span>
                            <a :href="`/es/lf/miperfil/${user_id}/view`" class="h8-txt-reg text-light p-0 ml-45 ml-dk-50">Ver
                                perfil</a>
                        </div>

                        <div class="col-10 mx-auto mt-70 mt-dk-30" style="opacity: 0.36;border-bottom: solid 1px #979797;"></div>

                        <a class="text-right" :href="`/es/lf/mis_cursos/${user_id}`"><span
                            class="link-menu-mob mr-20 mt-20 mt-tb-60 mb-mob-10 mb-tb-10"> Mis Cursos </span></a>
                        <a @click="iconChange=!iconChange" class="text-right">
                            <span class="link-menu-mob mr-1 cursor-pointer">Oferta educativa</span>
                            <v-icon class="text-light cursor-pointer mr-20" style="vertical-align: text-bottom;">
                                {{ iconChange ? mdiChevronDown : mdiChevronUp }}
                            </v-icon>
                        </a>
                        <div v-show="!iconChange">
                            <a class="text-right" href="/es/cursos"><span class="link-menu-mob mr-20 mb-mob-10 mb-tb-10" style="font-size:18px;font-weight:400;">Cursos intensivos</span></a>
                            <a class="text-right" href="/es/cursos-anuales"><span class="link-menu-mob mr-20 mb-mob-10 mb-tb-10" style="font-size:18px;font-weight:400;">Trayectorias educativas</span></a>
                        </div>
                        <!-- <a class="text-right" href="#"><span class="link-menu-mob mr-20 mb-mob-10 mb-tb-10">Notificaciones</span></a>  -->
                        <a class="text-right" href="/es/cursos-favoritos"><span
                            class="link-menu-mob mr-20 mb-mob-10 mb-tb-10">Favoritos</span></a>
                        <a class="text-right" href="/es/contacto"><span class="link-menu-mob mr-20 mb-mob-10 mb-tb-10">Contacto</span></a>
                        <a class="text-right" @click="openGetmember">
                            <div class="btn-getMember-mob ml-auto mr-20 cursor-pointer"><img src="/assets/images/menu/present.svg" alt=""><span class="link-getMember-mob">Invitar amigos</span>
                            </div>
                        </a>


                        <!-- <a class="text-right" data-toggle="modal" data-target="#modalGetmember" onclick="document.getElementById('modalGetmember').classList.replace('d-none','show')">
                            <div class="btn-getMember-mob ml-auto mr-20 cursor-pointer"><img src="assets/images/menu/present.svg" alt=""><span class="link-getMember-mob">Invitar amigos</span></div>
                        </a> -->

                        <hr class="col-9 mx-auto pt-0 pb-0 mt-12" style="opacity: 0.36;
        border: solid 1px #979797;">
                        <a class="text-right" href="/es/dar-clases"><span class="link-menu-mob mr-20 mb-tb-100 mb-45">Dar clases</span></a>

                        <div class="row justify-content-end pt-0 pb-0 pr-30">
                            <div class="d-inline mr-4"><a class="d-inline"
                                                            href="https://wa.me/+34633651856?text=Hola!%20Estoy%20intersado%20en%20hacer%20un%20curso%20en%20Mi-empresa"><img
                                src="/assets/images/menu/whatsapp.svg" alt="icon"></a></div>
                            <div class="d-inline mr-4"><a class="d-inline" href="https://www.facebook.com/LifeColeEdu/"><img
                                src="/assets/images/menu/facebook.svg" alt="icon"></a></div>
                            <div class="d-inline mr-4"><a class="d-inline"
                                                            href="https://www.instagram.com/mi-empresaedu/"><img
                                src="/assets/images/menu/instagram.svg" alt="icon"></a></div>
                            <div class="d-inline"><a class="d-inline" href="https://twitter.com/mi-empresaedu"><img
                                src="/assets/images/menu/twitter.svg" alt="icon"></a></div>
                        </div>

                        <a class="text-right mt-30" @click="logout"><span
                            class="link-menu-mob mr-20 mb-mob-100 mb-tb-100 cursor-pointer" style="font-size: 14px !important">Cerrar sesión</span></a>

                        <form id="logout-form"
                                action="/logout"
                                method="POST"
                                style="display: none;">
                            <input type="hidden" name="_token" :value="csrf">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </LazyHydrate>
</template>

<script>
import { mdiChevronDown, mdiChevronUp } from '@mdi/js';
import LazyHydrate from 'vue-lazy-hydration';
import NavBarMenu from './NavBarMenu.vue'
import Event from "../event";

export default {
    components: {
        LazyHydrate,
        NavBarMenu
    },
    props: ['user_id', 'user_avatar', 'teacher', 'user_name'],

    mounted() {
        this.login = !!this.user_id;
        this.csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    },

    data () {
        return {
            hiddenNavbar: false,
            lastScrollPosition: 1,
            login: this.user_id,
            dropdownmenu: true,
            fixedTop: false,
            csrf: "",
            test:false,
            iconChange:true,
            mdiChevronDown,
            mdiChevronUp
        }
    },
    created() {
        let vm=this
        window.addEventListener('scroll', this.onScroll);
    },

    destroyed() {
        let vm=this
        window.removeEventListener('scroll', this.onScroll);
    },

    methods: {
        hiddenScroll() {
            Event.$emit('modal.recommender', false);
        },
        showScroll() {
            //document.getElementsByTagName('html')[0].classList.remove("modal-open");
        },
        debounced(fn, wait){
            // clearTimeout(method._tId);
            // method._tId= setTimeout(function(){
            //     method();
            // }, delay);
            var time = Date.now();
            return function() {
                if ((time + wait - Date.now()) < 0) {
                    fn();
                    time = Date.now();
                }
            }
        },

        onScroll() {
            const currentUrl = window.location.pathname;
            const currentScrollPosition = window.pageYOffset || document.documentElement.scrollTop;
            if (window.scrollY >= 132) {
                this.fixedTop = true;
                if (currentScrollPosition > this.lastScrollPosition) {
                    this.hiddenNavbar = true;
                    this.lastScrollPosition = currentScrollPosition;
                } else {
                    this.hiddenNavbar = false;
                    this.lastScrollPosition = currentScrollPosition;
                }
            } else {
                this.fixedTop = false;
                this.hiddenNavbar = false;
            }
            },

        showMenu() {
            this.dropdownmenu = false;
        },

        logout(e) {
            e.preventDefault();
            document.getElementById('logout-form').submit()
            this.login = false;
        },

        openGetmember() {
            // document.getElementById('modalGetmember').classList.replace('d-none','show')
            Event.$emit('get-member', 'open');
        }
    }
}
</script>

<style lang="scss" scoped>
    h6{
        font-weight: 500;
    }

    .cursor-pointer{
        cursor: pointer;
    }

    .navbar {
        position: sticky;
        top: 0;
        width: 100%;
        background-color: #fff;
        margin: 0 !important;
        transition: top .4s ease;
        z-index: 9;

        #contact &,
        #course &,
        #course-categories &,
        #courses &,
        #faq &,
        #trajectories & {
            position: relative;
            top: 0;
        }
    }

    .navbar-fixed {
        box-shadow: 0 1px 9px 0 rgba(86, 45, 96, 0.1);
    }

    .navbar-hidden {
        top: -66px;
    }

.nav-item{
    margin: 0 20px 0 0;
    font-weight: 500;
}

.rot-arrow{
    -webkit-transform: rotate(180deg);
    -moz-transform: rotate(180deg);
    -ms-transform: rotate(180deg);
    transform: rotate(180deg);
}

.btn-register {
    width: 96px;
    height: 26px;
    margin: 0 0 0 36px;
    padding: 3px 8px;
    border-radius: 2px;
    border: solid 1px #793e87;
}

a {
    color:#793e87;
}

.text-purple {
    color:#793e87;
}

.avatar {
    border-radius: 50%;
    width: 2.5em;
    height: 2.5em;
}

.dropdown-menu {
    margin-top: 30px;
    background-color: #5c2767;
    z-index: 5;
    padding: 0px;
}

.summer-label{
    background-color: #885793;
    padding: 7px 10px;
    border-radius: 7px;
    color: #fff;
}

.dropdown-item{
    font-family: 'Poppins', sans-serif;
    font-size: 14px;
    font-weight: 500;
    padding: 8px 12px;
    color: #fff;
}

.dropdown-item:focus, .dropdown-item:hover{
    background-color: #cca1d6;
}

.course-line{
    margin-top: 0px;
    margin-bottom: 0px;
    background-color: #cca1d6;
}

.pl10 {
    padding-left: 10px;
}

@media (min-width: 1400px) {
    .navbar {
        padding-left: 100px;
        padding-right: 100px;
    }

}

/// Special breakpoint to match the width of the menu
@media (max-width: 1056px) {
    .navbar {
        display: none;
    }
}

</style>

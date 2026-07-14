<template>
    <div  class="container mt-dk-25 d-none d-xl-block">
    <div class="lazyload">
        <LazyHydrate when-visible>
            <observer v-if="!loading" msg="home-nav" v-on:intersect="intersected"/>
            <div v-else>
                <div :class="{'menu-fixed col-12':fixedTop, 'd-none':hiddenNavbar}" class="h7-txt">

                    <div :class="{'ml-120':marginMenu}" class="d-inline mr-4"><a href="#categories_tech">¿Qué puedo
                        encontrar?</a></div>
                    <div class="d-inline mr-4"><a href="#banner_courses">Intensivos - Anuales</a></div>
                    <div class="d-inline mr-4"><a href="#cursos">Cursos destacados</a></div>
                    <div class="d-inline mr-4"><a href="#como_funciona">¿Cómo funciona?</a></div>
                    <div class="d-inline mr-4"><a href="#que_aprender">Profesores</a></div>
                    <div class="d-inline"><a href="#colaboradores">Colaboradores</a></div>
                </div>
            </div>
        </LazyHydrate>
    </div>
    </div>
</template>

<script>
import LazyHydrate from 'vue-lazy-hydration';
export default {
    components: {
        LazyHydrate,
        Observer: () => import(/* webpackChunkName: "dist/js/home/home-nav/observer" */ "../Observer"),
    },
    data() {
        return {
            loading:false,
            hiddenNavbar: false,
            lastScrollPosition: 1,
            fixedTop: false,
            marginMenu: false
        }

    },

    created() {
        window.addEventListener('scroll', this.onScroll);
    },

    destroyed() {
        window.removeEventListener('scroll', this.onScroll);
    },

    methods: {
        intersected() {
            this.loading=true
        },

        onScroll() {
            const currentScrollPosition = window.pageYOffset || document.documentElement.scrollTop;
            if (window.scrollY >= 1000) {
                this.fixedTop = true;
                this.marginMenu = true;
                if (currentScrollPosition > this.lastScrollPosition) {
                    this.hiddenNavbar = true;
                    this.lastScrollPosition = currentScrollPosition;
                } else {
                    this.hiddenNavbar = false;
                    this.lastScrollPosition = currentScrollPosition;
                }
            } else {
                this.fixedTop = false;
                this.marginMenu = false;
            }
        },
    }

}
</script>

<style scoped>
.h7-txt{
    height: 50px;
}

a, span {
    color: rgba(52, 58, 64, 0.7);
}

a:hover, a:active {
    border-bottom: 2px solid #793e87;
    color: rgb(52, 58, 64);
}

.menu-fixed {
    position: fixed;
    top: 66px;
    left: 0px;
    width: 100%;
    z-index: 3;
    background-color: #ffffff;
    padding: 15px 0 15px 42px;
}
</style>

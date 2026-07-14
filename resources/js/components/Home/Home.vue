<template>
    <div>
        <HomeHeader v-on:loadFont="loadFont" />
        <HomeFuture class="mt-100" />
        <template v-if="fontLoaded">
            <observer v-if="!loading" msg="home-partI" v-on:intersect="intersected"/>
            <template v-else>
                <HomeCarousel class="mt-100" />
                <HomeHsteam class="mt-100" />
                <HomeDetails class="mt-100" />
                <HomeInfo class="mt-100" />
                <LandingReviews class="mt-100" />
                <SponsorsBaner class="mt-100" />
                <HomeContact class="mt-100 mb-100" />
            </template>
        </template>
        <LeadsHomeModal />
        <ModalSubmitLeads />
    </div>
</template>

<script>
import { mapWritableState } from 'pinia';
import {VMenu,VList,VListItem,VBtn,VDialog,VIcon} from 'vuetify/lib'
import {ClickOutside} from 'vuetify/lib/directives/';
import { useAppStore } from '../../store/app';
import Observer from "../Observer"
import ModalSubmitLeads from '../Modals/ModalSubmitLeads.vue'

export default {
    name: "Home",

    components: {
        Observer,
        HomeHeader: () => import(
            /* webpackPrefetch: true */
            /* webpackChunkName: "dist/js/HomeHeader" */
            './HomeHeader.vue'
        ),
        HomeFuture: () => import(
            /* webpackPrefetch: true */
            /* webpackChunkName: "dist/js/HomeFuture" */
            './HomeFuture.vue'
        ),
        HomeCarousel: () => import(
            /* webpackPrefetch: true */
            /* webpackChunkName: "dist/js/HomeCarousel" */
            './HomeCarousel.vue'
        ),
        HomeHsteam: () => import(
            /* webpackPrefetch: true */
            /* webpackChunkName: "dist/js/HomeHsteam" */
            './HomeHsteam.vue'
        ),
        HomeDetails: () => import(
            /* webpackPrefetch: true */
            /* webpackChunkName: "dist/js/HomeDetails" */
            './HomeDetails.vue'
        ),
        HomeInfo: () => import(
            /* webpackPrefetch: true */
            /* webpackChunkName: "dist/js/HomeInfo" */
            './HomeInfo.vue'
        ),
        LandingReviews: () => import(
            /* webpackPrefetch: true */
            /* webpackChunkName: "dist/js/LandingReviews" */
            '../Landing/LandingReviews.vue'
        ),
        SponsorsBaner: () => import(
            /* webpackPrefetch: true */
            /* webpackChunkName: "dist/js/SponsorsBaner" */
            './SponsorsBaner.vue'
        ),
        HomeContact: () => import(
            /* webpackPrefetch: true */
            /* webpackChunkName: "dist/js/HomeContact" */
            './HomeContact.vue'
        ),
        LeadsHomeModal: () => import(
            /* webpackPrefetch: true */
            /* webpackChunkName: "dist/js/LeadsHomeModal" */
            '../Modals/LeadsHomeModal.vue'
        ),
        ModalSubmitLeads,

        VMenu,
        VDialog,
        VList,
        VListItem,
        VBtn,
        VIcon
    },

    directives: {ClickOutside},

    props: ['auth'],

    data: () => ({
        loading: false,
        fontLoaded: false
    }),

    computed: {
        ...mapWritableState(useAppStore, { appStoreOverlay: 'overlay' }),
    },

    created() {
        window.addEventListener('scroll', this.onScroll);
    },

    destroyed() {
        window.removeEventListener('scroll', this.onScroll);
    },

    methods: {
        intersected() {
            this.loading = true
        },
        loadFont() {
            console.log("font loaded")
            this.fontLoaded = true
            this.$nextTick(()=> {
                if (document.querySelector(`script[src*='facebook']`)) {
                    let scriptFace = document.querySelector(`script[src*='facebook']`);
                    scriptFace.parentNode.removeChild(scriptFace);
                }
            })
        }
    }
}
</script>

<style>
    @media (min-width: 1800px){
        .container{
            max-width: 1400px !important;
        }
    }
</style>

<template>
    <div>
        <h3 class="text-center text-dark mb-30">Nuestros profesores</h3>
        <LazyHydrate when-visible>
            <observer v-if="!loading" msg="our-teacher" v-on:intersect="intersected"/>
            <div v-else>
                <v-carousel
                    cycle
                    interval=3000
                    hide-delimiters
                    :show-arrows=false
                    height="272"
                >
                    <v-carousel-item
                        v-for="(slide, i) in teachers"
                        :key="i"
                        eager
                    >
                        <div class="row baner-teachers align-items-center">
                            <div class="container">
                                <div class="row justify-content-center">
                                    <div v-for="item in slide" class="col-6 col-md-3 col-lg-3">
                                        <v-lazy-image
                                            class="row mx-auto avatar"
                                            :src="url + item.avatar"
                                            :src-placeholder="default_image"
                                            alt="Fallback"
                                        >
                                            <source :srcset="url + item.avatar"/>
                                        </v-lazy-image>
                                        <h6>{{ item.name }} <br><span>{{ item.title }}</span></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </v-carousel-item>
                </v-carousel>
            </div>
        </LazyHydrate>
    </div>
</template>

<script>
import {VCarousel,VCarouselItem} from 'vuetify/es5/components/VCarousel'
import {VProgressLinear} from 'vuetify/es5/components/VProgressLinear'
import {VImg} from 'vuetify/es5/components/VImg'
import {VWindow} from 'vuetify/es5/components/VWindow'
import LazyHydrate from 'vue-lazy-hydration';
import Observer from "../Observer";
import VLazyImage from "v-lazy-image";
import Vuetify from "../../vuetify";
import { Ripple, Intersect, Touch, Resize } from 'vuetify/lib/directives';
import {GetObject} from "../../axios-services";
export default {
    Vuetify,
    components: {
        Observer,
        VLazyImage,
        LazyHydrate,
        VCarousel, VCarouselItem, VProgressLinear,VImg, VWindow
    },
    directives: { Ripple, Intersect, Touch, Resize },
    data() {
        return {
            loading: false,
            url: '',
            default_image: 'https://myawsmi-empresa.s3.eu-west-1.amazonaws.com/public/images/users/default.png',
        }
    },
    methods: {
        intersected() {
            this.loading = true
        },
    },
     mounted () {
         GetObject('teachers?is_featured=true', (error, data) => {
             if (error) {
                 this.teachers = []
             } else {
                 console.log('teachers')
                 console.log(data.teachers)
                 this.teachers = data.teachers
                 this.url = data.url
             }
         });
     }
}
</script>

<style scoped>
h3 {
    font-weight: 500;
}

.avatar {
    border-radius: 50%;
    width: 6.5em;
    height: 6.5em;
}

.baner-teachers {
    width: 100%;
    height: 272px;
    background-color: #eef0f3;
    margin: 0 !important;
}

h6 {
    font-family: Poppins;
    font-size: 14px;
    text-align: center;
    color: #343a40;
    opacity: 0.7;
    margin-top: 15px;
}

span {
    font-weight: 600;
    color: #29c0d3;
    opacity: 1 !important;
}

@media (min-width: 500px) and (max-width: 700px) {
    .avatar {
        width: 3.5em !important;
        height: 3.5em !important;
    }
}

.v-lazy-image {
    border-radius: 50%;
    opacity: 0;
}

.v-lazy-image-loaded {
    opacity: 1;
    transition: opacity 300ms;
}

</style>

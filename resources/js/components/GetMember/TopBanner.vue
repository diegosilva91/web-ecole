<template>
    <div>
        <observer v-if="!loading" msg="top-banner" v-on:intersect="intersected"/>
        <div class="lazyload" v-else>
            <template v-if="topBannerHome">
                <v-app-bar
                    flat
                    height="auto"
                    scroll-off-screen
                    v-show="topBanner"
                    class="bg-promo-banner"
                    :class="{'d-none':topBannerHome.visible=false}"
                >
                    <div class="col-8 col-md-10 col-lg-10 d-lg-flex d-md-flex">
                        <div class="text-promo title-getmember ml-tb-40 ml-dk-40 mr-auto">
                            <span :class="{'cyber-color':viewtype}">{{ topBannerHome.title }}</span>
                            {{ topBannerHome.subtitle }}
                        </div>
                        <div class="d-none d-lg-block"> 
                            <div class="timer" v-if="'time' in topBannerHome">
                                <template v-if="'days' in topBannerHome.time && 'hours' in topBannerHome.time && 'minutes' in topBannerHome.time">
                                    <span>{{topBannerHome.time.days}}</span> d <span class="ml-1">{{topBannerHome.time.hours}}</span> h <span class="ml-1">{{topBannerHome.time.minutes}}</span> min
                                </template>
                            </div>
                        </div>
                    </div>
                    <v-row class="col-4 col-md-2 col-lg-2 justify-content-lg-end ml-dk-15">
                        <a v-show="topBannerHome.link" :href="topBannerHome.link">
                            <button :class="{'cyber-btn':viewtype}" class="getMember-btn p-1">ver más</button>
                        </a>
                    </v-row>
                    <div @click="closeBanner()" class="close-btn"><img src="/assets/images/icons/close_top_banner.svg" alt=""></div>
                </v-app-bar>
            </template>
        </div>
    </div>
</template>

<script>
import Observer from "../Observer";

export default {
    props: ['viewtype', 'topBannerHome'],
    components: {
        Observer
    },
    data: () => ({
        loading: false,
        topBanner: true,
    }),

    mounted() {
        console.log(this.topBannerHome);
        let top = this.$cookies.get('topPromo');
        if (top) {
            this.topBanner = false;
        }
    },

    methods: {
        intersected() {
            this.$nextTick(() => {
                setTimeout(() => {
                    this.loading = true
                }, 2000);
            })
        },
        closeBanner() {
            this.topBanner = false;
            let topPromo = this.$cookies.set("topPromo", topPromo, "1d");
        }
    }
}
</script>

<style scoped>
.title-getmember {
    font-family: 'Poppins';
    font-size: 16px;
    font-weight: 400;
}

.title-getmember > span {
    font-weight: 600;
    color: #fff;
    margin-right: 20px;
    font-size: 24px;
}

.title-getmember > span.cyber-color {
    color: #29c0d3;
}

.getMember-btn {
    width: 122px;
    height: 32px;
    border-radius: 3px;
    box-shadow: 0 2px 5px 0 rgba(52, 58, 64, 0.25);
    background-color: #fff;
    font-family: 'Poppins';
    font-size: 14px;
    font-weight: bold;
    color: #793e87;
    text-transform: uppercase;
    margin-left: auto;
    margin-right: 25px;
}

.getMember-btn.cyber-btn {
    background-color: #29c0d3;
    color: #1a1d1f;
}

.close-btn {
    font-size: 24px;
    font-weight: 700;
    position: absolute;
    top: -5px;
    right: 2px;
    margin-right: 5px;
    cursor: pointer;
    color: white;
}

.bg-promo-banner {
    background-image: linear-gradient(to right, #793e87, #29c0d3);
}

.timer {
    font-family: 'Poppins';
    font-size: 18px;
    color: #fff;
}

.text-promo {
    color: #fff;
}

.timer > span {
    font-size: 24px;
    font-weight: 700;
    width: 46px;
    height: 37px;
    border-radius: 3px;
    background-color: #85B7D0;
    color: #fff;
    text-align: center;
}

@media (max-width: 900px) {
    .title-getmember {
        font-size: 18px;
    }

    .title-getmember > span {
        font-size: 21px;
        margin-right: 5px;
    }

    .title-getmember > span.cyber-color {
        font-size: 19px;
    }

    .getMember-btn {
        margin-left: 30px;
    }
}

@media (max-width: 430px) {
    .title-getmember {
        font-size: 12px;
    }

    .title-getmember > span {
        font-size: 18px;
    }

    .title-getmember > span.cyber-color {
        font-size: 16px;
        font-weight: 700;
    }

    .getMember-btn {
        width: 95px;
        margin-left: 20px;
    }
}
</style>

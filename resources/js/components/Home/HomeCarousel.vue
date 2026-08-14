<template>
    <div>
        <h3 class="text-center mb-60">Sumérgete en el mundo Lifecooler</h3>
        <div class="bg-carousel py-4">
            <div class="py-2">
                <div class="container">
                    <div class="row d-flex justify-content-center pb-1 mb-2">
                        <div class="mb-2 mt-2" v-for="(category, i) in categories" :key="i">
                            <h2 @click="ActiveCategory(category.category,category.category_id)" class="my-auto"
                                :class="{'active':activeCategory['category']===category.category}">{{ category.category }}</h2>
                        </div>
                    </div>
                </div>
                <div id="slide" class="carousel pb-2 mb-3" v-resize="carouselOnResize">
                    <div
                        v-show="!carouselContentScrollIsInStart && !carouselArrowHidden"
                        class="carousel__arrow carousel__arrow-left d-lg-none"
                        @click="carouselOnArrowClicked('left')"
                    >
                        <img class="back-arrow" src="/assets/images/icons/arrow_next_mob.svg" alt="">
                    </div>
                    <div
                        ref="carouselContainerRef"
                        class="carousel__content"
                        v-scroll.self="carouselOnScroll"
                        v-touch="{ move: () => carouselOnTouch() }"
                    >
                        <div class="carousel__item is-active" v-for="(card, i) in cards" :key="i">
                            <a class="course-featured-card" :href="card.url">
                                <img class="course-featured-card__img" :src="url + card.image" width="255" height="255" alt="">
                                <div class="course-featured-card__chip top-left" :style="{backgroundColor:card.label_color}">
                                    {{ card.label_text }}
                                </div>
                                <div class="bottom-left text-left tag-category">{{ card.title }}</div>
                            </a>
                        </div>
                    </div>
                    <div
                        v-show="!carouselContentScrollIsInEnd && !carouselArrowHidden"
                        class="carousel__arrow carousel__arrow-right d-lg-none"
                        @click="carouselOnArrowClicked('right')"
                    >
                        <img src="/assets/images/icons/arrow_next_mob.svg" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import { GetObject } from "../../axios-services";

export default {
    data: () => ({
        activeCategory: [],
        cards: [],
        carouselContentScrollIsInEnd: false,
        carouselContentScrollIsInStart: false,
        carouselArrowHidden: false,
        categories: [],
        url: 'https://myawsmi-empresa.s3.eu-west-1.amazonaws.com/public/',
    }),

    async mounted() {
        let data = {bannerFeatured: [], url: '', categories: []};
        data = await this.GetBannerFeatured('/categories');
        if (data.categories) {
            this.categories = data.categories;
            if (this.categories.length > 0 && this.categories[0].category) {
                await this.ActiveCategory(this.categories[0].category, this.categories[0].category_id);
            }
        }
        this.$refs.carouselContainerRef.scrollLeft = 1;

        this.carouselOnScroll();
    },

    methods: {
        async ActiveCategory(title, id) {
            this.$refs.carouselContainerRef.scrollTo({ left: 1, behavior: 'smooth'});
            let data;
            this.$set(this.activeCategory, 'category', title);
            data = await this.GetBannerFeatured(`?category=${id}`);
            if (data.bannerFeatured) {
                this.cards = data.bannerFeatured;
                this.url = data.url
            }
        },

        carouselOnArrowClicked(direction) {
            const scrollTo = direction === 'right'
                ? this.$refs.carouselContainerRef.scrollLeft + 265
                : this.$refs.carouselContainerRef.scrollLeft - 265;
            this.$refs.carouselContainerRef.scroll({ left: scrollTo, behavior: 'smooth' });
        },

        carouselOnScroll() {
            const carouselContainerRefScrollLeftMax =
                this.$refs.carouselContainerRef.scrollWidth - this.$refs.carouselContainerRef.clientWidth
            this.carouselContentScrollIsInEnd = (
                carouselContainerRefScrollLeftMax
                - this.$refs.carouselContainerRef.scrollLeft
                < 20
            );
            this.carouselContentScrollIsInStart = this.$refs.carouselContainerRef.scrollLeft < 25;

            const container = this.$refs.carouselContainerRef;
            const displayWidth = window.innerWidth;
            let scrollDifferenceSmaller = 99999;
            if (displayWidth < 600) {
                [].slice.call(container.children).forEach(function (ele, _index) {
                    ele.classList.remove('is-active');
                    const scrollDifference = ele.offsetLeft - container.scrollLeft;
                    if (scrollDifference > 0 && scrollDifference < scrollDifferenceSmaller) {
                        scrollDifferenceSmaller = scrollDifference;
                        ele.classList.add('is-active');
                    }
                });
            } else {
                [].slice.call(container.children).forEach(function (ele, _index) {
                    ele.classList.add('is-active');
                });
            }
        },

        carouselOnResize() {
            this.$refs.carouselContainerRef.scrollLeft += 1;
        },

        carouselOnTouch() {
            this.carouselArrowHidden = true;
        },

        async GetBannerFeatured(query) {
            let data;
            try {
                data = await GetObject(`banner-featured${query}`, null);
            } catch (e) {
                data = {cards: [], url: '', categories: []};
            }
            return data;
        }
    }
}
</script>

<style lang="scss" scoped>
@import '~vuetify/src/styles/styles.sass';

.carousel__content {
    align-items: center;
    display: flex;
    -ms-overflow-style: none;
    overflow-x: scroll;
    overflow-y: hidden;
    scroll-snap-type: x mandatory;
    scrollbar-width: none;

    &::-webkit-scrollbar {
        display: none;
    }

    .carousel__item:first-child {
        padding-left: 50px;
    }

    .carousel__item:last-child {
        padding-right: 50px;
    }
}

@media #{map-get($display-breakpoints, 'sm-and-up')} {
    .carousel__content {
        padding: {
            right: 12px;
            left: 12px;
        }
        scroll-snap-type: none;
    }
}

@media #{map-get($display-breakpoints, 'md-and-up')} {
    .carousel__content {
        justify-content: center;

        .carousel__item:first-child {
            padding-left: 0;
        }

        .carousel__item:last-child {
            padding-right: 0;
        }
    }
}

.carousel__item {
    margin: 0 8px;
    padding: 12px;
    opacity: .4;
    scroll-snap-align: center;
    transition: opacity .1s ease-in-out;

    &.is-active {
        opacity: 1;
    }
}

.carousel__arrow {
    cursor: pointer;
    position: absolute;
    top: calc(50% - 16px);
    z-index: 5;
}

.carousel__arrow-left {
    left: 12px;
    transform: rotate(-180deg);
}

.carousel__arrow-right {
    right: 12px;
}

.course-featured-card {
    box-shadow: 0 4px 9px 0 #3a1c4b;
    color: #fff;
    position: relative
}

.course-featured-card__img {
    max-width: none;
}

.course-featured-card__chip {
    border-radius: 4px;
    font-size: 12px;
    font-weight: 600;
    padding: 3px 15px;
}

h3 {
    font-weight: 500;
}

h2 {
    font-size: 14px;
    font-weight: 500;
    color: #fff;
    margin-right: 30px;
    cursor: pointer;
    padding: 4px 8px;
}

.active {
    font-weight: 600;
    color: #82388b;
    border-radius: 4px;
    background-color: #fff;
}

.bg-carousel {
    background-image: linear-gradient(to top, #502767, #bd85d7);
    height: auto;
}

.top-left {
    position: absolute;
    top: 10px;
    left: 16px;
}

.bottom-left {
    position: absolute;
    bottom: 12px;
    left: 16px;
    margin-right: 16px;
}

.tag-new {
    font-size: 12px;
    font-weight: 600;
    border-radius: 4px;
    padding: 3px 15px;
}

.tag-category {
    font-size: 16px;
    font-weight: 600;
}


@media (max-width: 430px) {
    h2 {
        margin-right: 10px;
    }
}

@media (max-width: 1000px) {
    .bg-carousel {
        height: 460px;
    }
}

@media (min-width: 1200px){
    .container{
        max-width: 1400px !important;
    }
}

</style>
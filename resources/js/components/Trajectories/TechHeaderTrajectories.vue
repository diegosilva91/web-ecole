<template>
    <div :class="bg">
        <observer msg="tech-header" v-on:intersect="intersected"/>
        <div v-if="loading">
            <div class="box">
                <div class="row">
                    <div :class="summer?'col-lg-5':'col-lg-6'" class="col-12 my-auto">
                        <h1 :class="[{'text-dark summer-title':summer},{'text-dark col-lg-10 pl-0':trajectories}]">
                            {{ title }}</h1>
                        <p :class="[{'text-shadow':shadow},{'text-dark summer-p mt-10':summer},{'text-dark':trajectories}]"
                           class="mt-6 pr-lg-16">{{ description }}</p>
                        <a href="/es/campus-verano" v-show="summer">
                            <button class="btn-summer mt-2 mb-2">Descubrir</button>
                        </a>
                    </div>
                    <div :class="summer?'col-lg-7':'col-lg-6'" class="col-12 my-auto text-center">
                        <img :src="`/assets/images/categories/${img}.svg`" alt="">
                        <img :src="imgAWS" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Observer from "../Observer"

export default {
    props: ['bg', 'title', 'description', 'shadow', 'img', 'summer', 'imgAWS', 'trajectories'],
    components: {
        Observer,

    },
    data() {
        return {
            loading: false,
        }
    },
    mounted() {
    },
    methods: {
        intersected() {
            this.loading = true
        }
    }

}
</script>

<style scoped>
h1 {
    font-family: 'Poppins';
    font-size: 50px;
    font-weight: bold;
    color: #fff;
}

p {
    font-family: 'Poppins';
    font-size: 22px;
    font-weight: 500;
    color: #fff;
}

.summer-title {
    font-size: 36px;
}

.summer-p {
    font-size: 18px;
    font-weight: 400;
}

.box {
    margin-left: 10%;
    margin-right: 10%;
    padding-top: 75px;
    padding-bottom: 75px;
}

.btn-summer {
    width: 135px;
    height: 31px;
    border-radius: 8px;
    box-shadow: 0 2px 8px 0 rgba(35, 158, 173, 0.5);
    background-color: #29c0d3;
    font-family: 'Open Sans';
    font-size: 14px;
    font-weight: 600;
    color: #ffffff;
}

.bg-tech-darkblue {
    background-image: linear-gradient(to bottom, #2a6368, #3c868c);
    height: auto;
}

.bg-tech-yellow {
    background-image: linear-gradient(to top, #ffd77b, #ffba17);
    height: auto;
}

.bg-tech-blue {
    background-image: linear-gradient(to top, #56e0f1, #29c0d3);
    height: auto;
}

.bg-tech-purple {
    background-image: linear-gradient(to top, #905995, #5c2767);
    height: auto;
}

.bg-trajectories {
    background-color: #def2f4;
    height: auto;
}

.bg-tech-summer {
    background-color: #dbf4f7;
}

.text-shadow {
    text-shadow: 0 2px 18px rgba(194, 143, 20, 0.77);
}

@media (max-width: 414px) {
    h1 {
        font-size: 40px;
    }

    p {
        font-size: 18px;
    }
}

</style>

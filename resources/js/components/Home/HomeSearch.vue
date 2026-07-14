<template>
    <LazyHydrate when-visible>
    <div :class="font">
        <div class="box">
            <h2 class="search-title pl-2 pr-2">Aprende disfrutando con los mejores profesores</h2>
            <h1 class="subtitle mt-10 mb-25 pl-3 pr-3">Cursos extraescolares online y en vivo para los genios del futuro<br class="d-none d-sm-block">
            en grupos reducidos y horarios flexibles</h1>
            <div class="d-flex justify-content-center mt-mob-100 mt-tb-100">
                <button id="btnScroll" @click="typeForm" class="btn-recommended" data-toggle="modal" :data-target="dataTarget">Recomiéndame</button>
            </div>
            <!-- <div class="d-flex justify-content-center mt-6">
                <input id="searchInpt" v-model="search" @keyup.enter="updateSearch" type="text"
                       class="home-search text-dark" placeholder="¿Qué quieres aprender?…"/>
                <button class="search-btn text-white" @click="updateSearch">Buscar</button>
            </div> -->
            <div class="d-none d-xl-block">
                <div class="row justify-content-center info-posit">
                    <div class="mr-dk-130 z2">
                        <h5>Somos el futuro</h5>
                        <h6>
                            Formamos a los genios del futuro. Somos<br> Innovadores, visionarios, actuales y creativos
                        </h6>
                    </div>
                    <div class="mr-dk-130 z2">
                        <h5>Somos Lifecoolers</h5>
                        <h6>
                            Apostamos por un nuevo tipo de educación<br> más digital más práctica y divertida.
                        </h6>
                    </div>
                    <div class="z2">
                        <h5>Somos seguros</h5>
                        <h6>
                            Somos una plataforma safety,<br> prestigiosa y puntera.
                        </h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </LazyHydrate>
</template>

<script>
import LazyHydrate from 'vue-lazy-hydration';
import Event from "../../event";
export default {
    props:['auth'],
    components: {
        LazyHydrate,
    },
    data() {
        return {
            font:'',
            search: '',
            querySearch: '',
            dataTarget:this.auth?'':'#Register',
            changeModal: false,
            scrolled: false
        }
    },
    mounted() {
        this.$nextTick(()=>{
            setTimeout(() =>{
                this.font="bg-img lazyload";
                this.$emit('loadFont');
            },50)
        })
    },

    methods: {
        updateSearch() {
            window.location.href='/es/cursos?search='+this.search
        },
        typeForm(){
            if(this.auth===false) {
                window.location.href = '/es/recommender'
            }else{
                this.changeModal=true;
                this.dataTarget='#Register'
                Event.$emit('modal.recommender',true);
                if(this.scrolled){
                    Event.$emit('modal.register.scroll',true);
                }
            }
        },
    }

}
</script>

<style scoped>
h5 {
    font-weight: 600;
    color: #fff;
}

h6 {
    color: #fff;
    margin-top: 4px;
}

.bg-img {
    background-image: url('/assets/images/backgrounds/bg_home.webp');
    background-image: -webkit-image-set(url('/assets/images/backgrounds/bg_home.jpg') 1x);
    background-repeat: no-repeat;
    background-size: cover;
    height: 800px;
}

.info-posit{
    position: relative;
    top: 240px
}

.box {
    padding-top: 240px;
}

.z2 {
z-index: 2;
}

.search-title {
    text-shadow: 0 3px 8px rgba(0, 0, 0, 0.5);
    font-family: 'Poppins', sans-serif;
    font-size: 35px;
    font-weight: 700;
    font-stretch: normal;
    font-style: normal;
    line-height: normal;
    letter-spacing: normal;
    text-align: center;
    color: #fff;
}

.subtitle {
    text-shadow: 0 3px 8px rgba(0, 0, 0, 0.5);
    font-family: 'Poppins', sans-serif;
    font-size: 24px;
    font-weight: 400;
    font-stretch: normal;
    font-style: normal;
    line-height: normal;
    letter-spacing: normal;
    text-align: center;
    color: #fff;
}

.home-search {
    width: 520px;
    height: 50px;
    border-radius: 6px 0px 0px 6px;
    padding: 10px 10px 10px 50px !important;
    background-color: #fff !important;
    background: url('/assets/images/filters/search.svg') no-repeat;
    background-position: 2% 50% !important;
    font-family: 'Poppins';
    font-size: 14px;
}

#searchInpt::-webkit-input-placeholder { /* Chrome/Opera/Safari */
    padding-left: 15px;
    font-family: 'Poppins';
    font-size: 14px;
    color: rgba(52, 58, 64, 0.7);
}

#searchInpt::-moz-placeholder { /* Firefox 19+ */
    padding-left: 15px;
    font-family: 'Poppins';
    font-size: 14px;
    color: rgba(52, 58, 64, 0.7);
}

#searchInpt:-ms-input-placeholder { /* IE 10+ */
    padding-left: 15px;
    font-family: 'Poppins';
    font-size: 14px;
    color: rgba(52, 58, 64, 0.7);
}

.search-btn {
    width: 114px;
    height: 50px;
    border-radius: 0px 6px 6px 0px;
    background-color: #29c0d3;
    text-transform: uppercase;
    font-family: 'Poppins';
    font-weight: 600;
}

.btn-recommended {
  width: 156px;
  height: 43px;
  border-radius: 6px;
  background-color: #29c0d3;
  font-family: 'Open Sans';
  font-size: 14px;
  font-weight: 700;
  color:#ffffff;
  text-transform: uppercase;
}

@media  (max-width: 668px) {
    .bg-img {
        background-image: url('/assets/images/backgrounds/header_bg_mob.png');
        background-image: -webkit-image-set(url('/assets/images/backgrounds/header_bg_mob.webp') 1x);
        height: 690px !important;
        background-size: cover;
    }

    .box {
        padding-top: 140px;
    }


    .search-title {
        font-size: 34px;
    }

    .subtitle {
        font-size: 21px;
    }

    .home-search {
        width: 325px;
        position: absolute;
        top: 116px;
        border-radius: 6px;
        background-position: 8% 50% !important;
    }

    .search-btn {
        display: none;
    }

}

</style>

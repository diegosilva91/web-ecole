<template>
    <div class="bg-techlanding">
        <div class="box row pt-16">
            <div class="col-12 col-lg-5 my-auto">
                <h1 class="search-title pr-lg-10">Bienvenido a la escuela online de cursos extraescolares en nuevas tecnologías</h1>
                <h2 class="subtitle mt-5 pr-lg-10">Descubre cómo tus hijos sacarán su máximo potencial a partir de sus <span>pasiones.</span></h2>
                <!--<h3 class="subtitle mt-5">Aprende disfrutando con los mejores profesores, <br /> en grupo reducidos y horarios flexibles</h3>-->
                <button id="landing-button" @click="openForm()" class="landing-btn mt-5">SESIÓN INFORMATIVA GRATIS</button>
            </div>
            <div class="col-10 col-lg-6 p-3 ml-auto mx-sm-auto mt-7 mb-15 pl-0 pr-0 pb-0">
                <!-- <landing-form-tech id="formLanding" viewType="" :categoryModal="categoryModal" :category="category" class="d-none d-md-block"></landing-form-tech> -->
                <div class="d-none d-md-block">
                    <img src="/assets/images/landing_mkt/landing_mkt_header.svg" alt="">
                </div>
                <div class="d-block d-md-none">
                    <img class="row mx-sm-auto" src="/assets/images/landing_mkt/landing_mkt_header_mob.svg" alt="">
                </div>
            </div>
        </div>
        <!-- <div :class="hiddenButton?'d-none':'d-block d-md-none'">
						<h5>Inscríbete hoy y recibe un cupón del 10% de descuento para tu primer curso</h5>
						<h5>Déjanos tus datos y te contactaremos</h5>
						<button @click="showModal" type="button" class="row btn-header-mob mx-auto mt-5 mb-5">VER DESCUENTOS</button>
				</div> -->
        <div class="row justify-content-center ml-mob-20 ml-tb-15 mr-tb-5 mt-50">
            <div class="col-12 col-sm-4 col-md-3 mr-dk-40">
                <div class="d-flex">
                    <img class="mr-5" src="/assets/images/landing_mkt/info_future.svg" alt="">
                    <div>
                        <h5>Somos el futuro</h5>
                        <h6 class="pr-lg-10">
                            Formamos a los genios del futuro. Somos Innovadores, visionarios, actuales y creativos.
                        </h6>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-4 col-md-3 mr-dk-40">
                <div class="d-flex">
                    <img class="mr-5" src="/assets/images/landing_mkt/info_edu.svg" alt="">
                    <div>
                        <h5>Somos Lifecoolers</h5>
                        <h6 class="pr-lg-15">
                            Apostamos por un nuevo tipo de educación más digital, práctica y divertida.
                        </h6>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-4 col-md-3">
                <div class="d-flex">
                    <img class="mr-5" src="/assets/images/landing_mkt/info_safety.svg" alt="">
                    <div>
                        <h5>Somos seguros</h5>
                        <h6>
                            Somos una plataforma safety,<br class="d-block d-sm-none d-lg-block"> prestigiosa y puntera.
                        </h6>
                    </div>
                </div>
            </div>
        </div>
        <a href="https://wa.me/+34633651856?text=Hola! Estoy interesado en uno de los cursos de Lifecole!"
           class="wpfloat" target="_blank">
           <v-icon color="#fff" size="30" style="margin-top: 10px">{{ mdiWhatsapp }}</v-icon>
        </a>
    </div>
</template>

<script>
import { mdiWhatsapp } from "@mdi/js";
import Event from '../../event.js';

export default {
    mounted() {
        window.beforeunload = this.leaving;
        window.onblur = this.leaving;
        window.addEventListener('beforeunload', this.leaving);
    },
    // destroyed() {
    //     window.removeEventListener('scroll', this.handleScroll);
    // },
    data() {
        return {
            category: '',
            categoryModal: 'category',
            courseTitle: 'Cursos',
            hiddenButton: false,
            mdiWhatsapp
        }
    },
    methods: {
        //    showModal() {
        //      let formLanding = document.getElementById('formLanding');
        //      formLanding.classList.remove("d-none");
        //      this.hiddenButton = true;
        //    },
        openForm() {
            Event.$emit('show-modal-card');
        },
        leaving() {
            this.$cookies.remove('hideLandingModal');
        }
    },
}
</script>

<style scoped>

.box {
    margin-left: 10%;
    margin-right: 10%;
}

.title-getmember > span {
    font-weight: 600;
    color: #ffb300;
    margin-right: 20px;
    font-size: 24px;
}

h5 {
    font-weight: 600;
}

h6 {
    font-weight: 300;
    margin-top: 4px;
    line-height: 1.5;
}

.bg-techlanding {
    background-image: linear-gradient(to bottom, #dbf4f7 9%, rgba(239, 250, 252, 0));
    height: 730px;
}

.search-title {
    font-family: 'Poppins', sans-serif;
    font-size: 33px;
    font-weight: 700;
    font-stretch: normal;
    font-style: normal;
    line-height: normal;
    letter-spacing: normal;
    text-align: left;
}

.subtitle {
    font-family: 'Poppins', sans-serif;
    font-size: 21px;
    font-weight: 400;
    font-stretch: normal;
    font-style: normal;
    line-height: normal;
    letter-spacing: normal;
    text-align: left;
}

.subtitle > span {
    font-size: 24px;
    font-weight: 600;
    color: #793e87;
}

.btn-header-mob {
    height: 40px;
    padding: 9px 30px;
    border-radius: 4px;
    box-shadow: 0 2px 5px 0 rgba(41, 192, 211, 0.3);
    border: solid 1px #29c0d3;
    background-color: #29c0d3;
    font-family: 'Poppins';
    font-size: 16px;
    font-weight: 600;
    color: #ffffff;
}

.wpfloat {
    position: fixed;
    width: 60px;
    height: 60px;
    bottom: 40px;
    right: 40px;
    background-color: #25d366;
    color: #FFF;
    border-radius: 50px;
    text-align: center;
    font-size: 30px;
    box-shadow: 2px 2px 3px #999;
    z-index: 199;
}

.landing-btn {
    width: auto;
    height: 43px;
    border-radius: 6px;
    background-color: #29c0d3;
    color: #fff;
    font-family: 'Open Sans';
    font-size: 14px;
    font-weight: bold;
    padding: 12px;
}

@media (max-width: 1300px) {

    .box {
        margin-left: 5%;
        margin-right: 0%;
    }

    .bg-techlanding {
        height: auto;
    }
}

@media (max-width: 414px) {
    .search-title {
        font-size: 30px;
        font-weight: 600;
    }
}

@media (max-width: 360px) {
    .search-title {
        font-size: 26px;
        font-weight: 600;
    }

    .subtitle {
        font-size: 18px;
    }

    .subtitle > span {
        font-size: 21px;
    }
}

</style>

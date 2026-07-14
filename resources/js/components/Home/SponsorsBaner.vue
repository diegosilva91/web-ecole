<template>
  <div class="text-dark">
      <h3 class="text-center mb-60">Nos recomiendan</h3>
      <observer v-if="!loading" msg="sponsors-banner" v-on:intersect="intersected"/>
      <div class="bg-sponsors" v-else>
        <div class="container">
            <div class="row text-center justify-content-center align-items-center pl-5 pr-5">
                <div class="col-6 col-md-4 col-lg-2 mb-mob-10 mb-tb-20">    
                  <img class="w-tb-50 " src="/assets/images/home/atresmedia-logo.png" alt="">
                </div>
                <div class="col-6 col-md-4 col-lg-2 mb-mob-20 mb-tb-20">
                  <img class="w-tb-50 w-dk-75" src="/assets/images/home/lavanguardia-logo.png" alt="">
                </div>
                <div class="col-6 col-md-4 col-lg-2 mb-mob-20 mb-tb-20">
                  <img class="w-mob-50 w-tb-25 w-dk-50" src="/assets/images/home/logo-hub.png" alt="">
                </div>
                <div class="col-6 col-md-4 col-lg-2 mb-mob-10 mb-tb-20 order-first order-md-0">
                  <img class="w-tb-50" src="/assets/images/home/eleconomista-logo.png" alt="">  
                </div>
                <div class="col-6 col-md-4 col-lg-2">
                  <img class="w-mob-50 w-tb-25 w-dk-50" src="/assets/images/home/abc-logo.png" alt="">
                </div>
                <div class="col-6 col-md-4 col-lg-2">
                  <img class="w-tb-50" src="/assets/images/home/elreferente-logo.png" alt="">  
                </div>
            </div>
        </div>
      </div>
  </div>
</template>

<script>
import Observer from "../Observer"
export default {
    components: {
        Observer,
    },
    data() {
        return {
            loading: false,
        }
    },
    methods: {
        intersected() {
            this.loading = true
        },
    }
}
</script>

<style scoped>
    h3 {
        font-weight: 500;
    }

    .bg-sponsors {
      background-color: #f2feff;
    }

    @media (min-width: 1200px) {
      .container {
        margin-left: 15% !important;
        margin-right: 15% !important;
      }
    }
</style>

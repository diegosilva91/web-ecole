<template>
  <div class="row footer align-items-center v-application">
      <div class="container">
          <div class="row">
              <img class="ml-mob-15" src="/assets/images/home/logo-mi-empresa.svg" alt="">
              <h6 class="col-12 col-md-5 col-lg-4 my-auto p-tb-0 p-dk-0 mb-0 ml-sm-16">&copy; Copyrights 2020 Mi-empresa All rights reserved.</h6>
                <ul class="pl-0">
                    <li class="col-6 d-inline pr-tb-0 mr-mob-25"><a href="/es/aviso-legal">Aviso Legal</a></li>
                    <li class="col-6 d-inline pr-tb-0"><a href="/es/politica-de-privacidad">Política Privacidad</a></li>
                    <li class="col-6 d-inline pr-tb-0"><a href="/es/politica-de-cookies">Política Cookies</a></li>
                    <li class="col-6 d-inline"><a href="/es/terminos-y-condiciones">Condiciones de Servicio</a></li>
                </ul>
          </div>
      </div>
  </div>
</template>

<script>
export default {

}
</script>

<style scoped>
    .footer {
        background-color: #5c2767;
        height: 146px;
        margin: 0 !important;
    }

    h6, ul > li > a {
        font-family: Poppins;
        font-size: 11px;
        font-weight: 400;
        color: #b57ac4;
    }

    @media  (max-width: 767.98px) {
        .footer {
            height: 315px !important;
        }
    }
</style>

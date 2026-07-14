<template>
  <div class="container">
    <div class="row">
      <img class="mx-auto mb-30" src="/assets/images/home/quotes-icon.svg" alt="">
    </div>
    <div class="row reverse">
      <div class="col-12 col-md-3 col-lg-3">
        <img class="avatar row mx-auto avatar-posit-mob" src="/assets/images/team/Eric.jpg" alt="">
      </div>
      <div class="col-12 col-md-8 col-lg-8 text-dark mx-auto ml-0">
        <h5>Cerca de casa sólo tenía opciones de academias de inglés o de música y de
        deportes de equipo. Pero a mi hijo no le interesaba nada de eso… En cambio, ahora con el curso online de programación está encantado.
        <br><span class="mt-20"> - Eric F</span></h5>
      </div>
    </div>
  </div>
</template>

<script>
export default {

}
</script>

<style scoped>
  .avatar {
    border-radius: 50%;
    width: 6.5em;
  }

  h5 {
    font-weight: 300;
    line-height: 1.94;  
  }

  span {
    font-weight: 500;
  }

  @media (max-width: 640px) {
  .reverse {
    flex-direction: column-reverse;
  }

  .avatar-posit-mob{
    margin-left: 0px !important;
  }
  }
</style>
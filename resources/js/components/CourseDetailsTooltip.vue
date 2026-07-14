<template>
  <v-tooltip eager max-width="230px" color="#ffffff" bottom>
            <template v-slot:activator="{ on, attrs }">
                <img v-bind="attrs" v-on="on" class="ml-2" width="18px" height="18px" src="/assets/images/course/icons/group-6.svg" alt=""/>
            </template>
            <span style="box-shadow: 0 5px 10px 0 rgba(74, 64, 87, 0.2); border: solid 1px rgba(193, 199, 211, 0.3);border-radius:10px;" class="h8-txt-light text-dark p-2">Para poder llevarse a cabo el curso, se tendrán que cubrir las plazas mínimas requeridas.
            <br><strong>¡Comparte el curso con tus amig@s!</strong></span>
  </v-tooltip>
</template>

<script>
export default {

}
</script>

<style>

</style>
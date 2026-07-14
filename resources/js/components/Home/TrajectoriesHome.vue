<template>
  <div class="container">
        <h2 class="h2-txt-med text-dark text-center mt-100">Cursos anuales destacados</h2>
        <TrajectoriesList :queryFeatured="true" :hiddentitle="true" :hiddenfilter="true" :morebtn="true" />
  </div>
</template>

<script>
import TrajectoriesList from '../Trajectories/TrajectoriesList.vue'

export default {
    components: {
        TrajectoriesList
    }
}
</script>

<style>

</style>
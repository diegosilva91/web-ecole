<template>
  <section>
    <p class="mb-6">Elige la modalidad de suscripción de tu trayectoria educativa:</p>

    <course-plans></course-plans>

    <div class="text-center">
      <v-btn
        class="lc-btn lc-btn--link"
        color="accent"
        href="/es/terminos-y-condiciones"
        :ripple="false"
        target="_blank"
        text
      >
        Términos y condiciones
      </v-btn>
    </div>
  </section>
</template>

<script>
import CoursePlans from "./CoursePlans.vue";
export default {
  components: {
    CoursePlans,
  },
};
</script>
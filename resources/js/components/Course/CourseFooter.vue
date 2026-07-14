<template>
  <v-footer v-if="courseStoreCourse" class="course-footer white" app fixed padless outlined>
    <v-row justify="center">
      <v-col class="text-center">
        <div class="mb-2">
          <template v-if="courseStorePlanSelected">
            <span class="text-body-2 font-weight-semibold text-uppercase">
              {{ courseStorePlanSelected.name }}
            </span>
            <span class="text-body-2 font-weight-light">
              {{ courseStorePlanSelected.description }}
            </span>
          </template>
        </div>

        <div class="d-flex justify-center align-items-center">
          <span
            v-if="courseStorePlanSelected"
            class="d-inline-flex align-items-center mr-2"
          >
            <span class="primary--text text-h5 font-weight-semibold"
              >{{ courseStorePlanSelected.priceAmount }}€</span
            >
            <span class="primary--text text-body-2 font-weight-light"
              >/{{ courseStorePlanSelected.priceFraction }}</span
            >
          </span>
          <v-btn color="accent" large @click="courseStoreOnSubscribeClick($gtm)">
            <v-icon>$cartIcon</v-icon>
            {{ courseStoreIsTrajectory ? 'Suscribirme' : 'Comprar' }}
          </v-btn>
        </div>
      </v-col>
    </v-row>
  </v-footer>
</template>

<script>
import { mapActions, mapState } from "pinia";
import { useCourseStore } from "../../store/course";

export default {
  computed: {
    ...mapState(useCourseStore, {
      courseStoreCourse: "course",
      courseStoreIsTrajectory: "isTrajectory",
      courseStorePlanSelected: "planSelected",
      courseStoreUrlCheckout: "urlCheckout",
    }),
  },

  methods: {
    ...mapActions(useCourseStore, { courseStoreOnSubscribeClick: 'onSubscribeClick' }),
  }
};
</script>

<style lang="scss">
.course-footer {
  border-top: solid 1px rgba(193, 199, 211, 0.3);
  box-shadow: 0 -3px 20px 0 rgba(74, 64, 87, 0.13);
  min-height: 102px;
}
</style>
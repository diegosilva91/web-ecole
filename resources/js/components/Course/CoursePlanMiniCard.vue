<template>
  <v-card
    class="
      course-plan-mini-card
      d-flex
      flex-no-wrap
      justify-space-between
      align-items-center
      px-2
      py-2
    "
    :class="{ 'course-plan-mini-card--selected': isSelected }"
    :elevation="isSelected ? 8 : 7"
    link
    outlined
  >
    <div class="d-flex align-items-center">
      <v-radio-group :value="isSelected" hide-details class="mt-0 pt-0">
        <v-radio :value="true"></v-radio>
      </v-radio-group>

      <div class="course-plan-mini-card__title-container pr-1">
        <v-card-title
          v-if="!removeTitle"
          class="text-body-2 text-uppercase font-weight-semibold pt-0 pl-0 pr-0"
          :class="{ 'primary--text': isFeatured }"
          >{{ coursePlan.name }}</v-card-title
        >

        <v-card-subtitle class="font-weight-light pa-0">{{
          coursePlan.description
        }}</v-card-subtitle>
      </div>
    </div>

    <div class="d-flex align-items-center">
      <div
        class="course-plan-mini-card__price text-no-wrap"
        :class="{ 'primary--text': isFeatured }"
      >
        <span
          class="
            course-plan-mini-card__price-amount
            text-h5
            font-weight-semibold
          "
          >{{ coursePlan.priceAmount }}€</span
        >
        <span
          class="
            course-plan-mini-card__price-fraction
            text-body-2
            font-weight-light
          "
          >/{{ coursePlan.priceFraction }}</span
        >
      </div>

      <div class="course-plan-mini-card__extra-info">
        <course-plan-mini-card-dialog
          :coursePlan="coursePlan"
        ></course-plan-mini-card-dialog>
      </div>
    </div>
  </v-card>
</template>

<script>
import CoursePlanMiniCardDialog from "./CoursePlanMiniCardDialog.vue";

export default {
  components: {
    CoursePlanMiniCardDialog,
  },

  props: {
    coursePlan: {
      type: Object,
      required: true,
      default: () => {},
    },

    isFeatured: {
      type: Boolean,
      default: false,
    },

    isSelected: {
      type: Boolean,
      default: false,
    },

    removeTitle: {
      type: Boolean,
      default: false,
    },
  },
};
</script>

<style lang="scss" scoped>
.course-plan-mini-card {
  min-height: 68px;

  .v-card__title {
    word-break: normal;
  }
}

/// TODO: The border radius should be set in global variables
/// @link https://vuetifyjs.com/en/styles/border-radius/#overwriting-radiuses
.course-plan-mini-card {
  border-radius: 12px !important;
}

.course-plan-mini-card--selected {
  border-color: #885793;
}

.course-plan-mini-card__price-amount,
.course-plan-mini-card__price-fraction {
  vertical-align: middle;
}
</style>
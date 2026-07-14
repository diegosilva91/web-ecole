<template>
  <div>
    <course-details-card
      class="mb-7"
      :category="category"
      :course="course"
      :login="login"
      :promotion="promotion"
      :trajectory="trajectory"
      :session="session"
      :last_promotion="lastPromotion"
    ></course-details-card>

    <div v-if="trajectory">
      <course-plans-mini class="mb-7"></course-plans-mini>

      <v-btn color="accent" block large @click="courseStoreOnSubscribeClick($gtm)">
        <v-icon left>$cartIcon</v-icon>
        Suscribirme
      </v-btn>
    </div>
  </div>
</template>

<script>
import { mapActions } from "pinia";
import { useCourseStore } from "../../store/course";

export default {
  props: {
    category: {
      type: Object,
      default: () => {},
    },

    course: {
      type: Object,
      default: () => {},
    },

    lastPromotion: {
      type: Object,
      default: () => {},
    },

    login: {
      type: Boolean,
      default: false,
    },

    promotion: {
      type: Object,
      default: () => {},
    },

    session: {
      type: String,
      default: undefined,
    },

    trajectory: {
      type: Number,
      default: undefined,
    },
  },

  methods: {
    ...mapActions(useCourseStore, { courseStoreOnSubscribeClick: 'onSubscribeClick' }),
  },
};
</script>

<style lang="scss">
.card-position {
  position: absolute !important;
  top: 500px !important;
}
.course-sidebar {
  position: fixed;
  top: 50px;
  right: 130px;
  z-index: 3;
  display: inline-block;
  width: 350px;
}
@media (max-width: 1500px) {
  .course-sidebar {
    right: 50px !important;
  }
}
</style>
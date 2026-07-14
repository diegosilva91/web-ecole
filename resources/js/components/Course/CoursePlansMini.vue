<template>
  <v-item-group v-model="courseStorePlanSelected">
    <div class="mb-4">
      <v-item v-slot="{ active, toggle }" :value="courseStorePlanBasic">
        <course-plan-mini-card
          :isSelected="active"
          :coursePlan="courseStorePlanBasic"
          @click.native="toggle"
        ></course-plan-mini-card>
      </v-item>
    </div>

    <div>
      <v-item v-slot="{ active, toggle }" :value="courseStorePlanLifecooler">
        <course-plan-mini-card
          isFeatured
          :isSelected="active"
          :coursePlan="courseStorePlanLifecooler"
          @click.native="toggle"
        ></course-plan-mini-card>
      </v-item>
    </div>
  </v-item-group>
</template>

<script>
import { mapState, mapWritableState } from "pinia";
import { useCourseStore } from "../../store/course";
import CoursePlanMiniCard from "./CoursePlanMiniCard.vue";

export default {
  components: {
    CoursePlanMiniCard,
  },

  computed: {
    ...mapState(useCourseStore, {
      courseStoreCourse: "course",
      courseStorePlanBasic: "planBasic",
      courseStorePlanLifecooler: "planLifecooler",
    }),

    ...mapWritableState(useCourseStore, {
      courseStorePlanSelected: "planSelected",
    }),
  },
};
</script>
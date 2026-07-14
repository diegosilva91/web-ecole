<template>
  <v-item-group v-model="courseStorePlanSelected">
    <v-row class="mb-4" justify="space-around">
      <v-item v-slot="{ active, toggle }" :value="courseStorePlanBasic">
        <v-col cols="12" md="6" xl="4">
          <course-plan-card
            v-if="courseStorePlanBasic"
            :description="courseStorePlanBasic.description"
            :extraInfo="courseStorePlanBasic.extraInfo"
            :expandShown.sync="expandShownPlan"
            :is-selected="active"
            :featuresList="courseStorePlanBasic.featuresList"
            :priceAmount="courseStorePlanBasic.priceAmount"
            :priceFraction="courseStorePlanBasic.priceFraction"
            :title="courseStorePlanBasic.name"
            @actionClicked="toggle"
          ></course-plan-card>
        </v-col>
      </v-item>

      <v-item v-slot="{ active, toggle }" :value="courseStorePlanLifecooler">
        <v-col cols="12" md="6" xl="4">
          <course-plan-card
            v-if="courseStorePlanLifecooler"
            dark
            :description="courseStorePlanLifecooler.description"
            :extraInfo="courseStorePlanLifecooler.extraInfo"
            :expandShown.sync="expandShownPlan"
            :is-selected="active"
            :featuresList="courseStorePlanLifecooler.featuresList"
            :priceAmount="courseStorePlanLifecooler.priceAmount"
            :priceFraction="courseStorePlanLifecooler.priceFraction"
            ribbon-text="Popular"
            :title="courseStorePlanLifecooler.name"
            @actionClicked="toggle"
          ></course-plan-card>
        </v-col>
      </v-item>
    </v-row>
  </v-item-group>
</template>

<script>
import { mapState, mapWritableState } from "pinia";
import { useCourseStore } from "../../store/course";
import CoursePlanCard from "./CoursePlanCard.vue";

export default {
  components: {
    CoursePlanCard,
  },

  data() {
    return {      
      expandShownPlan: false
    };
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
  }
};
</script>
<template>
  <v-dialog v-model="dialog" max-width="350px" hide-overlay open-on-hover>
    <v-card>
      <v-card-title>{{ coursePlan.name }} </v-card-title>

      <v-card-text>
        <div v-if="coursePlan.longDescription">
          {{ coursePlan.longDescription }}
        </div>

        <v-list v-if="showFeaturesList" dense>
          <v-list-item v-for="(item, i) in coursePlan.featuresList" :key="i">
            <v-list-item-icon class="mr-1">
              <v-icon color="accent" small>{{ mdiCheckBold }}</v-icon>
            </v-list-item-icon>
            <v-list-item-content class="py-1">
              <v-list-item-title
                class="font-weight-light text-body-2 text-wrap"
                v-text="item.text"
              ></v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list>
      </v-card-text>
    </v-card>

    <!-- Activator -->
    <template v-slot:activator="{ on, attrs }">
      <v-btn color="accent" icon>
        <v-icon v-bind="attrs" v-on.prevent="on"
          >{{ mdiInformationOutline }}
        </v-icon>
      </v-btn>
    </template>
  </v-dialog>
</template>

<script>
import { mdiCheckBold, mdiInformationOutline } from "@mdi/js";

export default {
  props: {
    coursePlan: {
      type: Object,
      required: true,
      default: () => {},
    },

    showFeaturesList: {
      type: Boolean,
      default: false
    }
  },

  data: () => ({
    dialog: false,
    mdiCheckBold,
    mdiInformationOutline,
  }),
};
</script>

<style scoped>
.v-list--dense .v-list-item {
  min-height: 32px;
}

.v-list-item--dense .v-list-item__icon,
.v-list--dense .v-list-item .v-list-item__icon {
  margin-top: 4px;
  margin-bottom: 4px;
}
</style>
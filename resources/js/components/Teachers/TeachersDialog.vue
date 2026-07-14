<template>
  <v-dialog v-model="dialog" content-class="lc-dialog" scrollable max-width="747">
    <template v-slot:activator="{ on, attrs }">
      <v-btn class="lc-btn lc-btn--link" color="accent" :ripple="false" text v-bind="attrs" v-on="on"> Ver todos </v-btn>
    </template>
    <v-card>
      <v-card-title>
        <span>Profesores</span>
        <v-spacer></v-spacer>
        <v-btn class="lc-dialog__header-close-icon" icon @click="dialog = false">
          <v-icon>{{ mdiClose }}</v-icon>
        </v-btn>
      </v-card-title>
      <v-card-text class="px-0" style="max-height: 438px">
        <teachers-expansion-panels lateral-space40 :teachers="teachers" :url-base="urlBase"></teachers-expansion-panels>
      </v-card-text>
    </v-card>
  </v-dialog>
</template>

<script>
import { mdiClose } from "@mdi/js";
import TeachersExpansionPanels from "./TeachersExpansionPanels.vue";

export default {
  components: {
    TeachersExpansionPanels,
  },

  props: {
    teachers: {
      type: Array,
      required: true,
      default(_rawProp) {
        return [];
      },
    },

    urlBase: {
      type: String,
      required: true,
      default: "",
    }
  },

  data() {
    return {
      dialogm1: "",
      dialog: false,
      mdiClose
    };
  },
};
</script>
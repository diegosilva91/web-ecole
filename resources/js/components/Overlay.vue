<template>
  <v-overlay
    color="primary"
    opacity="0.13"
    :value="appStoreOverlay"
  ></v-overlay>
</template>

<script>
import { mapWritableState } from "pinia";
import { useAppStore } from "../store/app";

export default {
  computed: {
    ...mapWritableState(useAppStore, { appStoreOverlay: "overlay" }),
  },

  watch: {
    /**
     * Toggle vertical scroll when showing overlay.
     * 
     * The 'padding-right' property it is to keep the client width 
     * in browsers where the scrollbar takes up space (ex. Chrome).
     *
     * @param {boolean} value 'appStoreOverlay' value
     * @returns {any}
     */
    appStoreOverlay(value) {
      const htmlEl = document.documentElement;
      if (value) {
        htmlEl.style.setProperty(
          "padding-right",
          window.innerWidth - htmlEl.clientWidth + "px"
        );
        htmlEl.style.setProperty("overflow", "hidden");
      } else {
        htmlEl.style.removeProperty("overflow");
        htmlEl.style.removeProperty("padding-right");
      }
    },
  },
};
</script>
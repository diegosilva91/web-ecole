<template>
  <div class="course-plan-card">
    <v-card
      class="course-plan-card__content overflow-hidden"
      :class="{
        'course-plan-card__content--background-color': dark,
        'course-plan-card__content--selected': isSelected,
      }"
      :dark="dark"
      :outlined="!dark"
      elevation="1"
    >
      <div class="course-plan-card__title-container">
        <v-card-title
          class="
            justify-content-center
            text-h6 text-uppercase
            font-weight-bold
            pt-10
            pb-5
          "
          >{{ title }}</v-card-title
        >
      </div>

      <div class="course-plan-card__price text-center pb-7">
        <span class="course-plan-card__price-amount text-h4 font-weight-light"
          >{{ priceAmount }}€</span
        >
        <span
          class="
            course-plan-card__price-fraction
            text-body-2
            font-weight-medium
          "
          >/{{ priceFraction }}</span
        >
      </div>

      <div
        v-if="description"
        class="
          course-plan-card__description
          text-center
          pb-7
          text-body-2
          font-weight-light
        "
      >
        {{ description }}
      </div>

      <div class="course-plan-card__action text-center pb-7">
        <v-btn
          class="px-10"
          :color="dark ? 'white' : 'accent'"
          :depressed="dark"
          :disabled="isSelected"
          light
          large
          :href="actionHref"
          @click="onActionClick"
          >{{ actionText }}</v-btn
        >
      </div>

      <v-expand-transition v-if="featuresList">
        <div v-show="expandShownModel" class="course-plan-card__features-list">
          <v-list dense>
            <v-list-item v-for="(item, i) in featuresList" :key="i">
              <v-list-item-icon class="mr-1">
                <v-icon :color="dark ? 'white' : 'accent'" small>{{
                  mdiCheckBold
                }}</v-icon>
              </v-list-item-icon>
              <v-list-item-content class="py-1">
                <v-list-item-title
                  class="font-weight-light text-body-2 text-wrap"
                  v-html="item.text"
                ></v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </v-list>

          <div v-if="extraInfo" class="course-plan-card__extra-info font-weight-light text-caption">
            {{ extraInfo }}
          </div>
        </div>
      </v-expand-transition>

      <corner-ribbon
        v-if="ribbonText"
        class="font-weight-semibold primary--text"
        light
        :text="ribbonText"
      ></corner-ribbon>

      <v-card-actions v-if="featuresList" class="justify-content-center">
        <v-btn
          class="font-weight-regular"
          text
          small
          @click="expandShownModel = !expandShownModel"
        >
          <v-icon>{{
            expandShownModel ? mdiChevronUp : mdiChevronDown
          }}</v-icon>
          {{ expandShownModel ? "Ocultar detalle" : "Ver detalle" }}
        </v-btn>
      </v-card-actions>
    </v-card>

    <div v-if="isSelected" class="course-plan-card__corner-check">
      <v-icon color="white">{{ mdiCheckBold }}</v-icon>
    </div>
  </div>
</template>

<script>
import { mdiCheckBold, mdiChevronDown, mdiChevronUp } from "@mdi/js";
import CornerRibbon from "../CornerRibbon.vue";

export default {
  components: {
    CornerRibbon,
  },

  props: {
    actionHref: {
      type: String,
      default: undefined,
    },

    actionText: {
      type: String,
      default: "Elegir plan",
    },

    dark: {
      type: Boolean,
      default: false,
    },

    description: {
      type: String,
      default: undefined,
    },

    extraInfo: {
      type: String,
      default: undefined,
    },

    expandShown: {
      type: Boolean,
      default: false,
    },

    featuresList: {
      type: Array,
      default: undefined,
    },

    isSelected: {
      type: Boolean,
      default: false,
    },

    priceAmount: {
      type: Number,
      default: 0,
    },

    priceFraction: {
      type: String,
      default: "mes",
    },

    ribbonText: {
      type: String,
      default: undefined,
    },

    title: {
      type: String,
      default: "Plan Básico",
    },
  },

  data: () => ({
    mdiCheckBold,
    mdiChevronDown,
    mdiChevronUp,
  }),

  computed: {
    expandShownModel: {
      get() {
        return this.expandShown;
      },
      set(value) {
        this.$emit("update:expandShown", value);
      },
    },
  },

  methods: {
    onActionClick() {
      this.$emit("actionClicked");
    },
  },
};
</script>

<style lang="scss" scoped>
.course-plan-card {
  position: relative;
  height: 100%;
}

/// TODO: The border radius should be set in global variables
/// @link https://vuetifyjs.com/en/styles/border-radius/#overwriting-radiuses
.course-plan-card__content {
  border-radius: 12px !important;
  height: 100%;
  display: flex;
  flex-direction: column;  
}

.course-plan-card__content--selected {
  outline: 2px solid #ffb300;
  box-shadow: 0 5px 10px 0 rgba(255, 180, 0, 0.25) !important;
}

.course-plan-card__content--background-color {
  background: rgb(120, 38, 126);
  background: linear-gradient(
    180deg,
    rgba(120, 38, 126, 1) 0%,
    rgba(2, 210, 231, 1) 100%
  );
}

/// Special box shadow for white button
.course-plan-card__action {
  .v-btn {
    &.white {
      box-shadow: 0 2px 8px 0 rgba(35, 158, 173, 0.5) !important;
    }

    &.v-btn--disabled.v-btn--depressed.theme--light:not(.v-btn--text):not(.v-btn--outlined) {
      background-color: rgba(255, 255, 255, 0.77) !important;
    }
  }
}

.course-plan-card__corner-check {
  position: absolute;
  top: -10px;
  right: -10px;

  background-color: #ffb300;
  border-radius: 50%;
  padding: 3px;
}

.course-plan-card__features-list {
  margin-left: auto;
  margin-right: auto;
  padding: 0 30px;  
  display: flex;
  flex-direction: column;
  flex: 1;
  .v-list {
    background-color: transparent;
    flex: 1;
  }

  .v-list--dense .v-list-item {
    min-height: 32px;
  }

  .v-list-item--dense .v-list-item__icon, .v-list--dense .v-list-item .v-list-item__icon {
    margin-top: 4px;
    margin-bottom: 4px;
  }
}
</style>
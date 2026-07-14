<template>
  <div class="nav-bar-menu d-inline-block">
    <template v-for="(item, i) in appStoreMainMenu">
      <v-menu
        content-class="elevation-8"
        offset-y
        open-on-hover
        :key="i"
        :max-width="item.childrens ? '305' : undefined"
        @input="(item.childrens || item.childrensSpecial) && onMenuInput($event, i)"
      >
        <template v-slot:activator="{ on, attrs, value }">
          <v-btn
            :class="{ 'is-active': value }"
            color="primary"
            :ripple="false"
            small
            text
            :href="item.link"
            v-bind="attrs"
            v-on="on"
          >
            {{ item.title }}
            <v-icon v-if="item.childrens || item.childrensSpecial" right>{{
              mdiChevronDown
            }}</v-icon>
          </v-btn>
        </template>

        <v-list v-if="item.childrens" class="nav-bar-menu__sub-menu py-0" two-line>
          <template v-for="(subItem, index) in item.childrens">
            <v-list-item
              :key="index"
              :href="subItem.link"
              link
              class="px-7"
              :ripple="false"
            >
              <v-list-item-content>
                <v-list-item-title class="font-weight-medium text-body-1">{{
                  subItem.title
                }}</v-list-item-title>
                <v-list-item-subtitle v-if="subItem.subtitle">{{
                  subItem.subtitle
                }}</v-list-item-subtitle>
              </v-list-item-content>
            </v-list-item>
          </template>
        </v-list>

        <v-sheet v-if="item.childrensSpecial" class="nav-bar-menu__sub-menu-special px-5 py-3">
          <v-row class="row--semi-dense">
            <v-col
              v-for="(subItem, index) in item.childrensSpecial"
              :key="index"
            >
              <v-card
                class="nav-bar-menu__sub-menu-special-item text-center pa-3"
                elevation="1"
                :href="subItem.link"
                link
                max-width="247"
                outlined
                :ripple="false"
                :style="`--specialcolor: ${subItem.color}`"
              >
                <div>
                  <img
                    class="mb-1"
                    width="40px"
                    height="40px"
                    :src="`/assets/images/icons/${subItem.code}.svg`"
                    :alt="subItem.link"
                  />
                </div>
                <div class="font-weight-medium mb-1">{{ subItem.title }}</div>
                <div class="text-body-2 text--secondary">
                  {{ subItem.subtitle }}
                </div>
              </v-card>
            </v-col>
          </v-row>
        </v-sheet>
      </v-menu>
    </template>
  </div>
  
</template>

<script>
import { mapState, mapWritableState } from "pinia";
import { mdiChevronDown, mdiChevronUp } from "@mdi/js";
import { useAppStore } from "../store/app";

export default {
  data: () => ({
    mdiChevronDown,
    mdiChevronUp,
    // Array showing if each dropdown menu item is open
    menuItemsStatus: [],
  }),

  computed: {
    ...mapState(useAppStore, { appStoreMainMenu: "mainMenu" }),
    ...mapWritableState(useAppStore, { appStoreOverlay: "overlay" }),
  },

  methods: {
    onMenuInput(isOpen, index) {
      this.menuItemsStatus[index] = isOpen;
      this.appStoreOverlay = this.menuItemsStatus.some((v) => v);
    },
  },
};
</script>

<style lang="scss" scoped>
.nav-bar-menu {
  .v-btn {
    font-size: 14px;
    height: auto !important;
    letter-spacing: normal;
    padding: {
      top: 12px !important;
      bottom: 12px !important;
    }
    text-transform: none;

    &.primary--text {
      color: #793e87 !important;
    }

    &::before {
      display: none;
    }

    &:hover,
    &.is-active {
      ::after {
        background: linear-gradient(to right, #78267e 0%, #02d2e7 100%);
        content: "";
        position: absolute;
        left: 0;
        bottom: -12px;
        height: 2px;
        width: 100%;
      }
    }
  }
}

.v-menu__content {
  .v-list {
    .v-list-item__title {
      font-size: 14px;
    }
  }
}

.nav-bar-menu__sub-menu,
.nav-bar-menu__sub-menu-special {
  border-bottom: 3px solid;
  border-image-slice: 1;
  border-image-source: linear-gradient(to right, #78267e 0%, #02d2e7 100%);
}

.nav-bar-menu__sub-menu-special-item {
  &:hover,
  &.is-active {
    border-color: var(--specialcolor);
  }
}
</style>

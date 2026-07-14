<template>
  <v-expansion-panels accordion flat>
    <template v-for="(item, i) in teachers">
      <v-expansion-panel v-if="!maxItems || i < maxItems" :key="item.id">
        <v-expansion-panel-header
          :class="{ 'px-0': noLateralSpace, 'px-10': lateralSpace40 }"
        >
          <template v-slot:default="{ open }">
            <v-row align="center" no-gutters>
              <v-col cols="auto" :class="open ? 'mr-10' : 'mr-6'">
                <v-avatar :size="avatarSize(open)">
                  <img v-lazysizes alt="Avatar" :data-src="urlBase + item.avatar" />
                </v-avatar>
              </v-col>

              <v-col>
                <div class="text-subtitle-1">{{ item.name }}</div>
                <v-fade-transition leave-absolute>
                  <div v-if="open" class="text-subtitle-1 text--secondary">
                    {{ item.title }}
                  </div>
                </v-fade-transition>
              </v-col>
            </v-row>
          </template>
        </v-expansion-panel-header>

        <v-expansion-panel-content
          :class="{ 'mx-n6': noLateralSpace, 'px-4': lateralSpace40 }"
        >
          <div class="text-body-2 font-weight-light my-3">
            {{ item.bio }}
          </div>
        </v-expansion-panel-content>

        <v-divider v-if="showDivider(i)" :key="i"></v-divider>
      </v-expansion-panel>
    </template>
  </v-expansion-panels>
</template>

<script>
import vueLazysizes from 'vue-lazysizes';

export default {
  directives: {
    lazysizes: vueLazysizes
  },

  props: {
    enlargeAvatarOnOpen: {
      type: Boolean,
      required: false,
    },

    lateralSpace40: {
      type: Boolean,
      required: false,
    },

    maxItems: {
      type: Number,
      required: false,
    },

    noLateralSpace: {
      type: Boolean,
      required: false,
    },

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
    },
  },

  methods: {
    avatarSize(panelIsOpen) {
      if (this.enlargeAvatarOnOpen) {
        return panelIsOpen ? "66" : "54";
      } else {
        return "54";
      }
    },

    showDivider(panelIndex) {
      if (this.maxItems) {
        return (
          panelIndex !== this.teachers.length - 1 &&
          panelIndex !== this.maxItems - 1
        );
      } else {
        return panelIndex !== this.teachers.length - 1;
      }
    },
  },
};
</script>
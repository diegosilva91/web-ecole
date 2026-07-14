<template>
  <v-sheet
    class="corner-ribbon text-uppercase font-weight-semibold"
    :class="`corner-ribbon--${positionX} corner-ribbon--${positionY}`"
    :dark="dark"
    :light="light"
  >
    {{ text }}
  </v-sheet>
</template>

<script>
export default {
  props: {
    dark: {
      type: Boolean,
      default: false
    },

    light: {
      type: Boolean,
      default: false
    },

    positionX: {
      type: String,
      default: "left",
    },

    positionY: {
      type: String,
      default: "top",
    },

    text: {
      type: String,
      default: "Popular",
    },
  },
};
</script>

<style lang="scss" scoped>
.corner-ribbon {
  width: 95px;
  padding: 4px;
  position: absolute;
  text-align: center;

  font-size: .625rem;
}

/// Positions
.corner-ribbon--top {
  top: 14px;
}
.corner-ribbon--bottom {
  bottom: 14px;
}
.corner-ribbon--left {
  left: -22px;
}
.corner-ribbon--right {
  right: -22px;
}

/// Rotations
.corner-ribbon--top.corner-ribbon--left,
.corner-ribbon--bottom.corner-ribbon--right {
  transform: rotate(-45deg);
}

.corner-ribbon--top.corner-ribbon--right,
.corner-ribbon--bottom.corner-ribbon--left {
  transform: rotate(45deg);
}
</style>
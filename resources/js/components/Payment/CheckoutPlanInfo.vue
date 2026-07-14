<template>
  <v-card outlined rounded>
    <v-list class="p-0">
      <!-- NAME -->
      <v-list-item>
        <v-list-item-content>
          <v-list-item-title
            class="font-weight-semibold text-uppercase text-body-2"
            >{{ planSelected.name }}</v-list-item-title
          >
        </v-list-item-content>
      </v-list-item>

      <!-- PLAN OR COURSE PRICE -->
      <template>
        <v-divider></v-divider>

        <v-list-item>
          <v-list-item-content>
            <v-list-item-title class="text-subtitle-1"
              >Trayectoria</v-list-item-title
            >
          </v-list-item-content>

          <v-list-item-action>
            <v-list-item-action-text class="text-subtitle-1">
              {{ coursePrice | round(2) }} €
            </v-list-item-action-text>
          </v-list-item-action>
        </v-list-item>
      </template>

      <!-- IF PROMO DATA -->
      <template v-if="promoData">
        <v-divider></v-divider>

        <!-- TOTAL WITH DISCOUNT -->
        <v-list-item>
          <v-list-item-content>
            <v-list-item-title
              class="text-subtitle-1 text-decoration-line-through"
              >Total</v-list-item-title
            >
          </v-list-item-content>

          <v-list-item-action>
            <v-list-item-action-text
              class="
                text-subtitle-1
                font-weight-bold
                text-decoration-line-through
              "
            >
              {{ coursePrice | round(2) }} €
            </v-list-item-action-text>
          </v-list-item-action>
        </v-list-item>

        <v-divider></v-divider>

        <!-- PROMO DISCOUNT -->
        <v-list-item>
          <v-list-item-content>
            <v-list-item-title class="text-subtitle-1 success--text">
              Código descuento {{ promoData.discount | truncate }}
              {{ promoData.type | couponType }}
            </v-list-item-title>
          </v-list-item-content>

          <v-list-item-action>
            <v-list-item-action-text
              class="text-subtitle-1 font-weight-bold success--text"
            >
              - {{ promoAmount | round(2) }} €
            </v-list-item-action-text>
          </v-list-item-action>
        </v-list-item>

        <v-divider></v-divider>

        <!-- TOTAL-PRICE -->
        <v-list-item>
          <v-list-item-content>
            <v-list-item-title class="text-subtitle-1">Total</v-list-item-title>
          </v-list-item-content>

          <v-list-item-action>
            <v-list-item-action-text class="text-subtitle-1 font-weight-bold">
              {{ priceWithDiscountAndPromo | round(2) }} €
            </v-list-item-action-text>
          </v-list-item-action>
        </v-list-item>
      </template>

      <!-- IF NOT PROMO DATA -->
      <template v-else>
        <v-divider></v-divider>

        <!-- TOTAL -->
        <v-list-item>
          <v-list-item-content>
            <v-list-item-title class="text-subtitle-1">Total</v-list-item-title>
          </v-list-item-content>

          <v-list-item-action>
            <v-list-item-action-text class="text-subtitle-1 font-weight-bold">
              {{ coursePrice | round(2) }} €
            </v-list-item-action-text>
          </v-list-item-action>
        </v-list-item>
      </template>
    </v-list>
  </v-card>
</template>

<script>
import moment from "moment";

export default {
  props: {
    course: {
      type: Object,
      required: true,
      default: () => {},
    },

    planSelected: {
      type: Object,
      default: () => {},
    },

    promoData: {
      type: Object,
      default: undefined,
    },
  },

  computed: {
    coursePrice() {
      if (this.planSelected && this.planSelected.priceAmount) {
        return this.planSelected.priceAmount;
      } else {
        return this.course.price_total;
      }
    },

    discountAmount() {
      return this.coursePrice * (this.course.discount / 100);
    },

    priceWithDiscount() {
      return this.coursePrice - this.discountAmount;
    },

    priceWithDiscountAndPromo() {
      const promoAmount = this.promoAmount;
      return (this.priceWithDiscount - promoAmount).toFixed(2);
    },

    promoAmount() {
      const promoValue = this.promoData.discount;
      const promoType = this.promoData.type;
      const course = this.course;
      let price_total = 0;
      let price_discount_total = 0;

      if (course.discount)
        price_total =
          this.coursePrice - this.coursePrice * (course.discount / 100);
      else price_total = this.coursePrice;
      if (promoType === "percent") {
        price_discount_total = price_total * (promoValue / 100);
        return price_discount_total.toFixed(2);
      } else if (promoType === "fixed") {
        price_discount_total = promoValue;
        return price_discount_total.toFixed(2);
      } else if (promoType === "price") {
        price_discount_total = price_total - promoValue;
        return price_discount_total.toFixed(2);
      } else {
        return 0;
      }
    },
  },

  filters: {
    couponType(value) {
      switch (value) {
        case "percent":
          return "%";
        case "fixed":
        case "price":
          return "€";
        default:
          return "";
      }
    },

    dateFormated: (value) => moment(String(value)).format("DD-MM-YYYY HH:mm"),

    round(value, decimals) {
      let valueFloat = parseFloat(value);
      return valueFloat.toFixed(decimals);
    },

    truncate: (value) => Math.floor(value),
  },
};
</script>
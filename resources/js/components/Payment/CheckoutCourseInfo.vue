<template>
  <v-card outlined rounded>
    <v-list class="p-0">
      <!-- NAME -->
      <v-list-item>
        <v-list-item-content>
          <v-list-item-title class="text-body-2"
            >Nombre del curso</v-list-item-title
          >

          <v-list-item-subtitle
            class="text-caption text--secondary text-wrap"
            v-text="course.title"
          ></v-list-item-subtitle>
        </v-list-item-content>
      </v-list-item>

      <v-divider></v-divider>

      <!-- NUMBER OF SESSIONS -->
      <v-list-item>
        <v-list-item-content>
          <v-list-item-title class="text-body-2"
            >Nº de sesiones</v-list-item-title
          >

          <v-list-item-subtitle
            v-if="price_subscription"
            class="text-caption text--secondary"
          >
            4-{{
              Number.isNaN(course.duration)
                ? 32 / 8
                : (course.duration / 8) | round(0)
            }}
            mensuales
          </v-list-item-subtitle>

          <v-list-item-subtitle
            v-else
            class="text-caption text--secondary"
            v-text="course.duration"
          ></v-list-item-subtitle>
        </v-list-item-content>
      </v-list-item>

      <v-divider></v-divider>

      <!-- DURACTION -->
      <v-list-item>
        <v-list-item-content>
          <v-list-item-title class="text-body-2"
            >Duración clase</v-list-item-title
          >

          <v-list-item-subtitle
            class="text-caption text--secondary"
            v-text="course.sessionTime + ' minutos'"
          ></v-list-item-subtitle>
        </v-list-item-content>
      </v-list-item>

      <!-- IF PROMOTION -->
      <template v-if="promotion">
        <v-divider></v-divider>

        <!-- START DAY -->
        <v-list-item>
          <v-list-item-content>
            <v-list-item-title class="text-body-2"
              >Inicio del curso</v-list-item-title
            >

            <v-list-item-subtitle class="text-caption text--secondary">{{
              promotion.start_at | dateFormated
            }}</v-list-item-subtitle>
          </v-list-item-content>
        </v-list-item>
      </template>

      <template v-if="course.type_course === 0 || course.type_course === 2">
        <!-- SUBSCRIPTION PRICE -->
        <template v-if="price_subscription">
          <v-divider></v-divider>

          <v-list-item>
            <v-list-item-content>
              <v-list-item-title class="text-subtitle-1"
                >Curso</v-list-item-title
              >
            </v-list-item-content>

            <v-list-item-action>
              <v-list-item-action-text class="text-subtitle-1">
                {{ price_subscription.price_subscription | round(2) }} €
              </v-list-item-action-text>
            </v-list-item-action>
          </v-list-item>
        </template>

        <!-- ENROLLMENT PRICE -->
        <template v-if="price_enrollment">
          <v-divider></v-divider>

          <v-list-item>
            <v-list-item-content>
              <v-list-item-title class="text-subtitle-1"
                >Matrícula</v-list-item-title
              >
            </v-list-item-content>

            <v-list-item-action>
              <v-list-item-action-text class="text-subtitle-1">
                {{ price_enrollment.price_subscription | round(2) }} €
              </v-list-item-action-text>
            </v-list-item-action>
          </v-list-item>
        </template>

        <!-- IF COURSE DISCOUNT IS GREATER THAN 0 -->
        <template v-if="course.discount > 0">
          <v-divider></v-divider>

          <!-- SUB-TOTAL -->
          <v-list-item>
            <v-list-item-content>
              <v-list-item-title class="text-subtitle-1"
                >Sub-Total</v-list-item-title
              >
            </v-list-item-content>

            <v-list-item-action>
              <v-list-item-action-text class="text-subtitle-1 font-weight-bold">
                {{ course.price_total | round(2) }} €
              </v-list-item-action-text>
            </v-list-item-action>
          </v-list-item>

          <v-divider></v-divider>

          <!-- DISCOUNT -->
          <v-list-item>
            <v-list-item-content>
              <v-list-item-title class="text-subtitle-1 success--text"
                >Descuento {{ course.discount | truncate }}%</v-list-item-title
              >
            </v-list-item-content>

            <v-list-item-action>
              <v-list-item-action-text
                class="text-subtitle-1 font-weight-bold success--text"
              >
                -
                {{ discountAmount | round(2) }} €
              </v-list-item-action-text>
            </v-list-item-action>
          </v-list-item>

          <!-- IF PROMOTDATA -->
          <template v-if="promoData">
            <v-divider></v-divider>

            <!-- TOTAL -->
            <v-list-item>
              <v-list-item-content>
                <v-list-item-title
                  class="text-subtitle-1 text-decoration-line-through"
                  >Total</v-list-item-title
                >
              </v-list-item-content>

              <v-list-item-action>
                <v-list-item-action-text
                  class="text-subtitle-1 text-decoration-line-through"
                >
                  {{ priceWithDiscount | round(2) }} €
                </v-list-item-action-text>
              </v-list-item-action>
            </v-list-item>

            <v-divider></v-divider>

            <!-- PROMO DISCOUNT -->
            <v-list-item>
              <v-list-item-content>
                <v-list-item-title class="text-subtitle-1 success--text"
                  >Código descuento {{ promoData.discount | truncate }}
                  {{ promoData.type | couponType }}</v-list-item-title
                >
              </v-list-item-content>

              <v-list-item-action>
                <v-list-item-action-text class="text-subtitle-1 success--text">
                  - {{ promoAmount | round(2) }} €
                </v-list-item-action-text>
              </v-list-item-action>
            </v-list-item>

            <v-divider></v-divider>

            <!-- TOTAL-PRICE -->
            <v-list-item>
              <v-list-item-content>
                <v-list-item-title class="text-subtitle-1"
                  >Total</v-list-item-title
                >
              </v-list-item-content>

              <v-list-item-action>
                <v-list-item-action-text class="text-subtitle-1">
                  {{ priceWithDiscountAndPromo | round(2) }} €
                </v-list-item-action-text>
              </v-list-item-action>
            </v-list-item>
          </template>

          <template v-else>
            <v-divider></v-divider>

            <!-- TOTAL WITH DISCOUNT -->
            <v-list-item>
              <v-list-item-content>
                <v-list-item-title class="text-subtitle-1"
                  >Total</v-list-item-title
                >
              </v-list-item-content>

              <v-list-item-action>
                <v-list-item-action-text
                  class="text-subtitle-1 font-weight-bold"
                >
                  {{ priceWithDiscount | round(2) }} €
                </v-list-item-action-text>
              </v-list-item-action>
            </v-list-item>
          </template>
        </template>

        <!-- IF COURSE DISCOUNT IS NOT GREATER THAN 0 -->
        <template v-else>
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
                  {{ course.price_total | round(2) }} €
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
                <v-list-item-title class="text-subtitle-1"
                  >Total</v-list-item-title
                >
              </v-list-item-content>

              <v-list-item-action>
                <v-list-item-action-text
                  class="text-subtitle-1 font-weight-bold"
                >
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
                <v-list-item-title class="text-subtitle-1"
                  >Total</v-list-item-title
                >
              </v-list-item-content>

              <v-list-item-action>
                <v-list-item-action-text
                  class="text-subtitle-1 font-weight-bold"
                >
                  {{ course.price_total | round(2) }} €
                </v-list-item-action-text>
              </v-list-item-action>
            </v-list-item>
          </template>
        </template>
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

    price_enrollment: {
      type: Object,
      default: undefined,
    },

    price_subscription: {
      type: Object,
      default: undefined,
    },

    promoData: {
      type: Object,
      default: undefined,
    },

    promotion: {
      type: Object,
      default: undefined,
    },
  },

  computed: {
    discountAmount() {
      return this.course.price_total * (this.course.discount / 100);
    },

    priceWithDiscount() {
      return this.course.price_total - this.discountAmount;
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
          course.price_total - course.price_total * (course.discount / 100);
      else price_total = course.price_total;
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

<template>
  <v-card width="100%" class="elevation-8 mb-4 p-3">
    <div class="d-flex justify-space-between align-items-end">
      <v-row>
        <v-col cols="6" md="3">
          <div class="text--secondary text-body-2">Inicio</div>
          <div class="font-weight-medium text-body-2">
            {{ promotion.start_at | formatted("yyyy-MM-dd") }}
          </div>
        </v-col>
        <v-col cols="6" md="3">
          <div class="text--secondary text-body-2">Fin</div>
          <div class="font-weight-medium text-body-2">
            {{ promotion.end_at | formatted("yyyy-MM-dd") }}
          </div>
        </v-col>
        <v-col cols="6" md="3">
          <div class="text--secondary text-body-2">Día</div>
          <div class="font-weight-medium text-body-2">
            {{ promotion.daily | weekly }}
          </div>
        </v-col>
        <v-col cols="6" md="3">
          <div class="text--secondary text-body-2">Hora</div>
          <div class="font-weight-medium text-body-2">
            {{ promotion.start_at | formatted("HH:ii") }}
          </div>
        </v-col>
      </v-row>

      <div>
        <v-btn
          :href="courseStoreUrlCheckout(promotion.id)"
          color="accent"
          outlined
          >Reservar</v-btn
        >
      </div>
    </div>
    <div
      v-if="
        !courseStoreIsTrajectory &&
        courseStoreCourse.students_max - promotion.promotion_purchases.length <=
          1
      "
      class="text-body-2 primary--text"
    >
      Solo quedan
      <span class="font-weight-medium">
        {{
          courseStoreCourse.students_max - promotion.promotion_purchases.length
        }}
        espacios
      </span>
    </div>
  </v-card>
</template>

<script>
import { mapState } from "pinia";
import { useCourseStore } from "../../store/course";

export default {
  props: {
    promotion: {
      type: Object,
      required: true,
      default: () => {},
    },
  },

  computed: {
    ...mapState(useCourseStore, {
      courseStoreCourse: "course",
      courseStoreUrlCheckout: "urlCheckout",
      courseStoreIsTrajectory: "isTrajectory",
    }),
  },

  filters: {
    formatted(date, format) {
      if (date) {
        let formatDate = new Date(date.replace(/-/g, "/"));
        if (format === "yyyy-MM-dd") {
          let month = formatDate.getMonth() + 1;
          if (month < 10) month = "0" + month;
          let day = formatDate.getDate();
          if (day < 10) day = "0" + day;
          return day + "-" + month + "-" + formatDate.getFullYear();
          //return date.substr(0, 10)
        }
        if (format === "HH:ii") return date.substr(11, 5);
        //return formatDate.getHours()+':'+ formatDate.getMinutes()
      }
      return date;
    },

    weekly(daily) {
      let string;
      daily && Array.isArray(daily)
        ? (string = "Lunes")
        : daily
        ? (string = JSON.parse(daily)
            .map(function (value) {
              switch (value) {
                case "0":
                  return "Lunes";
                case "1":
                  return "Martes";
                case "2":
                  return "Miercoles";
                case "3":
                  return "Jueves";
                case "4":
                  return "Viernes";
                case "5":
                  return "Sábado";
                case "6":
                  return "Domingo";
                default:
                  return "Lunes";
              }
            })
            .join("/ "))
        : "Lunes";
      return string;
    },
  },
};
</script>
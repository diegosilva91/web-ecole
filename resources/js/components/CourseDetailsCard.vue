<template>
  <div class="card-course-details elevation-8 p-5 pt-6">
    <div v-if="!trajectory" class="row align-items-end">
      <div class="col-6 price-hour text-dark pb-0">
        {{ course.price_per_hour }}€ / h
      </div>
      <div class="col-6 pb-1 pl-0">
        <span v-show="course.discount > '0.00'" class="course-price"
          >{{ course.discount | truncate }}% Dto.<span class="dto"
            >{{ course.price_total }}€</span
          ></span
        >
        <div class="total-price d-flex">
          Total:
          {{
            (course.price_total - (course.price_total * course.discount) / 100)
              | round(0)
          }}€
        </div>
      </div>
    </div>

    <button
      v-if="!trajectory"
      @click="paymentAction"
      data-toggle="modal"
      :data-target="dataTarget"
      class="btn-buy v-btn v-size--default theme--light mb-7"
      style="width: 230px !important"
    >
      <img src="/assets/images/home_vector/carrito.svg" alt="" />
      <span class="btn-price text-capitalize ml-4">{{
        trajectory ? "Suscribirme" : "Comprar"
      }}</span>
    </button>
    <div class="p2-txt text-secondary">
      <div class="mb-5">
        <img
          class="mr-2"
          width="12px"
          height="16px"
          src="/assets/images/course/icons/group-2.svg"
          alt=""
        />Edad: {{ course.student_ages_min }}-{{ course.student_ages_max }} años
      </div>
      <v-tooltip max-width="230px" color="#ffffff" bottom>
        <template v-slot:activator="{ on, attrs }">
          <div class="mb-5">
            <img
              class="mr-2"
              width="13px"
              height="16px"
              src="/assets/images/course/icons/user.svg"
              alt=""
            />Tamaño grupo: {{ course.students_min }}-{{ course.students_max }}
            <img
              v-bind="attrs"
              v-on="on"
              class="ml-2"
              width="18px"
              height="18px"
              src="/assets/images/course/icons/group-6.svg"
              alt=""
            />
          </div>
        </template>
        <span
          style="
            box-shadow: 0 5px 10px 0 rgba(74, 64, 87, 0.2);
            border: solid 1px rgba(193, 199, 211, 0.3);
            border-radius: 10px;
            width: 250px;
          "
          class="h8-txt-light text-dark p-2"
          >Para poder llevarse a cabo el curso, se tendrán que cubrir las plazas
          mínimas requeridas. <br /><strong
            >¡Comparte el curso con tus amig@s!</strong
          ></span
        >
      </v-tooltip>
      <div v-if="!trajectory" class="mb-5">
        <img
          class="mr-2"
          width="16px"
          height="16px"
          src="/assets/images/course/icons/group-3.svg"
          alt=""
        />Duración <span v-show="!trajectory">clase</span>:
        {{ course.sessionTime }} min
      </div>
      <div v-else class="mb-5">
        <img
          class="mr-2"
          width="16px"
          height="16px"
          src="/assets/images/course/icons/group-3.svg"
          alt=""
        />Duración: hasta {{ promotion.end_at | formatted("M") }}
      </div>
      <div v-show="!trajectory" class="mb-5">
        <img
          class="mr-2"
          width="14px"
          height="16px"
          src="/assets/images/course/icons/shape.svg"
          alt=""
        />Sesiones: {{ course.duration }}
      </div>
      <div v-show="!trajectory" class="mb-5">
        <img
          class="mr-2"
          width="16px"
          height="18px"
          src="/assets/images/course/icons/group-4.svg"
          alt=""
        />Días: {{ daily }}
      </div>
      <div v-show="trajectory" class="mb-5">
        <img
          class="mr-2"
          width="16px"
          height="18px"
          src="/assets/images/course/icons/group-4.svg"
          alt=""
        />Frecuencia: {{ session }}día/ semana <br />
        <span class="ml-7">({{ course.sessionTime }} mins)</span>
      </div>
      <template v-if="course.prices_enrollment">
        <div
          v-if="course.prices_enrollment > 0"
          v-show="trajectory"
          class="mb-5"
        >
          <img
            class="mr-2"
            width="14px"
            height="16px"
            src="/assets/images/course/icons/shape.svg"
            alt=""
          />Matrícula: {{ course.prices_enrollment.total_price }}
        </div>
      </template>
      <div v-show="!trajectory" class="mb-5">
        <img
          class="mr-2"
          width="16px"
          height="16px"
          src="/assets/images/course/icons/group-5.svg"
          alt=""
        />Nivel:
        {{ course.level }}
      </div>
      <div v-show="trajectory" class="mb-5">
        <img
          class="mr-2"
          width="16px"
          height="16px"
          src="/assets/images/course/icons/group-5.svg"
          alt=""
        />Consta de {{ course.total_level }} niveles
      </div>
      <ModalSession v-show="trajectory" :title="course.title" />
    </div>
  </div>
</template>

<script>
import ModalSession from "./Trajectories/ModalSession.vue";

export default {
  components: {
    ModalSession,
  },
  props: [
    "course",
    "promotion",
    "login",
    "category",
    "trajectory",
    "session",
    "last_promotion",
  ],
  mounted: function () {
    this.dataTarget = this.login ? "" : "#RegisterPayment";
    this.daily = "Varios";
    if (this.trajectory === 1) {
      this.redirectCheckout = `/es/cursos-anuales/payment/${this.course.id}`;
    } else {
      this.redirectCheckout = `/es/payment/${this.course.id}`;
    }
  },
  data() {
    return {
      daily: "",
      redirectCheckout: `/es/payment/${this.course.id}`,
      dataTarget: "#RegisterPayment",
      errorEmail: false,
    };
  },
  filters: {
    truncate(value) {
      return Math.floor(value);
    },
    round(value, decimals) {
      let valueFloat = parseFloat(value);
      return valueFloat.toFixed(decimals);
    },
    formatted(date, format) {
      if (date) {
        if (!(date instanceof Date)) {
          date = new Date(date.replace(/-/g, "/"));
        }
        if (format === "M") {
          return date.toLocaleString("es", { month: "long" });
        }
      }
      return date;
    },
  },
  methods: {
    paymentAction() {
      /*@isset($course->discount)
                                'price': '@json($course->price_total- ($course->price_total*((int)$course->discount/100)))',
                                @else
                                'price': '@json($course->price_total)',
                                @endisset*/
      if (this.login) {
        if (this.course && this.category) {
          let price_total = this.course.price_total;
          if (this.course.discount)
            price_total =
              price_total - (price_total * this.course.discount) / 100;
          this.$gtm.push({
            event: "addToCart",
            ecommerce: {
              currencyCode: "EUR",
              add: {
                products: [
                  {
                    name: this.course.title,
                    id: this.course.id,
                    brand: this.course.subtype_course,
                    category: this.category.title,
                    price: price_total,
                    quantity: 1,
                  },
                ],
              },
            },
          });
        }

        window.location.href = this.redirectCheckout;
      }
    },

    dailies: (daily) => {
      let dail = [""];
      dail = daily
        ? Array.isArray(daily)
          ? daily
          : [JSON.parse(daily)]
        : [""];
      console.log(dail);
      return dail.map(function (value) {
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
          default:
            return "Lunes";
        }
      });
    },
  },
};
</script>

<style scoped>
.price-hour {
  font-family: "Open Sans", sans-serif;
  font-size: 30px;
  font-weight: 600;
}

.session-info {
  font-family: "Open Sans", sans-serif;
  font-size: 16px;
  font-weight: 600;
  color: #29c0d3 !important;
  text-decoration: underline !important;
  cursor: pointer;
}

.card-course-details {
  border-radius: 12px;
  border: solid 1px rgba(193, 199, 211, 0.3);
  background-color: #ffffff;

height: auto;
position: relative;
top: 0;
left: 0;
right: 0;
width: 100%;
}

.title-modal {
  font-family: "Poppins", sans-serif;
  font-size: 16px;
  font-weight: 500;
  color: #5c2767;
}

.input-landing {
  width: 100%;
  height: 40px;
}

.link-text {
  color: #29c0d3;
}

.checked-txt {
  font-family: "Poppins", sans-serif;
  font-size: 16px;
  font-weight: 500;
  color: #343a40;
  margin-left: 10px;
}
</style>

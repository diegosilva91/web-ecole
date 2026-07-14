import { defineStore } from "pinia";

export const useCourseStore = defineStore("course", {
  state: () => {
    return {
      addToFavoriteRequestedWithoutLogged: false,
      category: undefined,
      course: undefined,
      planBasic: {
        id: 1,
        description: "Trayectoria",
        extraInfo: "*Solamente se requerirá un preaviso de 15 días antes de tu siguiente cuota  - que se cargará a finales de mes",
        featuresList: [
            { text: "Educación extraescolar entre Septiembre y Junio" },
            { text: "Acceso a una trayectoria extraescolar" },
            { text: "Posibilidad de empezar en cualquier mes del año (entre Septiembre y Junio)" },
            { text: "Paga cada mes, a partir del mes que tu hij@ empiece las extraescolares" },
            { text: "Cancela cuando quieras, sin compromiso*" },
        ],
        longDescription: `
          Plan de hasta 10 meses de tu trayectoria educativa hasta finales de junio, por 65€/mes.
        `,
        name: "Plan Básico",
        priceAmount: 0,
        priceId: 0,
        priceFraction: 'mes',
      },
      planLifecooler: {
        id: 2,
        description: "Trayectoria + 2 campus",
        extraInfo: "*Solamente se requerirá un preaviso de 15 días antes de tu siguiente cuota  - que se cargará a finales de mes",
        featuresList: [
            { text: "Educación extraescolar durante todo el año" },
            { text: "Acceso a una trayectoria extraescolar. <strong>¡Ahorra hasta 100€ al año!</strong>" },
            { text: "Acceso a dos campus mensuales. ¡Ahorra <strong>40€ al año!</strong>" },
            { text: "Posibilidad de empezar en cualquier mes del año " },
            { text: "Paga cada mes, a partir del mes que tu hij@ empiece las extraescolares" },
            { text: "Cancela cuando quieras, sin compromiso*" },
        ],
        longDescription: `
          Plan anual de tu trayectoria educativa durante el curso escolar + dos campus a escoger en Navidad, Semana Santa o Verano, por 55€/mes.
        `,
        name: "Plan Smart",
        priceAmount: 0,
        priceId: 0,
        priceFraction: 'mes',
      },
      planSelected: undefined,
      toggleFavoriteIsLoading: false
    };
  },

  getters: {
    /**
     * Check if the course is a trajectory
     *
     * @returns {boolean} True if the course is a trajectory, false if it is not
     */
    isTrajectory: state => state.course.type_course === 1,

    plansArray: state => [state.planBasic, state.planLifecooler],

    /**
     * Returns course checkout url according course, pack and promotion
     *
     * @param {number} [promotionId = ""] - Promotion id
     * @returns {string}
     */
    urlCheckout() {
      return (promotionId = "") => {
        if (!this.course) return;

        let mainPath;
        let packPath;
        const coursePath = this.course.id + "/";

        if (this.isTrajectory) {
          mainPath = "/es/cursos-anuales/payment/";
          packPath = this.planSelected ? this.planSelected.id + "/" : "0/";
        } else {
          mainPath = "/es/payment/";
          packPath = '';
        }

        return mainPath + coursePath + packPath + promotionId;
      };
    }
  },

  actions: {
    async addFavorite() {
      this.toggleFavoriteIsLoading = true;
      return await axios
        .post(`/api/favorite/${this.course.id}`)
        .then(_res => (this.toggleFavoriteIsLoading = false))
        .catch(err => err);
    },

    async deleteFavorite() {
      this.toggleFavoriteIsLoading = true;
      return await axios
        .delete(`/api/favorite/${this.course.id}`)
        .then(_res => (this.toggleFavoriteIsLoading = false))
        .catch(err => err);
    },

    async gtmSendAddToCart(gtm) {
      if (!this.course || !this.category) return;

      return new Promise((resolve, _reject) => {
        let price_total = this.course.price_total;
        if (this.course.discount)
          price_total =
            price_total - (price_total * this.course.discount) / 100;

        gtm.push({
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
                  quantity: 1
                }
              ]
            }
          },
          eventCallback: function() {
            resolve();
          }
        });
      });
    },

    async onSubscribeClick(gtm) {
      await this.gtmSendAddToCart(gtm);
      window.location.pathname = this.urlCheckout();
    },

    selectePlan(planId) {
      this.planSelected = this.plansArray.find((plan) => plan.id === planId)
    }
  }
});

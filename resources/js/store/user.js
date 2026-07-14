import { defineStore } from "pinia";
import { useCourseStore } from "./course";

export const useUserStore = defineStore("user", {
  state: () => {
    return {
      user: undefined,
    };
  },

  actions: {
    async eventLoggedInSuccessful() {
      const courseStore = useCourseStore();
      if (courseStore.addToFavoriteRequestedWithoutLogged) {
        return courseStore.addFavorite();
      }
    }
  }
});

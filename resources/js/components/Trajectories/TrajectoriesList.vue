<template>
  <div
    v-if="!isLoading || isMobile === true"
    :class="hiddentitle ? '' : 'mb-100'"
    class="mt-1"
  >
    <div v-if="courses.length > 0" class="trajectories-wrapper">
      <div v-show="loadPagination" class="row">
        <div v-for="course in courses" :key="course.id" class="col-sm-6 col-12">
          <CardTrajectory
            :title="course.title"
            :ageMax="course.student_ages_max"
            :category="course.categoryName"
            :imgMobile="
              course.cover_image_mobile ? url + course.cover_image_mobile : null
            "
            :ageMin="course.student_ages_min"
            :img="url + course.cover_image"
            :studentsMin="course.students_min"
            :studentsMax="course.students_max"
            :url="course.newLink"
            :price="course.price_total"
            :priceEnrollment="course.price_enrollment"
            :startAt="course.start_at"
            :endAt="course.end_at"
            :discount="course.discount"
            :duration="course.duration"
            :sessions="course.session"
            :sessionTime="course.sessionTime"
          ></CardTrajectory>
        </div>
      </div>
      <div v-show="!loadPagination" class="row list-loading-inside mt-100">
        <v-progress-circular indeterminate color="#5c2767" class="mx-auto">
        </v-progress-circular>
      </div>
      <div v-show="morebtn" class="row">
        <a
          class="mr-lg-4 ml-mob-30 ml-tb-15 ml-lg-auto"
          href="/es/cursos-anuales"
        >
          <button class="btn-booking">
            <span class="btn-price blue-title">Ver más</span>
          </button>
        </a>
      </div>
      <template v-if="paginated === true">
        <div
          v-if="pagination.total > 1"
          class="
            trajectories-pagination
            col
            align-self-end
            d-flex
            justify-content-end
          "
        >
          <v-pagination
            color="#29c0d3"
            v-model="pagination.current"
            :length="pagination.total"
            total-visible="4"
            @input="onPageChange"
          ></v-pagination>
        </div>
      </template>
      <template v-else-if="infiniteScroll === true">
        <infinite-loading @infinite="infiniteHandler">
          <div class="row mt-100" slot="spinner">
            <v-progress-circular indeterminate color="#5c2767" class="mx-auto">
            </v-progress-circular>
          </div>
          <div slot="no-more"></div>
          <div slot="no-results"></div>
        </infinite-loading>
      </template>
    </div>
    <template v-else-if="loading === true && noResults === false">
      <div class="row mt-100 list-loading-2" slot="spinner">
        <v-progress-circular indeterminate color="#5c2767" class="mx-auto">
        </v-progress-circular>
      </div>
    </template>
    <div class="col-12 mt-50" v-else-if="!isLoading">
      <img
        src="/assets/images/filters/error-busqueda.svg"
        alt=""
        class="row mx-auto"
      />
    </div>
  </div>
  <div v-else class="mb-100">
    <div class="row mt-100 list-loading-1" slot="spinner">
      <v-progress-circular indeterminate color="#5c2767" class="mx-auto">
      </v-progress-circular>
    </div>
  </div>
</template>

<script>
import InfiniteLoading from "vue-infinite-loading";
import CardTrajectory from "./CardTrajectory.vue";

export default {
  props: [
    "coursesData",
    "filter",
    "hiddenfilter",
    "hiddentitle",
    "infiniteScroll",
    "IsActiveQuerySearch",
    "isMobile",
    "isLoading",
    "limit",
    "loadingFather",
    "morebtn",
    "page",
    "paginated",
    "queryFeatured",
    "url",
  ],
  components: {
    InfiniteLoading,
    CardTrajectory,
  },
  data: () => ({
    courses: [],
    loading: false,
    pagination: {
      current: 1,
      total: 0,
    },
    info: true,
    noResults: false,
    loadPagination: true,
  }),
  async mounted() {
    console.log(
      "paginated=" + this.paginated,
      "scroll=" + this.infiniteScroll,
      this.courses,
      this.hiddentitle,
      this.hiddenfilter,
      this.morebtn,
      this.page
    );
  },
  watch: {
    courses: function (value) {
      if (
        this.infiniteScroll === true &&
        this.paginated !== true &&
        this.pagination.current === 1 &&
        this.isMobile === true &&
        this.loadingFather
      ) {
        if (value.length === 0) {
          this.loading = false;
        }
      }
    },
    loadingFather: function (value) {
      this.loading = value;
      if (value === true) {
        this.noResults = false;
      }
    },
    pagination: function (value, old) {
      if ("current" in value && "current" in old && this.paginated === true) {
        if (value.current !== value.current) {
          this.loading = true;
        }
      }
    },
    page: function (value) {
      console.log("page", value);
      if ("total" in value) {
        this.pagination.total = this.page.total;
      }
      if ("current" in value) {
        this.pagination.current = this.page.current;
      }
    },
    coursesData: function (value, old) {
      this.loadPagination = true;
      if (typeof value === "object") {
        if (value.data) {
          this.courses = value.data;
          if (this.paginated === true && value.last_page) {
            this.pagination.total = value.last_page;
          }
          if (value.current_page) {
            this.pagination.current = value.current_page;
          }
          if (value.data.length >= 0) {
            this.loading = true;
          }
          this.noResults = false;
          if ("length" in old && "length" in value.data) {
            if (old.length >= 0 && value.data.length === 0) {
              this.noResults = true;
            }
          }
        } else {
          if (this.infiniteScroll === true) {
            if (value.length > 0) {
              this.courses.push(...value);
            } else {
              this.courses = [];
            }
            this.loading = true;
            this.noResults = false;
          } else {
            //tags
            this.courses = value;
            this.loading = true;
            this.noResults = false;
            if ("length" in old && "length" in value) {
              if (old.length >= 0 && value.length === 0) {
                // this.loading = false;
                this.noResults = true;
              }
            }
            if ("data" in old && "length" in value) {
              if (old.data.length > 0 && value.length === 0) {
                // this.loading = false;v
                this.noResults = true;
              }
            }
          }
          console.log(this.page, this.loading);
          if (this.page && "total" in this.page) {
            this.pagination.total = this.page.total;
          }
          if (this.page && "current" in this.page) {
            this.pagination.current = this.page.current;
          }
          if (value.length >= 0 && this.page === undefined) {
            this.loading = true;
          }
        }
      }
    },
  },
  methods: {
    onPageChange() {
      let vm = this;
      vm.loadPagination = false;
      this.$emit("onPageChange", vm.pagination);
    },
    async infiniteHandler($state) {
      let vm = this;
      vm.pagination.current = vm.pagination.current + 1;
      this.$emit("onScrollInfiniteChange", $state, vm.pagination);
    },
  },
  filters: {
    parametrized(value) {
      if (value === null) return "";
      else return value;
    },
  },
};
</script>

<style scoped>
.trajectories-wrapper {
  margin-bottom: 100px;
}

.trajectories-pagination {
  margin-bottom: 127px;
}

@media (min-width: 1800px) {
  .container {
    max-width: 1185px !important;
  }
}
</style>

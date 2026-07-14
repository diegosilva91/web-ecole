<template>
<div>
  <div class="d-none d-lg-block">
      <PromotionsTable />
  </div>
  <div class="d-block d-lg-none">
      <PromotionsMobile />
  </div>
    <infinite-loading @infinite="infiniteHandler">
        <div class="row" slot="spinner">
            <v-progress-circular
                indeterminate
                color="#5c2767"
                class="mx-auto">
            </v-progress-circular>
        </div>
        <div slot="no-more"></div>
        <div slot="no-results"></div>
    </infinite-loading>
</div>
</template>

<script>
import InfiniteLoading from 'vue-infinite-loading';
import PromotionsTable from './PromotionsTable'
import PromotionsMobile from './PromotionsMobile'
import {GetObject, UpdateObject} from "../../axios-services";
import Event from "../../event";
export default {
    components:{
        PromotionsTable,
        PromotionsMobile,
        InfiniteLoading
    },
    data:()=>({
        page: 1,
        promotions:[],
        query:'',
    }),
    mounted() {
        //console.log(this.courses);
        Event.$on('filter-promotions',(query)=>{
            this.query = query
            this.page=1
            this.getData(this.query)
        })
    },
    methods:{
        infiniteHandler($state) {
            GetObject(`promotions?include=promotionPurchases,courses,usersPromotionPurchases&active_promotions=false&filter[user.id]=${this.$route.params.id}&page=${this.page}${this.query}`, (error, data) => {
                    if (data.promotions.data.length > 0) {
                        this.page += 1;
                        data.promotions.data = data.promotions.data ? data.promotions.data.map((courses) => {
                                if (courses.start_at) {
                                    courses.start_at = new Date(courses.start_at.replace(/-/g, "/"))
                                    courses.date = courses.time = courses.start_at
                                    courses.students = courses.courses.students_max !== null && courses.students_total !== null ? `${courses.students_total}/${courses.courses.students_max}` : `0 / 0`
                                }
                                return courses;
                            })
                            : []
                        this.promotions.push(...data.promotions.data);
                        Event.$emit('data-promotions', this.promotions)
                        $state.loaded()
                    }
                else {
                    console.log(error)
                    $state.complete();
                }
            })
        },
        getData: function (query){
            this.loading=false
            // ${query}
            GetObject(`promotions?include=promotionPurchases,courses,usersPromotionPurchases&active_promotions=false&filter[user.id]=${this.$route.params.id}&page=${this.page}${query}`, (error, data) => {
                if(error){
                    data.data.coures=''
                    this.loading=true
                }
                else{
                    this.page += 1;
                    data.promotions.data = data.promotions.data ? data.promotions.data.map((courses) => {
                            if (courses.start_at) {
                                courses.start_at = new Date(courses.start_at.replace(/-/g, "/"))
                                courses.date = courses.time = courses.start_at
                                courses.students = courses.courses.students_max !== null && courses.students_total!== null ? `${courses.students_total}/${courses.courses.students_max}` : `0 / 0`
                            }
                            return courses;
                        })
                        : []
                    this.promotions= data.promotions.data
                    Event.$emit('data-promotions',this.promotions)
                }
            });
        },
    },

}
</script>

<style>

</style>

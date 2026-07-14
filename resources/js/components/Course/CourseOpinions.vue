<template>
<div v-if="isLoaded" class="col-12 col-md-12 col-lg-8 text-dark">
    <h2 class="h2-txt mb-8 mt-lg-40">Opiniones</h2>
    <div class="mb-12" v-for="review in courseReviews" :key="review.id">
        <div class="d-flex" v-if="review.opinion!=='' && review.opinion">
            <div>
                <v-avatar size="60">
                    <img class="mx-auto" :src="url+review.user.avatar" alt="">
                </v-avatar>
            </div>
            <div class="my-auto ml-3">
                <h3 class="h6-txt sb mb-1">{{review.user.name}}</h3>
                <h4 class="h7-txt text-secondary">{{review.created_at| formatDate('MM-yyyy')}}</h4>
            </div>
        </div>
        <div v-if="!readMore[review.id] && review.opinion" class="h6-txt text-justify mt-2">{{review.opinion | truncate(150, '...')}}</div>
        <div v-if="readMore[review.id]" class="h6-txt text-justify mt-2">{{review.opinion}}</div>
        <!--<button :id="review.id" @click="viewMore()" class="h6-txt btn-more mb-12">{{btnText}}</button>-->
        <div v-if="review.opinion">
        <button @click="showMore(review.id)" v-if="!readMore[review.id] && review.opinion.length>100" class="h6-txt sb btn-more">Mostrar más</button>
        <button @click="showLess(review.id)" v-if="readMore[review.id]" class="h6-txt sb btn-more">Mostrar menos</button>
        </div>
    </div>
    <div v-if="pagination.total > 1">
        <v-pagination
            color="#29c0d3"
            v-model="pagination.current"
            :length="pagination.total"
            @input="onPageChange"
        ></v-pagination>
    </div>
</div>
    <div v-else class="col-12 col-md-12 col-lg-8 text-dark">
        <v-progress-circular
            :size="70"
            :width="7"
            color="purple"
            indeterminate
        ></v-progress-circular>
    </div>
</template>

<script>
import {GetObject} from '../../axios-services'

export default {
    props:{
        course_id:{
            type:Number,
            default:0
        }
    },
    mounted(){
        this.getOpinions()
    },
    data() {
        return{
            readMore: {},
            btnText:'Leer más',
            isLoaded:false,
            pagination:{
                current:1,
                total:0
            },
            url:'',
            courseReviews:[],
        }
    },
    methods:{
        showMore(id) {
            this.$set(this.readMore, id, true);
        },
        showLess(id) {
            this.$set(this.readMore, id, false);
        },
        viewMore(){
            if(this.btnText==='Leer más'){
                this.btnText='Leer menos'
            }else{
                this.btnText='Leer más'
            }
        },
        onPageChange(){
            this.getOpinions()
        },
        getOpinions(){
            GetObject(`reviews?include=course,user&filter[course_id]=${this.course_id}&page=${this.pagination.current}&sort=-created_at`,(error,data)=>{
                this.isLoaded=true
                if(error) {
                    this.pagination = {
                        current: 1,
                        total: 0
                    }
                    this.page = 1
                }
                else{
                    this.url=data.url
                    this.courseReviews=data.courseReviews.data
                    this.pagination.current=data.courseReviews.current_page
                    this.pagination.total= data.courseReviews.last_page
                }
            })
        }
    },
    filters:{
        truncate: function(text, length, suffix){
            if (text.length > length) {
                return text.substring(0, length) + suffix;
            } else {
                return text;
            }
        },
        formatDate(date,format){
            //let formatDate= new Date(date.replace(/-/g, "/"))
            let formatDate=  new Date(date)
            if (format==='MM-yyyy'){
                let month= (formatDate.toLocaleString('default', { month: 'long' })).replace(/^\w/, (c) => c.toUpperCase());
                return month + ' '+formatDate.getFullYear()
            }
            return date;
        }
    },
}
</script>

<style scoped>
    .btn-more {
        color: #29c0d3;
        text-decoration-line: underline;
    }

    .h6-txt.sb{
        font-weight: 600;
    }
</style>

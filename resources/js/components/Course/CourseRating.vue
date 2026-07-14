<template>
<div class="d-flex" v-if="score!=='0.00' && valorations!==0">
    <h4 class="mr-1">{{ score | formatDouble}}</h4>
    <v-rating
        v-model="score"
        dense
        color="#793e87"
        background-color="#793e87"
        :length="length"
        :size="size"
        :half-increments="halfIncrements"
        :readonly="readonly"
        :empty-icon="emptyIcon"
        :full-icon="fullIcon"
        :half-icon="halfIcon"
    ></v-rating>
    <span :class="{'d-none':hiddenReviews}" class="reviews-total">({{ valorations }})</span>
</div>
</template>

<script>
export default {
    props:['score','valorations', 'hiddenReviews'],
    data: () => ({
        rating: 4.5,
        reviews: 32,
        length: 5,
        halfIncrements: true,
        size: 22,
        readonly: true,
        emptyIcon: 'mdi-star-outline',
        fullIcon: 'mdi-star',
        halfIcon: 'mdi-star-half',
    }),
    mounted(){
        this.rating=parseFloat(this.score)
    },
    filters:{
        formatDouble(value){
            if(value- Math.floor(value)!==0){
                return parseFloat(value).toFixed(1)
            }
            else{
                return parseFloat(value).toFixed(0)
            }
        }
    }
}
</script>

<style scoped>
.reviews-total{
    font-family: 'Poppins', sans-serif;
    font-weight: 300;
    font-size: 16px;
    color: #6c757d;
    margin-left: 4px;
}
</style>

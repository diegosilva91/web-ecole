<template>
<div class="col-12 text-dark pl-0" v-if="course.rating1!=='0.00' && course.rating2!=='0.00' && course.rating3!=='0.00' && course.rating4 !=='0.00'">
    <div class="row">
        <h5 class="col-4">Contenido</h5>
        <h4 class="col-6 text-center my-auto"><v-progress-linear height="7" color="#343a40" rounded :value="course.rating1| floatPercent"></v-progress-linear></h4>
        <span class="col-2">{{course.rating1}}</span>
    </div>
    <div class="row">
        <h5 class="col-4">Comunicación</h5>
        <h4 class="col-6 text-center my-auto"><v-progress-linear height="7" color="#343a40" rounded :value="course.rating2| floatPercent"></v-progress-linear></h4>
        <span class="col-2">{{course.rating2}}</span>
    </div>
    <div class="row">
        <h5 class="col-4">Flexibilidad</h5>
        <h4 class="col-6 text-center my-auto"><v-progress-linear height="7" color="#343a40" rounded :value="course.rating3 | floatPercent"></v-progress-linear></h4>
        <span class="col-2">{{course.rating3}}</span>
    </div>
    <div class="row">
        <h5 class="col-4">Organización</h5>
        <h4 class="col-6 text-center my-auto"><v-progress-linear height="7" color="#343a40" rounded :value="course.rating4 | floatPercent"></v-progress-linear></h4>
        <span class="col-2">{{course.rating4}}</span>
    </div>
</div>

</template>

<script>
export default {
    props:['course'],
    filters:{
        floatPercent(value){
            let percent=parseFloat(value)*100/5
            return percent;
        }
    }
}
</script>

<style scoped>
    h4 {
        font-weight: 500;
    }

    h5 {
        font-family: 'Open Sans';
        font-size: 16px;
    }

    span {
        font-family: 'Open Sans';
        font-size: 14px;
        font-weight: 700;
    }
</style>

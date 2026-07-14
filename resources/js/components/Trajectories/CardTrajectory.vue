<template>
    <a :href="url">
    <div class="single_courses mt-3 mb-30"> 
        <!-- Tag BlackFriday -->
        <!-- <div>
            <img class="posit-tag-bf" src="/assets/images/promos/bf_tag.png" alt="">
        </div> -->

        <!-- Tag CyberMonday -->
        <!-- <div>
            <img class="posit-tag-cm" src="/assets/images/promos/cm_tag.png" alt="">
        </div> -->
        <div v-if="imgMobile" class="courses_image">
            <img v-lazysizes :data-src="imgMobile" alt=""/>
        </div>
        <div v-else class="courses_image">
            <img v-lazysizes :data-src="img" alt=""/>
        </div>
        <div class="courses_content pl-mob-0 pr-mob-0">
            <div class="card-trajectory-header">
                <div class="trajectory-category mt-2">{{ category }}</div>
                <!-- <a class="text-dark" :href=url>{{title | truncate(45, '...') }}</a></h3> -->
                <h3 class="course-title mt-4 mb-2 h-48" style="line-height: 1.5 !important;">
                    {{ title }}</h3>
                <div v-if="valorations && rating" class="d-inline">
                    <img width="14px" height="14px" class="d-inline" src="/assets/images/course/icons/star.svg" alt=""
                         style="vertical-align: unset;">
                    <div class="d-inline purple-title h7-txt-sbold">{{ rating|formatDouble }}<span
                            class="number-reviews ml-2">({{ valorations }})</span></div>
                </div>
            </div>
            <div class="card-details">
                <div><strong>Edad:</strong> {{ ageMin }}-{{ ageMax }} años</div>
                <!-- <div v-if="priceEnrollment>0"><strong>Matrícula:</strong> {{priceEnrollment}}€ (un único pago)</div> -->
                <div><strong>Matrícula: </strong><span class="pop16-purple">GRATIS</span> (antes <span class="promo-red">40€</span>)</div>
                <div><strong>Duración:</strong> {{startAt|formatted('M')}} - {{endAt|formatted('M')}}</div>
                <div><strong>Frecuencia:</strong> {{ sessions }} día a la semana ({{ sessionTime }}min)</div>
                <div><strong>Tamaño del grupo:</strong> {{studentsMin}}-{{studentsMax}} alumnos</div>
            </div>

            <div class="text-center">
                <a v-if="url" :href="url" class="v-btn v-size--default theme--light mt-30 mb-25 w-100" style="background-color:#29c0d3;height: 40px;max-width: 165px;border-radius: 8px;
                            box-shadow: 0 2px 8px 0 rgba(35, 158, 173, 0.5);"><span
                        class="btn-price text-lowercase text-center">{{ price }}€/mes</span></a>
            </div>
        </div>
    </div>
    </a>
</template>

<script>
import 'lazysizes/plugins/parent-fit/ls.parent-fit';
import vueLazysizes from 'vue-lazysizes';
import VLazyImage from "v-lazy-image";

export default {
// name: "CourseCardNew",
    directives: {
        lazysizes: vueLazysizes
    },
    components: {
        VLazyImage
    },
    props: ['title', 'url', 'img', 'imgMobile', 'ageMin', 'ageMax','studentsMax','studentsMin', 'startAt','endAt', 'discount', 'price', 'priceEnrollment','duration', 'sessions', 'category', 'priceHour', 'rating', 'valorations', 'sessionTime'],
    mounted() {
        console.log(this.studentsMax)
//         console.log("mounted course card",this.startAt)
    },
    filters: {
        formatted(date, format) {
//             //console.log(date,format
            if (date) {
                if (!(date instanceof Date)) {
                    date = new Date(date)
                }
                if (format === 'M') {
                    return date.toLocaleString('es', {month: 'long'});
                }
            }
            return date
        },
        formatDouble(value) {
            if (value - Math.floor(value) !== 0) {
                return parseFloat(value).toFixed(1)
            } else {
                return parseFloat(value).toFixed(0)
            }
        }
    }
}
</script>

<style scoped>
.single_courses {
    cursor: pointer;
    max-width: 400px;
}

.trajectory-category {
    font-family: "Poppins", sans-serif;
    font-size: 12px;
    font-weight: 500;
    color: #793e87;
}

.pop16-purple{
    font-family: "Poppins";
    font-size: 16px;
    font-weight: 600;
    color: #793e87;
}

.promo-red{
    font-family: "Poppins";
    font-size: 14px;
    font-weight: 500;
    color: #df2935;
    text-decoration: line-through;
}

.number-reviews {
    font-family: 'Poppins';
    font-size: 14px;
    color: #343a40;
    opacity: 0.5;
    font-weight: 300;
}

.card-details {
    font-family: 'Poppins';
    font-size: 14px;
    font-weight: 300;
    line-height: 2.14;
    color: #343a40;
}

.courses_content {
    margin-left: 20px;
    margin-right: 20px;
}

.card-trajectory-header {
    margin-bottom: 10px;
}

strong {
    font-weight: 500;
}

.btn-price {
    font-family: 'Poppins';
}

.h-48 {
    height: 48px;
}

.posit-tag-bf{
    position: absolute;
    top: 40px;
}

.posit-tag-cm{
    position: absolute;
    left: 11px;
}


@media (max-width: 769px) {
    .h-48 {
        height: auto;
    }    
}

@media (max-width: 668px) {
    .single_courses {
        max-width: none;
        width: 100%;
    }

    .box-header-card {
        height: auto;
    }

    .course-title {
        font-size: 18px;
    }

    .course-details {
        font-size: 16px;
    }
}

</style>

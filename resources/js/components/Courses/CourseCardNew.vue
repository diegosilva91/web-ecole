<template>
        <div class="single_courses mt-3 mb-30">
            <div v-if="discount>0">
                <!-- Tag BlackFriday -->
                <!-- <div v-if="typeCourse===0">
                    <img class="posit-tag-bf" src="/assets/images/promos/bf_tag.png" alt="">
                </div> -->

                <!-- Tag CyberMonday -->
                <!-- <div v-if="typeCourse==0">
                    <img class="posit-tag-cm" src="/assets/images/promos/cm_tag.png" alt="">
                </div> -->

                <!-- Tag Campus Navidad -->
                <div v-if="typeCourse===2 && subtypeCourse===2">
                    <img class="posit-tag-navidad" src="/assets/images/promos/navidad_tag.png" alt="">
                </div>
            </div>

            <a :href=url>
                <div v-if="imgMobile" class="courses_image">
                    <img v-lazysizes  :data-src="imgMobile" alt=""/>
                </div>
                <div v-else class="courses_image">
                    <img v-lazysizes  :data-src="img" alt=""/>
                </div>
            </a>
                <div class="courses_content">
                    <div class="box-header-card">
                        <div class="tag-categorie mt-2">{{category}}</div>
                        <h3 class="course-title mt-2" style="line-height: 1.5 !important;"><a class="text-dark" :href=url>{{title | truncate(45, '...') }}</a></h3>

                        <div class="mt-2 mb-2">
                            <img width="14px" height="14px" class="d-inline" src="/assets/images/course/icons/star.svg" alt="" style="vertical-align: unset;">
                            <div class="d-inline purple-title h7-txt-sbold">{{rating|formatDouble}}<span class="number-reviews ml-2">({{valorations}})</span></div>
                        </div>
                    </div>
                    <!-- <div v-if="discount=='0.00'">
                        <div class="course-details red-title"><strong>{{discount}}%</strong> Dto. <span class="dto">{{price}}€</span></div>
                    </div> -->

                    <div>
                        <div class="row">
                            <div class="col-6 course-details">
                                <img src="/assets/images/home_vector/carrito-gris.svg" alt="">
                                {{priceHour}}€ / h
                            </div>
                            <div class="col-6 course-details">
                                <img src="/assets/images/home_vector/user.svg" alt="">
                                {{ageMin}}-{{ageMax}} Años
                            </div>
                        </div>
                    </div>

                    <div class="row mt-details">
                        <div class="col-6 course-details"><img src="/assets/images/home_vector/date.svg" alt=""> {{ startAt|formatted('yyyy-MM-dd') }}</div>
                        <div class="col-6 course-details"><img src="/assets/images/home_vector/session.svg" alt=""> {{sessions}} sesiones</div>
                    </div>

                    <div>
                        <div v-if="discount>0" class="d-flex m-tag-promo">
                            <div class="tag-details"><div class="tag-promo"><span>{{discount|truncateNumber}}%</span> Dto.</div></div>
                            <div class="tag-details"><span class="red-price dto">{{price}}€</span></div>
                        </div>

                        <a :href=url :class="discount>0 ? 'v-btn v-size--default theme--light mb-20 w-100' : 'mt-30 v-btn v-size--default theme--light mb-20 w-100'" style="background-color:#29c0d3;height: 38px;border-radius: 8px;
                        box-shadow: 0 2px 8px 0 rgba(35, 158, 173, 0.5);" ><img src="/assets/images/home_vector/carrito.svg" alt="">
                            <span class="btn-price text-lowercase ml-2" v-if="discount>0">{{price-(price*discount)/100}}€</span>
                            <span class="btn-price text-lowercase ml-2" v-else>{{price}}€</span>
                        </a>
                    </div>
                </div>
        </div>
</template>

<script>
import 'lazysizes/plugins/parent-fit/ls.parent-fit';
import vueLazysizes from 'vue-lazysizes';
import VLazyImage from "v-lazy-image";
export default {
name: "CourseCardNew",
    directives: {
        lazysizes: vueLazysizes
    },
    components: {
        VLazyImage
    },
    props:['title','url','img','imgMobile','ageMin','ageMax','startAt','discount','price','sessions','category','priceHour','rating','valorations','typeCourse','subtypeCourse'],

    filters:{
        truncate(text, length, suffix){
            if(text.length) {
                if (text.length > length) {
                    return text.substring(0, length) + suffix;
                } else {
                    return text;
                }
            }
            return '';
        },
        formatted(date,format) {
            if (date) {
                if (!(date instanceof Date)) {
                    date=new Date(date)
                }

                if (format === 'yyyy-MM-dd' && date !== '') {
                    let day = (date.getDate())
                    let month = (date.getMonth() + 1)
                    if (month < 10)
                        month = '0' + month
                    if (day < 10)
                        day = `0${day}`
                    return day + '-' + month + '-' + date.getFullYear()
                }
                return date;

                //return date.toISOString().split('T')[0]
            }
            return date

        },
        formatDouble(value){
            if(value- Math.floor(value)!==0){
                return parseFloat(value).toFixed(1)
            }
            else{
                return parseFloat(value).toFixed(0)
            }
        },
        truncateNumber(value) {
            return Math.floor(value)
        },
    }
}
</script>

<style scoped>
.single_courses{
    max-width: 300px;
    cursor: pointer;
    background-color: #fff;
}

.box-header-card{
    height: 110px;
}

.number-reviews{
    font-family: 'Poppins';
    font-size: 14px;
    color: #343a40;
    opacity: 0.5;
    font-weight: 300;
}

.dto{
    font-size: 12px;
}

.red-price{
  font-family: 'Open Sans';
  font-size: 14px;
  font-weight: 600;
  color: #df2935;
}

.tag-promo {
  width: 69px;
  height: 23px;
  border-radius: 2px;
  background-color: #df2935;
  font-family: 'Poppins';
  font-size: 14px;
  font-weight: 300;
  color: #fff;
  margin-right: 8px;
  text-align: center;
}

.tag-promo>span{
    font-weight: 700;
}

.posit-tag-bf{
    position: absolute;
    top: 40px;
}

.posit-tag-cm{
    position: absolute;
    left: 11px;
}

.posit-tag-navidad{
    position: absolute;
}

.single_courses:hover .courses_image img{
    -webkit-transform:none !important;
    transform:none !important;
}

.mt-details {
    margin-top: 12px;
}

.m-tag-promo {
    margin-top: 25px;
    margin-bottom: 8px;
}

.tag-details {
    font-family: "Open Sans", sans-serif;
    font-size: 14px;
    font-weight: 400;
}

@media  (max-width: 668px) {
    .single_courses {
        max-width: none;
        width: 100%;
    }

    .box-header-card{
        height: auto;
        margin-bottom: 30px;
    }

    .course-title{
        font-size: 18px;
    }

    .course-details{
        font-size: 16px;
    }
}

</style>

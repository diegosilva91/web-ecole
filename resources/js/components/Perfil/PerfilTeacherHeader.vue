<template>
    <div class="bg-header-perfil mt-dk-65">
        <div class="header-container h-100">
            <div class="row align-items-center">
                <div class="row col-12 col-lg-6 pr-0 mt-8 mt-lg-4">
                    <div class="mr-10">
                        <div>
                            <v-avatar size="116">
                                <v-img :lazy-src="get_avatar()" :aspect-ratio="1/1" :src="get_avatar()" alt="avatar_img"></v-img>
                            </v-avatar>
                            <img class="d-flex align-items-end ml-auto edit-img" @click="pickPhoto"
                                src="/assets/images/perfil_teacher/edit.svg" alt="">
                            <v-file-input
                                style="display:none!important;"
                                class="d-flex align-items-end ml-auto edit-img"
                                accept="image/png, image/jpeg, image/bmp"
                                name="avatar"
                                type="file"
                                :rules="avatarRules"
                                id="myFileInput"
                                v-model="file"
                                @change='uploadPhoto'
                                ref="inputImage"
                            />
                        </div>
                    </div>
                    <div class="my-auto">
                        <h2>{{ user.name }}</h2>
                        <h3 class="mt-2">{{ user.email }}</h3>
                        <CourseRating class="mt-2" hiddenReviews=true :score="user.avg_course_puntuation" :valorations="user.avg_course_valorations"></CourseRating>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="row">
                        <div class="col-4">
                            <span>{{user.count_courses_active}}</span>
                            <img src="/assets/images/perfil_teacher/cursos.svg" alt="">
                            <p>Cursos<br/> publicados</p>
                        </div>
                        <div class="col-4">
                            <span>{{user.teacher_promotion_purchases_count}}</span>
                            <img src="/assets/images/perfil_teacher/ventas.svg" alt="">
                            <p>Cursos<br/> vendidos</p>
                        </div>
                        <div class="col-4">
                            <span>{{ user.sum_price_total }}</span>
                            <img src="/assets/images/perfil_teacher/euro.svg" alt="">
                            <p>Facturación<br/> obtenida</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Event from '../../event.js';
import CourseRating from '../Course/CourseRating.vue'
import {UpdateObject} from "../../axios-services";

export default {
    components: {
        CourseRating
    },
    props: ['user', 'url'],
    data: () => ({
        file:null,
        avatar:'',
        avatarRules: [
            value => !value || value.size < 5000000 || '¡El tamaño del avatar debe ser inferior a 5 MB!',
        ],
    }),
    mounted() {
        Event.$on('perfil-teacher' ,({user,url})=>{
            this.avatar=user.avatar
        })
    },
    methods: {
        pickPhoto(){
            document.getElementById("myFileInput").click()
        },
        uploadPhoto() {
            let formData = new FormData();
            formData.append('image', this.file)
            console.log("photo to upload ", formData)
            UpdateObject(`mi-perfil/photo/${this.$route.params.id}`, formData, (error, data) => {
                if (error) {
                    // console.error(error)
                } else {
                    console.log(data);
                    this.avatar = data.avatar ? data.avatar : '';
                }
            });
        },
        get_avatar() {
            return this.avatar ? this.url + this.avatar : +this.avatar;
        },
    }
}
</script>

<style scoped>
.bg-header-perfil {
  background-color: rgba(170, 231, 238, 0.3);
  height: 177px;
}

.header-container {
  margin-left: 10%;
  margin-right: 10%;
}

h2{
  font-family: 'Poppins';
  font-size: 24px;
  font-weight: 600;
}

h3, p{
  font-family: 'Poppins';
  font-size: 18px;
  font-weight: normal;
  color: #343a40;
  line-height: 1.17;
}

span{
  font-family: 'Poppins';
  font-size: 36px;
  font-weight: 600;
  color: #5c2767;
  vertical-align: middle;
}

.edit-img{
  position: relative;
  top: -30px;
  cursor: pointer;
}

@media  (max-width: 1000px) {
  .bg-header-perfil {
    height: auto;
  }
}

@media  (max-width: 600px) {
   h2{
    font-size: 18px;
  }

  h3{
    font-size: 14px;
  }

  span{
    font-size: 26px;
  }

  p{
    font-size: 16px;
  }

  .header-container {
    margin-left: 6%;
    margin-right: 6%;
  }
}
</style>

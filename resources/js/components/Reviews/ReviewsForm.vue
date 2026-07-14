<template>
    <div class="container">
        <h3 class="reviews-title text-center">Para nosotros tu opinión<br class="d-none d-sm-block"> es lo más
            importante</h3>
        <p class="reviews-subtitle subtitle text-center mt-4">Rellena esta breve encuesta y ayudanos a mejorar</p>
        <div v-if="loaded" class="form-reviews mx-auto mt-15">
            <div class="row mb-9">
                <div class="col my-auto ml-3">
                    <h3 class="course-name text-center">{{ title }}</h3>
                </div>
            </div>
            <h4 class="mb-2">¿Qué profesor te impartió la clase?</h4>
            <div class="row mb-5 mx-auto">
                <div class="col-12">
                    <v-select
                        v-model="teacherSelected"
                        :append-icon="mdiChevronDown"
                        class="teacher-select"
                        dense
                        height="47"
                        hide-details
                        :items="teachers"
                        item-text="name"
                        item-value="id"
                        :menu-props="{ offsetY: true, rounded: '0' }"
                        no-data-text="No hay datos disponibles"
                        outlined
                        persistent-placeholder
                        placeholder="Seleccione al profesor"
                    >
                        <template v-slot:selection="{ item }">
                            <v-avatar size="33" class="mr-4">
                                <img :src='url+item.avatar' alt="Avatar">
                            </v-avatar>
                            <span>{{ item.name }}</span>
                        </template>

                        <template v-slot:item="{ item }">
                            <v-avatar size="33" class="mr-4 ml-2">
                                <img :src='url+item.avatar' alt="Avatar">
                            </v-avatar>
                            <span>{{ item.name }}</span>
                        </template>
                    </v-select>
                </div>
            </div>
            <div>
                <h6 class="mb-6">Valora del 1 al 5 las siguientes preguntas, donde 1 es muy poco satisfecho y 5 es muy
                    satisfecho.</h6>
                <h5>¿Cómo varlorías el contenido que se ha impartido en el curso?</h5>
                <div class="mt-4 mb-10">
                    <v-input :value="rating1" :rules="rulesRating" ref="rating0">
                        <v-rating
                            v-model="rating1"
                            size="46"
                            color="#793e87"
                            background-color="#793e87"
                        ></v-rating>
                    </v-input>
                </div>
                <h5>¿Cómo ha sido la comunicación entre profesor y el alumno?</h5>
                <div class="mt-4 mb-10">
                    <v-input :value="rating2" :rules="rulesRating"  ref="rating1">
                        <v-rating
                            v-model="rating2"
                            :rules="rulesRating"
                            size="46"
                            color="#793e87"
                            background-color="#793e87"
                        ></v-rating>
                    </v-input>
                </div>
                <h5>¿Cómo ha sido la flexibilidad del profesor a la hora de adaptarse al aprendizaje de tu hij@?</h5>
                <div class="mt-4 mb-10">
                    <v-input :value="rating3" :rules="rulesRating"  ref="rating2">
                        <v-rating
                            v-model="rating3"
                            :rules="rulesRating"
                            size="46"
                            color="#793e87"
                            background-color="#793e87"
                        ></v-rating>
                    </v-input>
                </div>
                <h5>Indícanos tu valoración general del profesor</h5>
                <div class="mt-4 mb-10">
                    <v-input :value="rating4" :rules="rulesRating"  ref="rating3">
                        <v-rating
                            v-model="rating4"
                            :rules="rulesRating"
                            size="46"
                            color="#793e87"
                            background-color="#793e87"
                        ></v-rating>
                    </v-input>
                </div>
                <h5 class="mb-4">Observaciones/opiniones o comentarios</h5>
                <v-textarea
                    outlined
                    name=""
                    counter
                    v-model="opinion"
                    ref="boxes"
                    color="#793e87"
                ></v-textarea>
                <transition name="fade">
                    <v-alert
                        dense
                        outlined
                        v-show="showValidateFormText"
                        type="error"
                    >
                        {{ validateText }}
                    </v-alert>
                </transition>
                <div class="d-flex justify-content-end">
                    <v-btn
                        v-if="token"
                        class="accent mt-10"
                        color="accent"
                        :disabled="submitFormIsLoading"
                        :loading="submitFormIsLoading"
                        @click="submitForm"
                    >
                        <span class="font-weight-semibold">Enviar</span>
                    </v-btn>
                </div>
            </div>
            <vue-progress-bar></vue-progress-bar>
        </div>
        <div v-else class="row" slot="spinner">
            <v-progress-circular
                indeterminate
                color="#5c2767"
                class="mx-auto">
            </v-progress-circular>
        </div>
    </div>
</template>

<script>
import { mdiChevronDown } from "@mdi/js";
import { UpdateObjectApi } from '../../axios-services'
import Event from "../../event";

export default {
    props: {
        title: {
            type: String,
            default: ''
        },
        course_users: {
            default:null
        },
        token:{
            type:String,
            default:''
        },
        url: {
            type: String,
            default: ''
        },
        modalMessage:{
            type:String,
            default:'Datos no encontrados con las especificaciones solicitadas.'
        }
    },
    created() {
        this.$Progress.start()
    },
    mounted() {
        let vm=this
        if (this.course_users) {
            this.teachers.push(...this.course_users.map((course) => {
                    course.active = false;
                    return course
                })
            );
        }
        this.loaded = true;
        this.$Progress.finish()
        if(!this.token){
            // vm.$forceUpdate()
            vm.$nextTick(()=> {
                Event.$emit("openModalReviews", {message: vm.modalMessage, enable: true});
            })
        }
        console.log(this.modalMessage)
    },
    data: () => ({
        loaded: false,
        mdiChevronDown,
        showValidateFormText: false,
        validateText: '',
        rating1: 0,
        rating2: 0,
        rating3: 0,
        rating4: 0,
        opinion: '',
        rulesRating: [v => (!isNaN(parseFloat(v)) && v >= 1 && v <= 5) || 'Debe definir la duración de la clase en minutos.'],
        submitFormIsLoading: false,
        teachers: [],
        teacherSelected: undefined,
    }),
    methods: {
        submitForm() {
            this.submitFormIsLoading = true;
            this.$Progress.start()
            let teacher_id = this.teacherSelected;
            this.activeValidations()
            if (!teacher_id) {
                this.showValidateFormText = true
                this.validateText = 'Debes seleccionar al menos un profesor';
                this.$Progress.finish()
                this.submitFormIsLoading = false;
            } else if (!this.validateRatings()) {
                this.showValidateFormText = true
                this.validateText = 'Define el rating del curso';
                this.submitFormIsLoading = false;
            } else {
                this.showValidateFormText = false
                console.log(this.teachers.filter(teacher => teacher.active === true));
                let vm = this
                let formData = {
                    rating1: vm.rating1,
                    rating2: vm.rating2,
                    rating3: vm.rating3,
                    rating4: vm.rating4,
                    opinion: vm.opinion,
                    teacher_id: parseInt(teacher_id),
                }
                UpdateObjectApi(`reviews/${vm.token}`, formData, (error, data) => {
                    if (data) {
                        Event.$emit("openModalReviews", {message:vm.modalMessage,enableButton:false});
                    } else {
                        this.submitFormIsLoading = false;
                        //Send logs
                    }
                })
                this.$Progress.finish()
            }
        },
        activeValidations() {
            for (let i = 0; i < 4; i++) {
                let ref=`rating${i}`;
                this.$refs[ref].validate()
            }
        },
        validateRatings() {
            for (let i = 0; i < 4; i++) {
                let ref=`rating${i}`;
                if (!this.$refs[ref].valid) {
                    return false
                }
                this.$refs[ref].$el.focus()
            }
            return true
        }
    }
}
</script>

<style scoped>

.reviews-title {
    font-family: 'Poppins';
    font-size: 35px;
    font-weight: bold;
}

.reviews-subtitle {
    font-family: 'Poppins';
    font-size: 21px;
    font-weight: 300;
}

.course-name {
    font-family: 'Poppins';
    font-size: 21px;
    font-weight: 600;
}

h4 {
    font-size: 16px;
}

h5 {
    font-size: 12px;
}

h6 {
    color: rgba(52, 58, 64, 0.71);
}

.form-reviews {
    width: 734px;
    padding: 3.5rem;
    border-radius: 12px;
    box-shadow: 0 4px 18px 0 rgba(0, 0, 0, 0.2);
    background-color: #ffffff;
}

.btn-reviews {
    width: 111px;
    height: 40px;
    border-radius: 4px;
    box-shadow: 0 2px 5px 0 rgba(41, 192, 211, 0.3);
    border: solid 1px #29c0d3;
    background-color: #29c0d3;
    font-family: 'Poppins';
    font-size: 16px;
    font-weight: 600;
    color: #ffffff;
}

.teacher-select {
    max-width: 405px;
}

@media (max-width: 800px) {
    .form-reviews {
        width: 100%;
        padding: 1.5rem;
    }
}

</style>

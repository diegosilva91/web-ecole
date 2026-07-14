<template>
<div class="container mt-mob-45 mt-tb-50 mt-100">
    <input id="searchInpt" v-model="search" type="text" class="search-input text-dark" @input="updateSearch" @keyup.enter="updateSearch('enter')"  placeholder="Buscar Cursos"/>
    <div class="bg-nav-mobile mt-5 mb-10 d-flex">
        <h6 @click="activeFilter('activos')" :active='active1'>Activos</h6>
        <h6 @click="activeFilter('proximos')" :active='active2'>Próximos</h6>
        <h6 @click="activeFilter('finalizados')" :active='active3'>Finalizados</h6>
        <h6 @click="activeFilter('todos')" :active='active4'>Todos</h6>
    </div>
    <div class="row" v-if="courses.length>0">
        <div v-for="course in courses" :key="course.id" class="col-12 col-md-6">
            <div class="promotion-card">
                <div>
                    <h5>Curso</h5>
                    <p class="w-75" style="height:48px;">{{course.title}}</p>
                </div>
                <hr>
                <div class="row">
                    <div class="col-6">
                        <h5>Inicio</h5>
                        <p>{{course.date |formatted('yyyy-MM-dd' )}}</p>
                    </div>
                    <div class="col-6">
                        <h5>Hora</h5>
                        <p>{{course.time | formatted('hh:mm')}}</p>
                    </div>
                    <div class="col-6">
                        <h5>Sesiones</h5>
                        <p>{{course.courses.duration}}</p>
                    </div>
                    <div class="col-6">
                        <h5>Alumnos</h5>
                        <p>{{course.students}}</p>
                    </div>
                    <div class="col-6">
                        <h5>Clase</h5>
                        <p><span @click="openModalChat(course.user_assistant)">Alumnos</span></p>
                    </div>
                    <div class="col-6">
                        <h5>Confirmación</h5>
                        <p class="mt-2"><img :src="course.confirmation?'/assets/images/perfil_teacher/checked.svg':'/assets/images/perfil_teacher/incomplete.svg'" alt=""></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import ModalChat from './ModalChat';
import Event from "../../event";

export default {
    components: {
        ModalChat
    },
    data:()=>({
        queryDate:'',
        search:'',
        querySearch:'',
        active1: false,
        active2: false,
        active3: false,
        active4: true,
        courses:[
        ]
    }),
    mounted() {
        this.getDataPromotions()
    },
    methods:{
        getDataPromotions() {
            const vm = this
            Event.$on('data-promotions', (data) => {
                console.log(data)
                vm.courses = data

                this.loading = true
            })
        },
        activeFilter(v) {
            switch(v){
                case 'activos':
                    this.active1=true;
                    this.active2=this.active3=this.active4=false;
                    this.queryDate=`&filter[start_at_end_at]=active`
                    break;
                case 'proximos':
                    this.active2=true;
                    this.active1=this.active3=this.active4=false;
                    this.queryDate=`&filter[start_at_end_at]=next`
                    break;
                case 'finalizados':
                    this.active3=true;
                    this.active2=this.active1=this.active4=false;
                    this.queryDate=`&filter[start_at_end_at]=finished`
                    break;
                case 'todos':
                    this.active4=true;
                    this.active2=this.active3=this.active1=false;
                    this.queryDate=`&filter[start_at_end_at]=all`
            }
            this.applyFilters()
        },
        applyFilters(){
            let query= this.queryDate+this.querySearch
            Event.$emit('filter-promotions', query);
        },
        openModalChat(users_promotion_purchases) {
            Event.$emit('openModalChat',users_promotion_purchases);
        },
        updateSearch(method) {
            if(this.search.length>=3){
                this.querySearch = '&filter[search_by]=' + this.search
                this.applyFilters()
            }
            if(method==='enter'){
                this.querySearch = '&filter[search_by]=' + this.search
                this.applyFilters()
            }
        },
    },
    filters: {
        formatted(date, format) {
            if(date) {
                if (format === 'yyyy-MM-dd' && date !== '') {
                    let month = (date.getMonth() + 1)
                    let day = date.getDate()
                    if (month < 10)
                        month = '0' + month
                    if (day < 10)
                        day = `0${day}`
                    return `${day}-${month}-${date.getFullYear()}`
                }
                if (format === 'hh:mm' && date !== '') {
                    let minutes = date.getMinutes()
                    if (minutes < 10)
                        minutes = `0${minutes}`
                    return `${date.getHours()}:${minutes}`
                }
                //return date.toISOString().split('T')[0]
                return date;
            }
            return date;
        },

    }
}
</script>

<style scoped>
h6{
    color: rgba(52, 58, 64, 0.7);
    cursor: pointer;
    font-size: 16px;
    margin: 10px auto;
}

h6[active]{
  height: 40px;
  padding: 10px;
  color: #5c2767;
  border-radius: 20px;
  border: solid 1.5px #5c2767;
  background-color: #ffffff;
  margin: 0px;
}

h5{
    font-size: 14px;
    font-weight: 500;
    opacity: 0.7;
}

p{
  font-family: 'Poppins';
  font-size: 16px;
  color: #343a40;
}

p>span{
  font-weight: 600;
  color: #29c0d3;
  cursor: pointer;
}

.search-input {
    width: 100%;
    height: 40px;
    border-radius: 4px;
    padding: 10px 10px 10px 70px !important;
    border: solid 1px rgba(52, 58, 64, 0.3);
    background-color: #ffffff;
    background: url('/assets/images/filters/search.svg') no-repeat;
    background-position: 2% 50% !important;
    font-family: 'Poppins';
    font-size: 14px;
}


#searchInpt::-webkit-input-placeholder { /* Chrome/Opera/Safari */
    color:  rgba(52, 58, 64, 0.7);
}

#searchInpt::-moz-placeholder { /* Firefox 19+ */
    color:  rgba(52, 58, 64, 0.7);
}

#searchInpt:-ms-input-placeholder { /* IE 10+ */
    color:  rgba(52, 58, 64, 0.7);
}

.bg-nav-mobile{
  max-width: 380px;
  height: 40px;
  border-radius: 20px;
  background-color: rgba(52, 58, 64, 0.1);
}

.promotion-card {
  max-width: 400px;
  height: auto;
  padding: 20px 30px;
  border-radius: 12px;
  box-shadow: 0 4px 18px 0 rgba(0, 0, 0, 0.15);
}

@media  (max-width: 600px) {
   .search-input{
       padding: 10px 10px 10px 50px !important;
   }
}
</style>

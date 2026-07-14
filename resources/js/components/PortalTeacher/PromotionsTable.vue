<template>
    <div class="container-promotions mt-50 mt-dk-180">
        <input id="searchInpt" v-model="search" type="text" class="search-input text-dark" @input="updateSearch" @keyup.enter="updateSearch('enter')"  placeholder="Buscar Cursos"/>
        <div class="mt-5 d-flex">
            <h6 @click="activeFilter('activos')" :active='active1'>Activos</h6>
            <h6 class="ml-2 mr-2">/</h6>
            <h6 @click="activeFilter('proximos')" :active='active2'>Próximos</h6>
            <h6 class="ml-2 mr-2">/</h6>
            <h6 @click="activeFilter('finalizados')" :active='active3'>Finalizados</h6>
            <h6 class="ml-2 mr-2">/</h6>
            <h6 @click="activeFilter('todos')" :active='active4'>Todos</h6>
        </div>
        <table class="table mt-8">
            <thead class="h7-txt text-dark">
            <tr>
                <th scope="col">Cursos <span v-html="iconFilter"></span></th>
                <th scope="col">Inicio <span v-html="iconFilter"></span></th>
                <th scope="col">Sesiones <span v-html="iconFilter"></span></th>
                <th scope="col">Alumnos <span v-html="iconFilter"></span></th>
                <th scope="col">Clase</th>
                <th scope="col">Confirmación <span v-html="iconFilter"></span></th>
            </tr>
            </thead>
            <tbody v-if="courses.length>0">
            <tr v-for="course in courses" :key="course.promotions_id" class="h7-txt text-dark">
                <td>{{ course.courses.title }}</td>
                <td>{{ course.date|formatted('yyyy-MM-dd') }}<br><span>{{ course.time|formatted('hh:mm') }}</span></td>
                <td>{{ course.courses.duration }}</td>
                <td>{{ course.students }}</td>
                <td @click="openModalChat(course.user_assistant)" class="chat-link">Alumnos</td>
                <td :class="{'gray-txt':!course.confirmation}">
                    {{ course.confirmation ? 'Confirmado' : 'Sin confirmar' }}
                </td>
            </tr>
            </tbody>
        </table>
        <ModalChat/>
    </div>
</template>

<script>
let today = new Date();
let todayFormat = today.getFullYear() + '/' + (today.getMonth() + 1) + '/' + today.getDate()
import ModalChat from './ModalChat';
import Event from "../../event";

export default {
    components: {
        ModalChat
    },
    data: () => ({
        queryDate:'',
        querySearch:'',
        search: '',
        active1: false,
        active2: false,
        active3: false,
        active4: true,
        iconFilter: "<img class='ml-2' src='/assets/images/icons/filter.svg' alt='' style='cursor:pointer;'>",
        headers: [{
            text: 'Cursos',
            align: 'start',
            sortable: true,
            value: 'courses.title',
        }, 'Inicio', 'Sesiones', 'Alumnos', 'Clase', 'Confirmación',],
        courses: [
        ],
        loading: false,
        dialog: false
    }),
    mounted() {
        this.getDataPromotions()
    },
    methods: {
        getDataPromotions() {
            const vm = this
            Event.$on('data-promotions', (data) => {
                console.log(data)
                vm.courses = data

                this.loading = true
            })
        },
        activeFilter(v) {
            switch (v) {
                case 'activos':
                    this.active1 = true;
                    this.active2 = this.active3 = this.active4 = false;
                    this.queryDate=`&filter[start_at_end_at]=active`
                    break;
                case 'proximos':
                    this.active2 = true;
                    this.active1 = this.active3 = this.active4 = false;
                    this.queryDate=`&filter[start_at_end_at]=next`
                    break;
                case 'finalizados':
                    this.active3 = true;
                    this.active2 = this.active1 = this.active4 = false;
                    this.queryDate=`&filter[start_at_end_at]=finished`
                    break;
                case 'todos':
                    this.active4 = true;
                    this.active2 = this.active3 = this.active1 = false;
                    this.queryDate=`&filter[start_at_end_at]=all`
            }
            this.applyFilters()
        },
        applyFilters(){
            let query= this.queryDate+this.querySearch
            Event.$emit('filter-promotions', query);
        },
        parameterizeArray(key, arr,operator) {
            if (arr.length === 0)
                return ''
            if (operator==='&')
                return '&filter[' + key + ']=' + arr.join( ',')
            return '&filter[' + key + ']=' + arr.join('&filter[' + key + ']=')
        },
        openModalChat(users_promotion_purchases) {
            Event.$emit('openModalChatDesktop', users_promotion_purchases);
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
        },
    }
}
</script>

<style scoped>
.container-promotions {
    margin-left: 10%;
    margin-right: 10%;
}

h6 {
    color: rgba(52, 58, 64, 0.7);
    cursor: pointer;
}

h6[active] {
    color: #343a40;
    border-bottom: 2px solid #793e87;
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
    color: rgba(52, 58, 64, 0.7);
}

#searchInpt::-moz-placeholder { /* Firefox 19+ */
    color: rgba(52, 58, 64, 0.7);
}

#searchInpt:-ms-input-placeholder { /* IE 10+ */
    color: rgba(52, 58, 64, 0.7);
}

thead {
    font-weight: 500;
    background-color: rgba(52, 58, 64, 0.1);
    text-transform: uppercase;
}

td > span {
    color: rgba(52, 58, 64, 0.7);
}

.gray-txt {
    color: rgba(52, 58, 64, 0.7);
}

.chat-link {
    font-weight: 600;
    color: #29c0d3;
    cursor: pointer;
}

@media (max-width: 600px) {
    .search-input {
        padding: 10px 10px 10px 50px !important;
    }
}
</style>

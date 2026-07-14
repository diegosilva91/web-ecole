<template>
<div>
    <PerfilTeacherHeader :user="user" :url="url"/>
    <NavTeacher />
    <AboutTeacher/>
</div>
</template>

<script>
import PerfilTeacherHeader from './PerfilTeacherHeader'
import NavTeacher from './NavTeacher'
import AboutTeacher from './AboutTeacher'
import {GetObject} from "../../axios-services";
import Event from "../../event";

export default {
    components: {
        PerfilTeacherHeader,
        NavTeacher,
        AboutTeacher
    },
    created() {
        this.getData()
    },
    data(){
        return{
            user:'',
            url:''
        }
    },
    methods: {
        getData: function () {
            //this.loading = false
            GetObject('mi-perfil-teacher/' + this.$route.params.id, (error, data) => {
                if (error) {
                    data.user = {
                        name: '',
                        email: '',
                        teachers: ''
                    };
                    this.loading = true
                } else {
                    if(data.user && data.url){
                        this.user= data.user
                        this.url= data.url
                        Event.$emit('perfil-teacher' ,{user:this.user,url:this.url})
                    }
                }
            });
        },
    }
}
</script>

<style>

</style>

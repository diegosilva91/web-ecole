<template>
  <div>
    <UserPerfilHeader :user="user" :url="url" />
    <NavUser />
    <AboutUser />
  </div>
</template>

<script>
import UserPerfilHeader from './UserPerfilHeader'
import NavUser from './NavUser'
import AboutUser from './AboutUser'
import {GetObject} from "../../axios-services";
import Event from "../../event";

export default {
    components: {
        UserPerfilHeader,
        NavUser,
        AboutUser
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

            GetObject('mi-perfil/' + this.$route.params.id, (error, data) => {
                if (error) {
                    data.user = {
                        name: '',
                        email: '',
                    };
                    this.loading = true
                } else {
                    if(data.user && data.url){
                        this.user= data.user
                        this.url= data.url
                        Event.$emit('perfil-customer' ,{user:this.user,url:this.url})
                    }
                }
            });
        },
    }

}
</script>

<style>

</style>

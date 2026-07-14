<template>
<div class="nav-container">
  <div class="mt-5 d-flex">
    <h6 :class="{'text-dark line-nav':active1}" @click="active1=true;active2=false;activeAbout()">General</h6>
    <h6 class="ml-2 mr-2">/</h6>
    <h6 :class="{'text-dark line-nav':active2}" @click="active2=true;active1=false;activeCash()">Facturación</h6>    
  </div>
</div>
</template>

<script>
import Event from '../../event.js';
export default {
    data() {
        return{
            active1:true,
            active2:false
        }
    },
    methods: {
        activeCash(){
            Event.$emit('cashActive');
        },
        activeAbout(){
            Event.$emit('aboutActive');
        },
    }
}
</script>

<style scoped>
.nav-container{
    margin-left: 10%;
    margin-right: 10%;
}

h6{
    color: rgba(52, 58, 64, 0.7);
    cursor: pointer;
}

.line-nav{
    border-bottom: 3px solid #793e87;
}

@media  (max-width: 600px) {
    .nav-container{
    margin-left: 6%;
    margin-right: 6%;
}   
}
</style>
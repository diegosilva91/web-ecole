<template>
    <div class="observer"></div>
</template>

<script>
export default {
    name: 'observer',
    props:['msg'],
    data () {
        return {
            observer: null
        };
    },
    mounted () {
        this.observer= new IntersectionObserver(([entry])=>{
            if(entry &&entry.isIntersecting){
                console.log("intersect",this.msg);
                this.$emit('intersect');
            }
        },{rootMargin: '100px',});
        this.observer.observe(this.$el);
    },

}
</script>

<style>
</style>

<template>
<div>
  <TechHeaderTrajectories bg='bg-trajectories' title="¿Quién dijo que lo
  bueno dura poco?" description='¡Ya están aquí los cursos anuales de Mi-empresa! Donde tus hijos
  tendrán un seguimiento con profesionales del sector que les ayudarán a sacar el máximo partido.' imgAWS='https://myawsmi-empresa.s3.eu-west-1.amazonaws.com/public/trajectories/header_trajectories.svg' trajectories=true />
  <Abstract />
  <Categories />
</div>
</template>

<script>
import TechHeaderTrajectories from '../Trajectories/TechHeaderTrajectories.vue'
import Abstract from '../Trajectories/Abstract.vue'
import Categories from '../Trajectories/Categories.vue'

export default {
 components:{
   TechHeaderTrajectories,
   Abstract,
   Categories
 }
}
</script>

<style>

</style>

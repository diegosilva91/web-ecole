<template>
<div class="container"> 
  <h2 class="title-section mb-7">Sorpréndete en el mundo Lifecooler</h2>
  <div class="row justify-content-center">
      <div v-for="(tag, i) in tags" :key="i">
        <div :class="tag.color" class="tag">{{tag.title}}</div>
      </div>
  </div>
</div>
</template>

<script>
export default {
    data: ()=>({
        tags:[
            {title:'Minecraft',color:'tag-blue'},
            {title:'Roblox',color:'tag-gray'},
            {title:'Videojuegos',color:'tag-yellow'},
            {title:'Unity',color:'tag-purple'},
            {title:'Unreal',color:'tag-blue'},
            {title:'Metaversos',color:'tag-gray'},
            {title:'Robótica',color:'tag-yellow'},
            {title:'Arduino',color:'tag-purple'},
            {title:'Arte digital',color:'tag-blue'},
            {title:'Cómic',color:'tag-gray'},
            {title:'Influencers',color:'tag-yellow'},
            {title:'Streamers',color:'tag-purple'},
            {title:'Vloggers',color:'tag-blue'},
            {title:'Ciberseguridad',color:'tag-gray'},
            {title:'Inteligencia artificial',color:'tag-yellow'},
            {title:'Internet of things',color:'tag-blue'},
            {title:'Data science',color:'tag-gray'},
            {title:'Cloud computing',color:'tag-purple'},
        ]
    })
}
</script>

<style scoped>
.title-section{
  font-size: 16px;
  font-weight: 300;
  color: #2f2f2f;
  text-align: center;
}

.tag {
  width: auto;
  height: 27px;
  border-radius: 14px;
  font-family: 'Poppins';
  font-size: 12px;
  font-weight: 600;
  text-align: center;
  padding: 3px 20px;
  margin-right: 10px;
  margin-top: 15px;
}

.tag-blue {
  border: solid 1px #28bfd2;
  background-color: #f2feff;
  color: #28bfd2;
}

.tag-gray { 
  border: solid 1px rgba(23, 68, 71, 0.66);
  background-color: rgba(141, 177, 178, 0.21);
  color: rgba(23, 68, 71, 0.65);
}

.tag-yellow {
  border: solid 1px #f4a403;
  background-color: rgba(255, 179, 0, 0.1);
  color: #de9400;
}

.tag-purple {
  border: solid 1px #82388b;
  background-color: rgba(204, 161, 214, 0.26);
  color: #793e87;
}
</style>
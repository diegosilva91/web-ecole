<template>
<div class="bg-header-teacher">
    <div class="box d-flex text-dark h-100">
      <div class="col-12 col-lg-7">
        <div :class="{'d-none':openForm}" class="mt-lg-12">
          <h3 class="text-dark">
          Imparte educación a tu<br class="d-none d-lg-block" /> medida y genera ingresos extra
          </h3>
          <p>
            Comienza a dar <span>clases online</span> a <span>grupos reducidos</span> en las materias<br class="d-none d-lg-block" /> y nivel que tú elijas.
          </p>
          <p>
            En Mi-empresa guiamos a nuestros alumnos a través de <span>trayectorias</span><br class="d-none d-lg-block" /> desde sus <span>pasiones</span> hasta el mundo profesional.
          </p>
        </div>
        <div class="d-block d-md-none">
          <button :class="{'d-none':openForm}" @click="openForm=true;" class="btn-teacher-mob mt-10 mb-15">Inscribirme</button>
        </div>
        <teacher-modal-form btnTxt='Inscribirme' class="d-none d-md-block d-lg-none"></teacher-modal-form>
        <register-teacher-form id="Form" class="mt-dk-100 mt-tb-40 mt-mob-40 mb-dk-40 mb-tb-40 mb-mob-40 mx-auto" v-show="openForm"></register-teacher-form>
      </div>
      <div class="d-none d-lg-block col-lg">
        <register-teacher-form id="FormPhone" closeIcon='d-none' class=""></register-teacher-form>
      </div>
    </div>
</div>
</template>

<script>
import Event from '../../event.js';
export default {
    props: ['user_id'],
  data() {
    return{
        openForm:false,
        isLogin:false,
    }
  },
    mounted: function () {
        Event.$on('closeForm', () => {
            this.openForm = false;
        });
        this.user_id ? this.login = true : this.login = false
        Event.$emit('user_id_register_teacher',{user_id:this.user_id,is_login:this.login} );
    }
};
</script>

<style scoped>
.box {
  margin-left: 10%;
  margin-right: 10%;
  margin-top: 50px;
  margin-bottom: 50px;
}

.bg-header-teacher{
  background-image: url('/assets/images/backgrounds/bg_teacher_header.png');
  background-position: center center;
  background-size: cover;
  background-repeat: no-repeat;
  width: 100%;
  height: auto;
}

h3{
  font-family: 'Poppins';
  font-size: 36px;
  font-weight: bold;
  margin-bottom: 28px;
  margin-top: 62px;
  line-height: 1.3;
}

p{
  font-family: 'Poppins';
  font-size: 18px;
  font-weight: 300;
  margin-bottom: 28px;
}

p>span {
  font-weight: 500;
}

.btn-teacher-mob{
  width: 153px;
  height: 40px;
  border-radius: 4px;
  box-shadow: 0 2px 5px 0 rgba(41, 192, 211, 0.3);
  border: solid 1px #29c0d3;
  background-color: #29c0d3;
  color: white;
  font-family: 'Poppins';
  font-size: 16px;
  font-weight: 600;
}

@media  (max-width: 1024px) {
  .bg-header-teacher{
    height: 100%;
    min-height: 700px;
    background-image: url('/assets/images/backgrounds/bg_teacher_header_mob.png');
  }

  h3{
    font-size: 35px;
  }
}

@media  (max-width: 450px) {
  .box {
    margin-left: 3%;
    margin-right: 3%;
    margin-top: 0px;
    margin-bottom: 0px;
  }
}

</style>

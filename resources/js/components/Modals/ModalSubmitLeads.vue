<template>
<div class="modal fade" id="modalSubmitLeads" tabindex="-1" role="dialog" aria-labelledby="modalSubmitLeadsTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <v-icon>{{ mdiClose }}</v-icon>
        </button>
        <h5 class="modal-title" id="exampleModalLongTitle">¡Hemos recibido tu solicitud!</h5>
        <hr class="mb-0 mt-1 col-6 mx-auto pt-0">
      <h6 class="modal-body pt-1">
        En las próximas 24-48h recibirás un correo electrónico <br class="d-none d-lg-block"> para elegir cuándo quieres realizar la sesión.
      </h6>
      <div class="row justify-content-center">
        <button type="button" class="btn-submit-leads" data-dismiss="modal">¡Gracias!</button>
      </div>
    </div>
  </div>
</div>
</template>

<script>
import { mdiClose } from '@mdi/js';

export default {
  data() {
    return {
      mdiClose
    }
  }
}
</script>

<style scoped>
.modal {
    height: auto !important;
    top: 25% !important;
}

.modal-dialog {
    max-width: 494px !important;
    height: auto;
}

.modal-header {
    border-bottom: none;
}

.modal-title {
    text-align: center;
    font-size: 16px;
    font-weight: 500;
    color: #1a1d1f;
}

.modal-body {
    text-align: center;
    font-size: 14px;
    font-weight: 300;
    color: #1a1d1f;
    padding-right: 40px;
    padding-left: 40px;
}

.close {
    margin-left: auto;
    margin-right: 15px;
    margin-top: 15px;
}

.btn-submit-leads {
  width: 109px;
  height: 32px;
  border-radius: 4px;
  box-shadow: 0 2px 8px 0 rgba(35, 158, 173, 0.27);
  border: solid 1px #29c0d3;
  background-color: #fff;
  font-family: 'Poppins';
  font-size: 14px;
  font-weight: 600;
  color: #29c0d3;
  margin-bottom: 30px;
}

@media  (max-width: 430px) {
    .modal-body {
      padding-left: 60px;
      padding-right: 60px;
    }
}

</style>
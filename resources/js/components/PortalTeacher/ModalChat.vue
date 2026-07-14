<template>
  <v-dialog
   v-model="dialog"
   persistent
   max-width="625"
   class="chat-modal"
  >
  <v-card class="chat-modal">
        <div class="container pt-0 pb-0 d-flex bg-header-modal text-white">
          <div class="col h7-txt-sbold ml-1">Clase</div>
          <span>
            <v-btn text icon class="col ml-auto mr-2" @click="dialog=false;">
                <v-icon size="24" color="white">{{ mdiClose }}</v-icon>
            </v-btn>
          </span>
        </div>
        <v-card-text>
          <table class="table table-borderless">
            <thead>
            <tr class="text-muted pl-0">
                <th class="h7-txt" scope="col">Alumnos</th>
                <th class="h7-txt" scope="col">Edad</th>
            </tr>
            </thead>
            <tbody>
              <tr v-for="studant in students" :key="studant.id" class="h7-txt-sbold text-dark">
                  <td class="text-uppercase pt-1">{{ studant.name }}</td>
                  <td class="text-lowercase pt-1">{{ studant.age }} años</td>
              </tr>
            </tbody>
        </table>
        </v-card-text>
  </v-card>
  </v-dialog>
</template>

<script>
import { mdiClose } from "@mdi/js";
import Event from "../../event";
export default {
    data:()=>({
        dialog:false,
        mdiClose,
        students:[
        ]
    }),

    mounted() {
        Event.$on('openModalChatDesktop', (users_promotion_purchases)=>{ this.students=users_promotion_purchases; this.dialog=true;})
        Event.$on('openModalChat', (users_promotion_purchases)=>{this.students=users_promotion_purchases; this.dialog=true;})
  },
}
</script>

<style scoped>
.chat-modal {
  height: auto;
  border-radius: 12px;
  box-shadow: 0 4px 18px 0 rgba(0, 0, 0, 0.15);
}

.pointer-chat {
  cursor: pointer;
}

.bg-header-modal{
  background-color: #753d83;
  height: 40px;
}

.h7-txt-sbold{
  font-weight: 500;
  text-transform: uppercase;
}

</style>

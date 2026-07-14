<template>
  <v-dialog
    max-width="700px"
    v-model="dialog"
    id="formModalCard"
    >
            <!-- <template v-slot:activator="{ on, attrs }">
                 <button
                 class="btn-category"
                 v-bind="attrs"
                 v-on="on"
                 @click="joinItModal(categories)"
                 >
                   Infórmate
                 </button>
            </template> -->

            <v-list class="pt-0 pb-0">
                <v-list-item>
                    <v-btn class="ml-auto" icon @click="dialog = false">
                        <v-icon>{{ mdiClose }}</v-icon>
                    </v-btn>
                </v-list-item>
                <landing-form categoryModal="categoryModal" :category="categories"></landing-form>
            </v-list>
  </v-dialog>
</template>

<script>
import { mdiClose } from "@mdi/js";
import Event from '../../event.js';
import LandingForm from './LandingForm.vue'
export default {
  components: { LandingForm },
    props:['category'],
    mounted() {
     Event.$on('show-modal-card', (category) => {this.dialog=true; this.categories=category;  });
    },

    /*watch:{
      categories: function(){
          Event.$on('showModalCard', (category) => {this.dialog=true; this.categories=category;});
      }
    },*/
    data() {
        return {
            categoryForm: document.querySelector('select[name="category"]'),
            categories:'',
            categoryModal:'categoryModal',
            dialog:false,
            mdiClose
        }
    },
    methods:{
        UpdateModal(category){
            this.dialog=true;
            this.categories=category;
        },
        joinItModal(categories){
            console.log("informate"+ categories)
            let categoryTrack=categories.toString()
        //    fbq('track', 'interestedInCategory', {category:categoryTrack})
            window.gtag('send',{
                hitType: 'event',
                eventCategory: 'interestedInCategory',
                eventAction: 'interestedInCategory_'+categoryTrack,
                eventLabel: 'interestedInCategory_'+categoryTrack
            })
            window.fbq('track', 'interestedInCategory', {category:categoryTrack})
            //$("#categoryModal select").val(categoryTrack);
            //$("#categoryModal").trigger("change");
        },
    }
}
</script>

<style scoped>
    .btn-category {
        color: #ffffff;
        width: 93px;
        height: 34px;
        object-fit: contain;
        border-radius: 4px;
        box-shadow: 0 2px 5px 0 rgba(41, 192, 211, 0.3);
        border: solid 1px #29c0d3;
        background-color: #29c0d3;
        font-family: 'Poppins';
        font-size: 14px;
        font-weight: 600;
        margin-left: 20px;
        margin-top: 10px;
    }
</style>

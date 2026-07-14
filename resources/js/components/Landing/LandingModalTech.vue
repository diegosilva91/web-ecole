<template>
    <v-dialog
        max-width="700px"
        v-model="dialog"
        id="formModalCard"
    >
        <v-list class="pt-0 pb-0">
            <div class="d-flex">
                <v-btn class="ml-auto mt-3 mr-4" icon @click="dialog = false;closeModal();" >
                    <v-icon>{{ mdiClose }}</v-icon>
                </v-btn>
            </div>
            <landing-form-tech viewType="summer" categoryModal="categoryModal" :category="categories"></landing-form-tech>
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
        window.addEventListener('scroll', this.onScroll);
     Event.$on('show-modal-card', () => {this.dialog=true;});
     Event.$on('hidden-modal-card', () => {this.dialog=false;});
        window.addEventListener('beforeunload', this.leaving);
    },
    destroyed() {
        window.removeEventListener('scroll', this.handleScroll);
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

        onScroll(event) {
            // console.log(window.scrollY)
            let positionToOpen = 830;
            if ( window.scrollY > positionToOpen) {
                this.openModal();
            }
        },
        openModal(){
            // console.log(this.$cookies.get('hideLandingModal'))
            if (!this.$cookies.get('hideLandingModal')) {
                this.dialog=true;
            }
        },
        closeModal(){
            this.$cookies.set("hideLandingModal", true, "1h");
        },
        leaving() {
            this.$cookies.remove('hideLandingModal');
        }
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

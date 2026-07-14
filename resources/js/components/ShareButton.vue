<template>
        <v-dialog
            max-width="350px"
            v-model="dialog">
            <template v-slot:activator="{ on, attrs }">
                 <v-btn
                    class="text-transform-btn white--text font-size-12 font-family-secondary"
                    outlined
                    :color="color"
                    v-bind="attrs"
                    v-on="on"
                 >
                    <img
                        class="v-icon--left"
                        src="/assets/images/icons/share.svg"
                        alt="Icono de compartir"
                        width="20px"
                        height="18px"
                    />
                    Compartir
                 </v-btn>
            </template>

            <v-list class="modal-share pb-10">
                <v-list-item>
                    <v-btn class="ml-auto" icon @click="dialog = false">
                        <v-icon>{{ mdiClose }}</v-icon>
                    </v-btn>
                </v-list-item>
                <v-list-item>
                    <div class="h5-txt-med col-10 pt-0 pb-0 mx-auto">
                       Comparte este curso con tus amigos y familiares
                    </div>
                </v-list-item>
                <hr class="col-10 mx-auto p-0" style="width:240px;">
                <v-list-item
                    v-for="tile in tiles"
                    :key="tile.title"
                    :id="tile.title"
                    @click="share($event)"
                    class="col-10  pt-0 pb-0 mx-auto"
                >
                    <v-list-item-avatar>
                        <v-avatar size="22px" tile>
                            <img
                                :src=tile.img
                                alt=""
                            >
                        </v-avatar>
                    </v-list-item-avatar>
                    <v-list-item-title class="h6-txt purple-title">{{ tile.title }}</v-list-item-title>
                    <hr>
                </v-list-item>
            </v-list>
        </v-dialog>
</template>

<script>
    import { mdiClose } from '@mdi/js';

    export default {
        data: () => ({
            dialog:false,
            tiles: [
                {
                    img: '/assets/images/course/icons/facebook-icon.svg',
                    title: 'Facebook'
                },
                {
                    img: '/assets/images/course/icons/whatsapp-icon.svg',
                    title: 'Whatsapp'
                },
            ],
            mdiClose
        }),
        props: ['color', 'label','course_url'],
        methods: {
            share: function(event) {
                let id=event.currentTarget.id;
                console.log(event.currentTarget.id);
                //console.log(currentUrl);
                if(id==='Facebook'){
                    window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent(JSON.parse(this.course_url)), '_blank');
                }
                else if (id==='Whatsapp'){
                    window.open('https://api.whatsapp.com/send?text='+encodeURIComponent(JSON.parse(this.course_url)), '_blank');
                }
            }
        }
    }
</script>

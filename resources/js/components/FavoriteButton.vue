<template>
    <span>
        <v-btn
            id="fav"
            class="mr-4 text-transform-btn white--text font-size-12 font-family-secondary"
            color="white"
            outlined
            v-on:click="onClick"
            :data-toggle="user_id ? null : 'modal'"
            :data-target="user_id ? null : '#Login'"
        >
            <v-icon aria-hidden="true" :color="is_fav ? '#df2935' : 'inherit'" left>
                {{ is_fav ? mdiHeart : mdiHeartOutline }}
            </v-icon>
            Favoritos
        </v-btn>
    </span>
</template>

<script>
import { mapActions, mapWritableState } from 'pinia';
import { useCourseStore } from '../store/course';
import { mdiHeart, mdiHeartOutline } from '@mdi/js';
import { GetObject } from '../axios-services';

export default {
    data: () => ({
        is_fav: false,
        isBlocked: false,
        mdiHeart,
        mdiHeartOutline
    }),

    props: ['color', 'label', 'course_id', 'user_id', 'text'],

    mounted() {
        if (this.user_id) {
            this.isFavorite();
        }
    },

    computed: {
        ...mapWritableState(useCourseStore, {
            courseStoreAddToFavoriteRequestedWithoutLogged: 'addToFavoriteRequestedWithoutLogged'
        }),

        isDisabled: function(){
            return this.isBlocked;
        },
    },

    methods: {
        ...mapActions(useCourseStore, ['addFavorite', 'deleteFavorite']),

        onClick() {
            if(this.user_id) {
                this.isBlocked = true;
                this.$emit('togglefav', !this.is_fav ? this.is_fav = true : this.is_fav = false);
                if (this.is_fav) {
                    this.addFavorite();
                } else {
                    this.deleteFavorite();
                }
            } else {
                this.courseStoreAddToFavoriteRequestedWithoutLogged = true;
                $('#Login').on('hide.bs.modal', (_e) => {
                    this.courseStoreAddToFavoriteRequestedWithoutLogged = false;
                });
                $('#Register').on('shown.bs.modal', (_e) => {
                    this.courseStoreAddToFavoriteRequestedWithoutLogged = true;
                })
            }
        },
        formObj() {
            return {}
        },
        isFavorite() {
            GetObject(`favorite/${this.course_id}`, (error, data) => {
                if (!error) {
                    this.is_fav = data
                }
            })
        }
    }
}
</script>

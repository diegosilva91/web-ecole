<template>
    <div class="mt-4">
        <label for="promotion">Disponibilidades</label>
        <v-select
            name="promotion"
            placeholder="Selecciona la fecha que más te convenga"
            v-model="selectPromotion"
            :items="options"
            item-text="title"
            item-value="id"
            dense
            outlined
            required
            :append-icon="mdiChevronDown"
            color="#793e87"
            @input="putPromotion()"
        >
        </v-select>
        <v-alert
            v-if="course.type_course !== 2 && promotion"
            class="mb-10"
            dense
            :icon="mdiInformationOutline"
            light
            type="info"
        >
            El curso elegido empieza el
            <span v-if="promotion">{{ this.getDayName(promotion.start_at, 'es-ES') }} {{
                    formatDate2(promotion.start_at.substr(0, 10))
                }}</span>
            <template v-if="price_subscription">y finaliza el
                <span v-if="promotion">{{ this.getDayName(promotion.end_at, 'es-ES') }} {{
                        formatDate2(promotion.end_at.substr(0, 10))
                    }}</span>
            </template>
            <template v-else>y tiene una duración de
                <span>{{ course.duration }} semanas</span>
            </template>
            (cada {{ this.getDayName(promotion.start_at, 'es-ES') }} a las {{ promotion.start_at.substr(11, 5) }})
        </v-alert>
    </div>
</template>

<script>
import { mapState } from 'pinia';
import { useCourseStore } from '../../store/course';
import { mdiChevronDown, mdiInformationOutline } from '@mdi/js';

export default {
    name: "CheckoutPromotion",
    props: ['promotions', 'promotion', 'course', 'price_subscription'],
    computed: {
        ...mapState(useCourseStore, {
            courseStoreUrlCheckout: 'urlCheckout',
        }),
    },
    mounted() {
        this.options = this.promotions ? this.promotions.map((element) => ({
            id: element.id,
            title: 'Inicio | ' + this.getDayName(element.start_at, 'es-ES') + ' | ' + this.formatDate(element.start_at.substr(0, 10)) + ' ' + element.start_at.substr(11, 5)
        })) : ''
        this.selectPromotion = this.promotion ? this.promotion.id : ''
    },
    methods: {
        putPromotion(_event) {
            window.location.href = this.courseStoreUrlCheckout(this.selectPromotion);
        },
        getDayName(dateStr, locale) {
            let date = new Date(dateStr.replace(/-/g, "/"))
            let string = date.toLocaleDateString(locale, {weekday: 'long'});
            return string.charAt(0).toUpperCase() + string.slice(1)
        },
        formatDate(dateStr) {
            let date = new Date(dateStr.replace(/-/g, "/"))
            let dd = date.getDate();
            let mm = date.getMonth() + 1;

            let yyyy = date.getFullYear();
            if (dd < 10) {
                dd = '0' + dd;
            }
            if (mm < 10) {
                mm = '0' + mm;
            }
            return dd + '-' + mm + '-' + yyyy;
        },

        formatDate2(date) {
            if (!date) return null

            const d = new Date(date);
            const mo = new Intl.DateTimeFormat('es', {month: 'long'}).format(d);
            const da = new Intl.DateTimeFormat('es', {day: '2-digit'}).format(d);
            return `${da} de ${mo}`
        },
    },
    data: () => ({
        mdiChevronDown,
        mdiInformationOutline,
        options: [''],
        selectPromotion: '',
    }),

}
</script>

<style scoped>
.v-alert {
    font-family: 'Poppins';
    font-size: 14px;
    color: #343a40;
}

.v-alert__content > span {
    font-weight: 600;
}

</style>

<style scoped>
.v-select.v-input--dense .v-select__selection--comma {
    color: #793e87 !important;
    font-weight: 400 !important;
}

.v-list-item__title {
    font-size: 16px !important;
    font-weight: 400 !important;
}
</style>

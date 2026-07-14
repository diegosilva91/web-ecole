<template>
    <v-container>
        <v-row>
            <v-col cols="12">
                <course-plans-mini></course-plans-mini>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import CoursePlansMini from "./CoursePlansMini.vue";
export default {
    components: {
        CoursePlansMini
    }
}
</script>
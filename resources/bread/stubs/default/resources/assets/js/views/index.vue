<template>
    <v-content>
        <bread_model_class v-if="page == 'bread_model_variable'" />
    </v-content>
</template>
<script>

import bread_model_class from './bread_model_variables.vue';

export default {
    components: {bread_model_class, /*Show*/},
    data() {
        return {
            page: 'bread_model_variables',
        };
    },
    watch: {
        '$route' (to, from) {
            this.whichPageToShow(to);
        }
    },
    mounted() {
        this.whichPageToShow(this.$route);
    },
    methods: {
        whichPageToShow(route) {
            if(route.params.id) {
                this.page = 'show'
            } else {
                this.page = 'bread_model_variables'
            }
        }
    }
}
</script>

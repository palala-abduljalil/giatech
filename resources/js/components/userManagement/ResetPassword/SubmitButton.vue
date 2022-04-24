<template>
    <button class="btn btn-outline-primary float-right">
        <button-spinner v-show="spinner" />
        <span class="fa fa-save mr-1" v-show="!spinner"></span>
        Submit
    </button>
</template>

<script>
import ButtonSpinner from "../../customComponents/ButtonSpinner";
export default {
    props: {
        showLoader: Boolean,
    },
    components: {
        ButtonSpinner,
    },
    data() {
        return {
            spinner: false,
        };
    },
    watch: {
        showLoader() {
            this.spinner = this.showLoader;
        },
    },
    mounted() {
        this.spinner = this.showLoader;
    },
};
</script>

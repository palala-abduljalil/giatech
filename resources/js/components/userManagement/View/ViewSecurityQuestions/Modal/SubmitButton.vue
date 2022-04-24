<template>
    <button class="btn btn-outline-primary float-right">
        <button-spinner v-show="spinner" />
        <span class="fa fa-save mr-1" v-show="!spinner"></span>
        Submit
    </button>
</template>

<script>
import ButtonSpinner from "../../../../customComponents/ButtonSpinner";
export default {
    components: {
        ButtonSpinner,
    },
    props: {
        showSpinner: Boolean,
    },
    data() {
        return {
            spinner: false,
        };
    },
    watch: {
        showSpinner() {
            this.spinner = this.showSpinner;
        },
    },
    mounted() {
        this.spinner = this.showSpinner;
    }
};
</script>

<style></style>

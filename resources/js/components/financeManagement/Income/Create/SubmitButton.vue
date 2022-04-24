<template>
    <button class="btn btn-primary float-right" :disabled="showSpinner">
        <button-spinner v-show="showSpinner" />
        <i class="fas fa-save mr-1" v-if="!showSpinner"> </i>
        <b>SUBMIT</b>
    </button>
</template>

<script>
import ButtonSpinner from "../../../customComponents/ButtonSpinner";
export default {
    props: {
        showSpinner: Boolean
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
        showSpinner() {
            this.spinner = this.showSpinner;
        }
    },
    mounted() {
        this.spinner = this.showSpinner;
    }
};
</script>

<style></style>

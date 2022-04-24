<template>
    <div class="text-right">
        <button
            :disabled="showSpinner"
            class="btn btn-primary waves-effect waves-light mt-2 text-white"
        >
            <button-spinner v-show="showSpinner" />
            <i class="fas fa-save mr-1" v-if="!showSpinner"></i>
            Save
        </button>
    </div>
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
        spinner() {
            this.spinner = this.showSpinner;
        }
    },
    mounted() {
        this.spinner = this.showSpinner;
    }
};
</script>

<style></style>

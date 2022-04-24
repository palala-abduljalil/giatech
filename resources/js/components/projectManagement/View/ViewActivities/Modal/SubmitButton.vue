<template>
    <button class="btn btn-outline-primary float-right" v-if="text" :disabled="showLoader">
        <button-spinner v-show="showLoader" />
        <span class="fa fa-save mr-1" v-show="!showLoader"></span>
        {{ text }}
    </button>
</template>

<script>
import ButtonSpinner from "../../../../customComponents/ButtonSpinner";
import { EventBus } from "../../../../../EventBus";

export default {
    components: {
        ButtonSpinner,
    },
    props: {
        text: String,
    },
    data() {
        return {
            showLoader: false,
        };
    },
    mounted() {
        EventBus.$on("show-modal-submit-loader", (data) => {
            this.showLoader = data;
        });
    }
};
</script>

<style></style>

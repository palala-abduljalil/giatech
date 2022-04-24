<template>
    <button class="btn btn-primary float-right" :disabled="showSpinner">
        <button-spinner v-show="showSpinner" />
        <i class="fas fa-save mr-1" v-if="!showSpinner"> </i>
        <b>UPDATE</b>
    </button>
</template>

<script>
import ButtonSpinner from "../../customComponents/ButtonSpinner";
import { EventBus } from "../../../EventBus";
export default {
    components: {
        ButtonSpinner,
    },
    data() {
        return {
            showSpinner: false,
        };
    },
    mounted() {
        EventBus.$on("show-spinner", (data) => {
            this.showSpinner = data;
        });
    },
};
</script>

<style></style>

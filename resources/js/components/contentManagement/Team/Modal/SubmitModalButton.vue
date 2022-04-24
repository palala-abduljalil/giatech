<template>
    <button class="btn btn-outline-primary float-right" :disabled="showSpinner">
        <span
            class="spinner-border spinner-border-sm mr-1"
            v-show="showSpinner"
        ></span>
        <span class="fa fa-save mr-1" v-show="!showSpinner"></span>
        {{ buttonTitle }}
    </button>
</template>

<script>
import { EventBus } from "../../../../EventBus";
export default {
    props: {
        buttonTitle: {
            type: String,
            default: "Submit",
        },
    },
    data() {
        return {
            showSpinner: false,
        };
    },
    mounted() {
        EventBus.$on("show-button-spinner", (data) => {
            this.showSpinner = data;
        });
    },
};
</script>

<style></style>

<template>
    <button class="btn btn-outline-primary float-right" v-if="text" :disabled="showSpinner">
        <button-spinner v-show="showSpinner" />
        <span class="fa fa-save mr-1" v-if="!showSpinner"></span>
        {{ text }}
    </button>
</template>

<script>
import ButtonSpinner from "../../../customComponents/ButtonSpinner";
import { EventBus } from "../../../../EventBus";
export default {
    components: {
        ButtonSpinner
    },
    props: {
        text: {
            type: String,
            default: ''
        }
    },
    data() {
        return {
            showSpinner: false,
        }
    },
    mounted() {
        EventBus.$on("show-modal-button-spinner", (data) => {
            this.showSpinner = data;
        });
    }
};
</script>

<style></style>

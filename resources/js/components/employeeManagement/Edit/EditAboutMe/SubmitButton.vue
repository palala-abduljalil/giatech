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
import { EventBus } from "../../../../EventBus";

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
        EventBus.$on("show-submit-button-spinner", (data) => {
            this.showSpinner = data;
        });
    },
};
</script>

<style></style>

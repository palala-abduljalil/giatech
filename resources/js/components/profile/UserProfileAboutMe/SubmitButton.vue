<template>
    <div class="text-right">
        <button
            :disabled="spinner"
            class="btn btn-primary waves-effect waves-light mt-2 text-white"
        >
            <button-spinner v-show="spinner" />
            <i class="fas fa-save mr-1" v-if="!spinner"></i>
            Save
        </button>
    </div>
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
            spinner: false,
        };
    },
    mounted() {
        EventBus.$on("show-spinner", (data) => {
            this.spinner = data;
        });
        EventBus.$on("hide-spinner", (data) => {
            this.spinner = data;
        });
    }
};
</script>

<style></style>

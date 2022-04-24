<template>
    <a 
        @click="handleClick"
        :disabled="showSpinner"
        class="btn btn-primary float-right"
    >
        <button-spinner v-show="showSpinner" />
        <i class="fas fa-save mr-1" v-show="!showSpinner"></i>
        <b>UPDATE</b>
    </a>
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
    methods: {
        handleClick() {
            this.$emit("onSubmit");
        },
    },
    mounted() {
        EventBus.$on("show-spinner", (data) => {
            this.showSpinner = data;
        });
    },
};
</script>

<style></style>

<template>
    <button class="btn btn-primary float-right" :disabled="processing">
        <button-spinner v-show="processing" />
        <b>SUBMIT</b>
    </button>
</template>

<script>
import ButtonSpinner from "../../customComponents/ButtonSpinner";
export default {
    props: {
        processing: {
            type: Boolean,
            default: false,
        }
    },
    components: {
        ButtonSpinner,
    },
};
</script>

<style></style>

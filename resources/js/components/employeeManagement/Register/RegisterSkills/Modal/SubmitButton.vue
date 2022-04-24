<template>
    <button class="btn btn-outline-primary float-right" @click="onSubmit">
        <span class="fa fa-save mr-1" />
        {{ text }}
    </button>
</template>

<script>
export default {
    props: {
        text: String,
    },
    methods: {
        onSubmit() {
            this.$emit("onSubmit");
        },
    },
};
</script>

<style></style>

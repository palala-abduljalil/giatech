<template>
    <a @click="handleClick" class="btn btn-primary float-left text-white">
        <i class="fas fa-plus mr-1"></i><b> ADD MEMBER</b>
    </a>
</template>

<script>
export default {
    methods: {
        handleClick() {
            this.$emit('onAdd');
        }
    }
};
</script>

<style></style>

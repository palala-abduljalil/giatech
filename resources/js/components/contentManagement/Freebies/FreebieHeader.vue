<template>
    <h1 class="card-title font-weight-bold">
        <i class="fas fa-list-alt mr-1"></i>
        Services <span class="mr-1"></span>|
        <span class="text-primary ml-1">
            {{ length }}
            Total Services
        </span>
    </h1>
</template>

<script>
export default {
    props: {
        length: {
            type: Number,
            default: 0
        }
    }
};
</script>

<style></style>

<template>
    <v-app>
        <v-card>
            <v-data-table
                :headers="headers"
                :items="items"
                class="elevation-1"
            >
            </v-data-table>
        </v-card>
    </v-app>
</template>

<script>
export default {
    props: {
        items: Array,
        headers: Array,
    },
};
</script>

<style lang="scss" scoped>
.user-block {
    float: left;

    img {
        float: left;
        height: 40px;
        width: 40px;
    }

    .name,
    .position {
        display: block;
        margin-left: 50px;
    }

    .name {
        font-size: 16px;
        margin-top: -1px;
    }

    .position {
        font-size: 13px;
        margin-top: -3px;
    }
}
</style>

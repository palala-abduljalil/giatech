<template>
    <v-app>
        <v-card>
            <v-data-table
                :headers="headers"
                :items="items"
                hide-default-footer
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
    },
    data() {
        return {
            headers: [
                { text: "No", value: "index" },
                { text: "Activity", value: "activity" },
                { text: "Date and Time", value: "dateAndTime" },
            ],  
        };
    }
};
</script>

<style></style>

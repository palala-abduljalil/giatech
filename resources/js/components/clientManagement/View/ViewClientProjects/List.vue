<template>
    <v-app>
        <v-card>
            <v-card-title>
                <v-spacer></v-spacer>
                <v-text-field
                    v-model="search"
                    append-icon="mdi-magnify"
                    label="Search"
                    single-line
                    hide-details
                ></v-text-field>
            </v-card-title>
            <v-data-table
                :headers="headers"
                :items="items"
                :search="search"
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
                { text: "Title", value: "title" },
                { text: "Category", value: "category.name" },
                { text: "Status", value: "status.name" },
            ],
            search: "",
        };
    },
};
</script>

<style></style>

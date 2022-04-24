<template>
    <v-app>
        <v-card>
            <v-card-title>
                <div class="align-end">
                    <v-btn color="primary" @click="handlePrintList">
                        <v-icon left>fas fa-print</v-icon>
                        Print List
                    </v-btn>
                </div>
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
                { text: "Project", value: "project.name" },
                { text: "Service", value: "service" },
                { text: "Category", value: "category.name" },
                { text: "Amount", value: "amount" },
                { text: "Transaction Date", value: "transactionDate" },
                { text: "Transaction Encoded", value: "created_at" },
            ],
            search: "",
        };
    },
    methods: {
        handlePrintList() {
            this.$emit("onPrintList");
        },
    },
};
</script>

<style></style>

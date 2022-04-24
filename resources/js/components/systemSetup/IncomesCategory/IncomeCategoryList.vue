<template>
    <v-app>
        <v-card>
            <v-card-title>
                <div class="align-end">
                    <v-btn color="primary" @click="handleOnAdd">
                        <v-icon left>mdi-plus-box</v-icon>
                        Add Income Category
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
                :items="lists"
                :search="search"
                class="elevation-1"
            >
                <template v-slot:item.action="{ item }">
                    <v-menu bottom left>
                        <template v-slot:activator="{ on, attrs }">
                            <v-btn icon v-bind="attrs" v-on="on">
                                <v-icon>mdi-dots-vertical</v-icon>
                            </v-btn>
                        </template>
                        <v-list>
                            <v-list-item link @click="handleOnView(item)">
                                <v-list-item-title>
                                    <v-icon small left> mdi-eye </v-icon>
                                    View
                                </v-list-item-title>
                            </v-list-item>
                            <v-list-item link @click="handleOnEdit(item)">
                                <v-list-item-title>
                                    <v-icon small left> mdi-pencil </v-icon>
                                    Edit
                                </v-list-item-title>
                            </v-list-item>
                            <v-list-item link @click="handleOnDelete(item)">
                                <v-list-item-title>
                                    <v-icon small left> mdi-delete </v-icon>
                                    Remove
                                </v-list-item-title>
                            </v-list-item>
                        </v-list>
                    </v-menu>
                </template>
            </v-data-table>
        </v-card>
    </v-app>
</template>

<script>
export default {
    props: {
        items: Array
    },
    data() {
        return {
            headers: [
                { text: "No", value: "index" },
                { text: "Income Category", value: "name" },
                { text: "Actions", value: "action", sortable: false },
            ],
            lists: [],
            search: "",
        }
    },
    methods: {
        handleOnAdd() {
            this.$emit("onAdd");
        },
        handleOnEdit(item) {
            this.$emit("onEdit", item);
        },
        handleOnDelete(item) {
            this.$emit("onDelete", item.id);
        },
        handleOnView(item) {
            this.$emit("onView", item);
        }
    },
    watch: {
        items() {
            this.lists = this.items;
        }
    },
    filters: {
        truncate: function (text, length, suffix) {
            return text ? text.substring(0, length) + suffix : '';
        },
    },
    mounted() {
        this.lists = this.items;
    }
};
</script>

<style></style>

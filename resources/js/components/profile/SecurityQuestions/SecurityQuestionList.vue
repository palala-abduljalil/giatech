<template>
    <v-app>
        <v-card>
            <v-data-table
                :headers="headers"
                :items="lists"
                :search="search"
                hide-default-footer
                class="elevation-1"
            >
                <template v-slot:item.action="{ item }">
                    <v-tooltip bottom>
                        <template v-slot:activator="{ on, attrs }">
                            <v-icon small left class="mr-2" @click="handleOnEdit(item)"
                                v-bind="attrs" v-on="on"
                            >
                                fas fa-edit
                            </v-icon>
                        </template>
                        <span>Edit Security Question</span>
                    </v-tooltip>
                </template>
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
                { text: "Question", value: "question" },
                { text: "Actions", value: "action", sortable: false },
            ],
            lists: [],
            search: "",
        };
    },
    methods: {
        handleOnEdit(item) {
            this.$emit("onEdit", item);
        },
    },
    watch: {
        items() {
            this.lists = this.items;
        },
    },
    mounted() {
        this.lists = this.items;
    },
};
</script>

<style></style>

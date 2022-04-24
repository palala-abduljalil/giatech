<template>
    <v-app>
        <v-card v-if="items.length != 0">
            <v-data-table
                :headers="headers"
                :items="items"
                hide-default-footer
                class="elevation-1"
            >
                <template v-slot:item.action="{ item }">
                    <v-tooltip bottom>
                        <template v-slot:activator="{ on, attrs }">
                            <v-icon
                                small
                                left
                                class="mr-2"
                                @click="handleEdit(item)"
                                v-bind="attrs"
                                v-on="on"
                            >
                                fas fa-edit
                            </v-icon>
                        </template>
                        <span>Edit Security Question</span>
                    </v-tooltip>
                </template>
            </v-data-table>
        </v-card>
        <v-alert v-else dense outlined type="error">
            Account has yet to be renewed by the user.
        </v-alert>
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
                { text: "Answer", value: "answer" },
                { text: "Actions", value: "action", sortable: false },
            ],
        };
    },
    methods: {
        handleEdit(item) {
            this.$emit("onEdit", item);
        }
    }
};
</script>

<style></style>

<template>
    <v-app>
        <v-card>
            <v-card-title>
                <div class="align-end">
                    <v-btn color="primary" @click="handleOnAdd">
                        <v-icon left>mdi-plus-box</v-icon>
                        Add Skill
                    </v-btn>
                </div>
                <v-spacer></v-spacer>
            </v-card-title>
            <v-data-table
                :headers="headers"
                :items="items"
                hide-default-footer
                class="elevation-1"
            >
                <template v-slot:no-data> List of Skills </template>
                <template v-slot:item.index="{ item }">
                    {{ item.index + 1 }}
                </template>
                <template v-slot:item.action="{ item }">
                    <v-menu bottom left>
                        <template v-slot:activator="{ on, attrs }">
                            <v-btn icon v-bind="attrs" v-on="on">
                                <v-icon>mdi-dots-vertical</v-icon>
                            </v-btn>
                        </template>
                        <v-list>
                            <v-list-item link @click="handleOnEdit(item)">
                                <v-list-item-title>
                                    <v-icon small left> mdi-pencil </v-icon>
                                    Edit
                                </v-list-item-title>
                            </v-list-item>
                            <v-list-item link @click="handleOnRemove(item.index)">
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
        items: Array,
        headers: Array,
    },
    methods: {
        handleOnAdd() {
            this.$emit("onAdd");
        },
        handleOnEdit(item) {
            this.$emit("onEdit", item);
        },
        handleOnRemove(index) {
            this.$emit("onRemove", index);
        },
    },
};
</script>

<style></style>

<template>
    <v-app>
        <v-card>
            <v-card-title>
                <div class="align-end">
                    <v-btn color="primary" @click="handleAdd">
                        <v-icon left>mdi-plus-box</v-icon>
                        Create Project
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
                <template v-slot:item.client.name="{ item }">
                    <div class="user-block">
                        <img
                            class="img-circle"
                            :src="`${item.client.profilePicture.url}`"
                            alt="User Image"
                        />
                        <span class="fullName">{{ item.client.name }}</span>
                        <span class="organization">{{ item.client.organization.name }}</span>
                    </div>
                </template>
                <template v-slot:item.createdBy.name="{ item }">
                    <div class="user-block" v-if="item.createdBy">
                        <img
                            class="img-circle"
                            :src="`${item.createdBy.profilePicture.url}`"
                            alt="User Image"
                        />
                        <span class="fullName">{{ item.createdBy.name }}</span>
                        <span class="organization">{{ item.createdBy.position.name }}</span>
                    </div>
                    <v-chip v-else color="blue" outlined>System Administrator</v-chip>
                </template>
                <template v-slot:item.action="{ item }">
                    <v-menu bottom left>
                        <template v-slot:activator="{ on, attrs }">
                            <v-btn icon v-bind="attrs" v-on="on">
                                <v-icon>mdi-dots-vertical</v-icon>
                            </v-btn>
                        </template>
                        <v-list>
                            <v-list-item link @click="handleView(item)">
                                <v-list-item-title>
                                    <v-icon small left> mdi-eye </v-icon>
                                    View
                                </v-list-item-title>
                            </v-list-item>
                            <v-list-item link @click="handleEdit(item)">
                                <v-list-item-title>
                                    <v-icon small left> mdi-pencil </v-icon>
                                    Edit
                                </v-list-item-title>
                            </v-list-item>
                            <v-list-item link @click="handleRemove(item)">
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
        headers: Array
    },
    data() {
        return {
            search: ""
        }
    },
    methods: {
        handleAdd() {
            this.$emit("onAdd");
        },
        handleEdit(item) {
            this.$emit("onEdit", item);
        },
        handleRemove(item) {
            this.$emit("onRemove", item);
        },
        handleView(item) {
            this.$emit("onView", item);
        }
    }
};
</script>

<style lang="scss" scope>
.user-block {
    float: left;

    img {
        float: left;
        height: 40px;
        width: 40px;
    }

    .fullName,
    .organization {
        display: block;
        margin-left: 50px;
    }

    .fullName {
        font-size: 16px;
        margin-top: -1px;
    }

    .organization {
        font-size: 13px;
        margin-top: -3px;
    }
}
</style>

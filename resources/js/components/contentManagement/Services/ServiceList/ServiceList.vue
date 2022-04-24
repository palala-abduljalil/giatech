<template>
    <v-app>
        <v-card>
            <v-card-title>
                <div class="align-end">
                    <v-btn color="primary" @click="handleOnAdd">
                        <v-icon left>mdi-plus-box</v-icon>
                        Add Service
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
                <template v-slot:item.createdBy.name="{ item }">
                    <div class="user-block" v-if="item.createdBy">
                        <img
                            class="img-circle"
                            :src="`${item.createdBy.profilePicture.url}`"
                            alt="User Image"
                        />
                        <span class="fullName">{{ item.createdBy.name }}</span>
                        <span class="position">{{ item.createdBy.position.name }}</span>
                    </div>
                    <v-chip v-else color="blue" outlined>System Administrator</v-chip>
                </template>
                <template v-slot:item.description="{ item }">
                    {{ item.description | truncate(30, "...") }}
                </template>
                <template v-slot:item.coverImage="{ item }">
                    <v-avatar size="40" class="mr-4">
                        <img :src="item.coverImage.url" />
                    </v-avatar>
                    {{ item.coverImage.fileName }}
                </template>
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
        items: Array,
        headers: Array,
    },
    data() {
        return {
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
            this.services = this.items;
        }
    },
    filters: {
        truncate: function (text, length, suffix) {
            return text ? text.substring(0, length) + suffix : '';
        },
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

    .fullName,
    .position {
        display: block;
        margin-left: 50px;
    }

    .fullName {
        font-size: 16px;
        margin-top: -1px;
    }

    .position {
        font-size: 13px;
        margin-top: -3px;
    }
}
</style>

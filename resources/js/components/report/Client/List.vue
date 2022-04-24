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
                <template v-slot:item.name="{ item }">
                    <div class="user-block">
                        <img
                            class="img-circle"
                            :src="`${item.profilePicture.url}`"
                            alt="User Image"
                        />
                        <span class="name">{{ item.name }}</span>
                    </div>
                </template>
                <template v-slot:item.action="{ item }">
                    <v-menu bottom left>
                        <template v-slot:activator="{ on, attrs }">
                            <v-btn icon v-bind="attrs" v-on="on">
                                <v-icon>mdi-dots-vertical</v-icon>
                            </v-btn>
                        </template>
                        <v-list>
                            <v-list-item link @click="handlePrintDetails(item)">
                                <v-list-item-title>
                                    <v-icon small left>
                                        fas fa-info-circle
                                    </v-icon>
                                    Generate Information
                                </v-list-item-title>
                            </v-list-item>
                            <v-list-item
                                link
                                @click="handlePrintProjectList(item)"
                            >
                                <v-list-item-title>
                                    <v-icon small left>
                                        fas fa-clipboard-list
                                    </v-icon>
                                    Generate Projects
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
    },
    data() {
        return {
            headers: [
                { text: "No", value: "index" },
                { text: "Name", value: "name" },
                { text: "Contact Number", value: "contactNumber.contactNumber" },
                { text: "E-Mail Address", value: "emailAddress.emailAddress" },
                { text: "Organization", value: "organization.name"},
                { text: "Actions", value: "action", sortable: false },
            ],
            search: "",
        };
    },
    methods: {
        handlePrintList() {
            this.$emit("onPrintList");
        },
        handlePrintDetails(item) {
            this.$emit("onPrintDetails", item);
        },
        handlePrintProjectList(item) {
            this.$emit("onPrintProjectDetails", item);
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

    .name,
    .position {
        display: block;
        margin-left: 50px;
    }

    .name {
        font-size: 16px;
        margin-top: 6px;
    }

    .position {
        font-size: 13px;
        margin-top: -3px;
    }
}
</style>

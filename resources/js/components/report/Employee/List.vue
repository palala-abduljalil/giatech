<template>
    <v-app>
        <v-card>
            <v-card-title>
                <div class="align-end mr-2">
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
                        <span class="position">{{ item.position.name }}</span>
                    </div>
                </template>
                <template v-slot:item.action="{ item }">
                    <v-tooltip bottom>
                        <template v-slot:activator="{ on, attrs }">
                            <v-icon
                                small
                                left
                                class="mr-2"
                                @click="handlePrintDetails(item)"
                                v-bind="attrs"
                                v-on="on"
                            >
                                fas fa-print
                            </v-icon>
                        </template>
                        <span>Generate Employee Details</span>
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
                { text: "Name", value: "name" },
                { text: "Employee Number", value: "employeeNumber" },
                { text: "Department", value: "department.name" },
                { text: "Date Hired", value: "dateHired" },
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
        margin-top: -1px;
    }

    .position {
        font-size: 13px;
        margin-top: -3px;
    }
}
</style>

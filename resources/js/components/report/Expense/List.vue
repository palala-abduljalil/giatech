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
                <template v-slot:item.employee.name="{ item }">
                    <div class="user-block">
                        <img
                            class="img-circle"
                            :src="`${item.employee.profilePicture.url}`"
                            alt="User Image"
                        />
                        <span class="fullName">{{ item.employee.name }}</span>
                        <span class="position">{{
                            item.employee.position.name
                        }}</span>
                    </div>
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
                { text: "Particular", value: "particular" },
                { text: "Handled By", value: "employee.name" },
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

<template>
    <div id="logsSection">
        <div id="listOfLogs" class="card">
            <div class="card-header">
                <h1 class="card-title font-weight-bold">
                    <i class="fas fa-list-alt mr-1"></i>
                    Logs <span class="mr-1"></span>|
                    <span class="text-primary ml-1">
                        {{ logs.length }}
                        Total Activity Logs
                    </span>
                </h1>
            </div>
            <div class="card-body">
                <loader v-show="loader" />
                <list
                    :items="logs"
                    :headers="headers"
                />
            </div>
        </div>
    </div>
</template>

<script>
import Loader from "../customComponents/Loader";
import List from "./List";

export default {
    props: {
        data: Array,
    },
    components: {
        Loader,
        List,
    },
    data() {
        return {
            headers: [
                { text: "No", value: "index" },
                { text: "Name", value: "causer.employee.name" },
                { text: "Employee Number", value: "causer.employee.employeeNumber" },
                { text: "Activity", value: "activity" },
                { text: "Date and Time", value: "dateAndTime" },
            ],
            loader: false,
            logs: [],
        };
    },
    watch: {
        logs() {
            // this.insertIndexes();
            this.$PageLoad.stop();
        }
    },
    methods: {
        insertIndexes() {
            this.logs = this.logs.map((items, index) => ({
                ...items,
                index: index + 1,
            }));
        },
    },
    mounted() {
        this.logs = this.data;
        this.insertIndexes();
    },
};
</script>

<style>
.card-title {
    margin-bottom: 0px;
}
</style>

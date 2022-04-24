<template>
    <div id="activityLogsSection">
        <div id="listOfActivityLogs" class="card">
            <div class="card-header">
                <h1 class="card-title font-weight-bold">
                    <i class="fas fa-list-alt mr-1"></i>
                    Activity Logs <span class="mr-1"></span
                    ><span v-if="items.length != 0"
                        >|
                        <span class="text-primary ml-1">
                            {{ items.length }}
                            Total Activity Logs
                        </span>
                    </span>
                </h1>
            </div>
            <div class="card-body">
                <list :items="items" />
            </div>
        </div>
    </div>
</template>

<script>
import List from "./List";
export default {
    components: {
        List,
    },
    props: {
        userId: Number,
    },
    data() {
        return {
            items: [],
        };
    },
    methods: {
        getActivityLogs() {
            axios
                .get(`/api/user/${this.userId}/activity-log`)
                .then((response) => {
                    this.items = response.data;
                    if (this.items.length != 0) {
                        this.insertIndexes();
                    }
                })
                .catch((error) => {
                    Toast.fire({
                        icon: "error",
                        title: "Error! " + error.message,
                    });
                    console.log("Error: ", error);
                });
        },
        insertIndexes() {
            this.items = this.items.map((items, index) => ({
                ...items,
                index: index + 1,
            }));
        },
    },
    mounted() {
        this.getActivityLogs();
    },
};
</script>

<style lang="scss" scoped>
.card-title {
    margin-bottom: 0px;
}
</style>

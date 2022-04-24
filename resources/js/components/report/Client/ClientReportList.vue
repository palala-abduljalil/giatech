<template>
    <div id="clientsSection">
        <div id="listOfClients" class="card">
            <div class="card-header">
                <h1 class="card-title font-weight-bold">
                    <i class="fas fa-list-alt mr-1"></i>
                    Clients <span class="mr-1"></span>| <span class="text-primary ml-1">
                        {{ clients.length }}
                        Total Clients
                    </span> 
                </h1>
            </div>
            <div class="card-body">
                <list 
                    :items="clients"
                    @onPrintList="printClientList"
                    @onPrintDetails="printClientDetails($event)"
                    @onPrintProjectDetails="printClientProjectList($event)"
                />
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
    data() {
        return {
            clients: [],
        };
    },
    methods: {
        printClientDetails(item) {
            window.open("/client-report-print/" + item.id,'_blank');
        },
        printClientProjectList(item) {
            window.open("/client-project-report-print/" + item.id, '_blank');
        },
        printClientList() {
            window.open("/client-report-print",'_blank');
        },
        getClients() {
            axios
                .get("/api/client")
                .then((response) => {
                    this.clients = response.data;
                    if (this.clients.length != 0) {
                        this.insertIndexes();
                    }
                })
                .catch((error) => {
                    Toast.fire({
                        icon: "error",
                        title: "Error! " + error.message,
                    });
                    console.log("Error: ", error);
                })
                .finally(() => {
                    this.$PageLoad.stop();
                });
        },
        insertIndexes() {
            this.clients = this.clients.map(
                (items, index) => ({
                    ...items,
                    index: index + 1,
                })
            );
        },
    },
    mounted() {
        this.getClients();
    },
};
</script>

<style lang="scss" scoped>
.card-title {
    margin-bottom: 0px;
}
</style>

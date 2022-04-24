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
                <loader v-show="loader" />
                <list 
                    :items="clients"
                    :headers="headers"
                    @onAdd="registerClient"
                    @onEdit="editClient"
                    @onRemove="removeClient"
                    @onView="viewClient"
                />
            </div>
        </div>
    </div>
</template>

<script>
import Loader from "../customComponents/Loader";
import List from "./List";

export default {
    components: {
        Loader,
        List,
    },
    data() {
        return {
            headers: [
                { text: "No", value: "index" },
                { text: "Name", value: "name" },
                { text: "Contact Number", value: "contactNumber.contactNumber" },
                { text: "E-Mail Address", value: "emailAddress.emailAddress" },
                { text: "Organization", value: "organization.name"},
            ],
            loader: false,
            isPageLoaded: false,
            clients: [],
        };
    },
    methods: {
        viewClient(item) {
            window.location.href = "/clients/" + item.id;
        },
        editClient(item) {
            window.location.href = "/clients/" + item.id + "/edit";
        },
        registerClient() {
            window.location.href = "/clients/create";
        },
        removeClient(item) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes",
            }).then((result) => {
                if (result.value) {
                    Swal.showLoading();
                    this.showListLoader = true;
                    this.$Progress.start();
                    axios
                        .delete(`/api/client/${item.id}`)
                        .then(() => {
                            this.getClients();
                            Toast.fire({
                                icon: "success",
                                title: "Client Succesfully removed.",
                            });
                            Swal.hideLoading();
                            this.$Progress.finish();
                        })
                        .catch((error) => {
                            Swal.hideLoading();
                            Swal.fire("Failed!", error.message, "warning");
                            this.$Progress.fail();
                        });
                }
            });
            
        },
        getClients() {
            this.loader = true;
            axios
                .get("/api/client")
                .then((response) => {
                    this.clients = response.data;
                    if (this.clients.length != 0) {
                        this.insertIndexes();
                    }
                    if (!this.isPageLoaded) {
                        if (this.$gate.isAdmin()) {
                            this.headers.push({'text': 'Created by', 'value': 'createdBy.name'});
                        }
                        this.headers.push({text: "Actions", value: "action", sortable: false});
                    }
                    this.isPageLoaded = true;
                })
                .catch((error) => {
                    Toast.fire({
                        icon: "error",
                        title: "Error! " + error.message,
                    });
                    console.log("Error: ", error);
                })
                .finally(() => {
                    this.loader = false;
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

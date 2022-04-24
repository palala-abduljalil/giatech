<template>
    <div id="usersSection">
        <div id="listOfUsers" class="card">
            <div class="card-header">
                <h1 class="card-title font-weight-bold">
                    <i class="fas fa-list-alt mr-1"></i>
                    Users <span class="mr-1"></span>| <span class="text-primary ml-1">
                        {{ users.length }}
                        Total Users
                    </span> 
                </h1>
            </div>
            <div class="card-body">
                <loader v-show="loader" />
                <list
                    :items="users"
                    :headers="headers"
                    @onCreateUser="createUser"
                    @onEdit="editUser($event)"
                    @onView="viewUser($event)"
                    @onRemove="removeUser($event)"
                    @onResetPassword="resetPassword($event)"
                    @onActivate="activate($event)"
                    @onDeactivate="deactivate($event)"
                />
            </div>
        </div>
        <reset-password :data="userID"/>
    </div>
</template>

<script>
import { EventBus } from '../../EventBus';
import Loader from "../customComponents/Loader";
import ResetPassword from "./ResetPassword/ResetPassword";
import List from "./List";

export default {
    components: {
        List,
        Loader,
        ResetPassword,
    },
    data() {
        return {
            headers: [
                { text: "No", value: "index" },
                { text: "Name", value: "employee.name" },
                { text: "Username", value: "username" },
                { text: "IsRenewed", value: "isRenewed" },
                { text: "IsActivated", value: "isActivated"},
                { text: "Role", value: "role.name"},
                { text: "Status", value: "status.description"},
            ],
            loader: false,
            users: [],
            userID: "",
            isPageLoaded: false,
        };
    },
    methods: {
        viewUser(item) {
            window.location.href = "/users/" + item.id;
        },
        editUser(item) {
            window.location.href = "/users/" + item.id + "/edit";
        },
        createUser() {
            window.location.href = "/users/create";
        },
        resetPassword(item) {
            this.userID = item.id;
            EventBus.$emit('open-modal');
            $("#modal").modal("show");
        },
        activate(item) {
            const data = new FormData();
            data.append('_method', 'POST');
            data.append('id', item.id);
            axios
                .post(`/api/user-activation`, data)
                .then((response) => {
                    this.getUsers();
                    Toast.fire({
                        icon: "success",
                        title: response.data.message,
                    });
                })
                .catch((error) => {
                    Toast.fire({
                        icon: "error",
                        title: "Error! " + error.message,
                    });
                    console.log("Error: ", error);
                });
        },
        deactivate(item) {
            const data = new FormData();
            data.append('_method', 'PUT');
            axios
                .post(`/api/user-activation/${item.id}`, data)
                .then((response) => {
                    this.getUsers();
                    Toast.fire({
                        icon: "success",
                        title: response.data.message,
                    });
                })
                .catch((error) => {
                    Toast.fire({
                        icon: "error",
                        title: "Error! " + error.message,
                    });
                    console.log("Error: ", error);
                });
        },
        removeUser(item) {
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
                        .delete(`/api/user/${item.id}`)
                        .then(() => {
                            this.getUsers();
                            Toast.fire({
                                icon: "success",
                                title: "Succesfully removed.",
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
        getUsers() {
            this.loader = true;
            axios
                .get("/api/user")
                .then((response) => {
                    this.users = response.data;
                    if (this.users.length != 0) {
                        this.insertIndexes();
                    }
                    if (!this.isPageLoaded) {
                        if (this.$gate.isAdmin()) {
                            this.headers.push({
                                text: "Created by",
                                value: "createdBy.name",
                            });
                        }
                        this.headers.push({
                            text: "Actions",
                            value: "action",
                            sortable: false,
                        });
                    }
                    this.isPageLoaded = true;
                    this.$Progress.finish();
                })
                .catch((error) => {
                    Toast.fire({
                        icon: "error",
                        title: "Error! " + error.message,
                    });
                    this.$Progress.fail();
                    console.log("Error: ", error);
                })
                .finally(() => {
                    this.loader = false;
                    this.$PageLoad.stop();
                });
        },
        insertIndexes() {
            this.users = this.users.map(
                (items, index) => ({
                    ...items,
                    index: index + 1,
                })
            );
        },
    },
    mounted() {
        this.getUsers();
    },
};
</script>

<style lang="scss" scoped>
.card-title {
    margin-bottom: 0px;
}
</style>

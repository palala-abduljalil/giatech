<template>
    <div id="activitiesSection">
        <div id="listOfActivities" class="card">
            <div class="card-header">
                <h1 class="card-title font-weight-bold">
                    <i class="fas fa-list-alt mr-1"></i>
                    Activities <span class="mr-1"></span>| <span class="text-primary ml-1">
                        {{ items.length }}
                        Total Activities
                    </span> 
                </h1>
            </div>
            <div class="card-body">
                <loader v-show="showLoader" />
                <list
                    :items="items"
                    @onAdd="openModal('', 'add')"
                    @onEdit="openModal($event, 'edit')"
                    @onView="openModal($event, 'view')"
                    @onRemove="removeActivity($event)"
                />
            </div>
            <modal
                :modalTitle="modalTitle"
                :submitButtonText="submitButton"
                :item="item"
                @onSubmit="submitForm"
            />
        </div>
    </div>
</template>

<script>
import Loader from "../../../customComponents/Loader";
import Modal from "./Modal/Modal";
import List from "./List";
import { EventBus } from "../../../../EventBus";

export default {
    props: {
        projectId: Number
    },
    components: {
        Loader,
        Modal,
        List,
    },
    data() {
        return {
            method: "",
            modalTitle: "",
            submitButton: "",
            showLoader: false,
            items: [],
            item: {},
        };
    },
    methods: {
        openModal(item = "", action) {
            this.formReset();
            $("#activityModal").modal("show");
            if (action == "add") {
                this.method = "POST";
                this.modalTitle = "Add New Activity";
                this.submitButton = "Submit";
            } else if (action == "edit") {
                this.method = "PUT";
                this.modalTitle = "Edit Activity";
                this.submitButton = "Update";
                this.item = Object.assign({}, item);
            } else {
                this.modalTitle = "Activity Information";
                this.submitButton = "";
                this.item = Object.assign({}, item);
            }
        },
        submitForm() {
            if (this.method == "POST") {
                this.addActivity();
            } else {
                this.updateActivity();
            }
        },
        addActivity() {
            this.$validator.validate().then((valid) => {
                if (valid) {
                    this.$Progress.start();
                    this.showLoader = true;
                    EventBus.$emit("show-modal-submit-loader", true);
                    axios
                        .post(
                            `/api/project/${this.projectId}/activity`,
                            this.item
                        )
                        .then((response) => {
                            this.getActivities();
                            Toast.fire({
                                icon: "success",
                                title: response.data.message,
                            });
                            EventBus.$emit("show-modal-submit-loader", false);
                            $("#activityModal").modal("hide");
                            this.showLoader = false;
                            this.$Progress.finish();
                        })
                        .catch((error) => {
                            if (error.response.data.errors) {
                                var entries = Object.entries(
                                    error.response.data.errors
                                );
                                this.errors.clear();
                                entries.forEach(function (item, index) {
                                    this.errors.add({
                                        field: item[0],
                                        msg: item[1][0],
                                    });
                                }, this);
                            } else {
                                Toast.fire({
                                    icon: "error",
                                    title: "Error! " + error.message,
                                });
                                console.log("Error: ", error);
                            }
                            EventBus.$emit("show-modal-submit-loader", false);
                            this.showLoader = false;
                            this.$Progress.fail();
                        });
                }
            });
        },
        updateActivity() {
            this.$validator.validate().then((valid) => {
                if (valid) {
                    this.$Progress.start();
                    this.showLoader = true;
                    EventBus.$emit("show-modal-submit-loader", true);
                    axios
                        .put(
                            `/api/project/${this.projectId}/activity/${this.item.id}`,
                            this.item
                        )
                        .then((response) => {
                            this.getActivities();
                            Toast.fire({
                                icon: "success",
                                title: response.data.message,
                            });
                            EventBus.$emit("show-modal-submit-loader", false);
                            $("#activityModal").modal("hide");
                            this.showLoader = false;
                            this.$Progress.finish();
                        })
                        .catch((error) => {
                            if (error.response.data.errors) {
                                var entries = Object.entries(
                                    error.response.data.errors
                                );
                                this.errors.clear();
                                entries.forEach(function (item, index) {
                                    this.errors.add({
                                        field: item[0],
                                        msg: item[1][0],
                                    });
                                }, this);
                            } else {
                                Toast.fire({
                                    icon: "error",
                                    title: "Error! " + error.message,
                                });
                                console.log("Error: ", error);
                            }
                            EventBus.$emit("show-modal-submit-loader", false);
                            this.showLoader = false;
                            this.$Progress.fail();
                        });
                }
            });
        },
        removeActivity(id) {
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
                    this.showLoader = true;
                    this.$Progress.start();
                    axios
                        .delete(
                            `/api/project/${this.projectId}/activity/${id}`
                        )
                        .then(() => {
                            this.getActivities();
                            Toast.fire({
                                icon: "success",
                                title: "Successfully removed.",
                            });
                            Swal.hideLoading();
                            this.showLoader = false;
                            this.$Progress.finish();
                        })
                        .catch((error) => {
                            Swal.hideLoading();
                            Swal.fire("Failed!", error.message, "warning");
                            this.showLoader = false;
                            this.$Progress.fail();
                        });
                }
            });
        },
        formReset() {
            this.item = Object.assign(
                {},
                {
                    description: "",
                    project_id: this.projectId
                }
            );
            this.$validator.reset();
        },
        getActivities() {
            axios
                .get(`/api/project/${this.projectId}/activity`)
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
            this.items = this.items.map(
                (items, index) => ({
                    ...items,
                    index: index + 1,
                    project_id: this.projectId,
                })
            );
        },
    },
    mounted() {
        this.getActivities();
    },
};
</script>

<style lang="scss" scoped>
.card-title {
    margin-bottom: 0px;
}
</style>

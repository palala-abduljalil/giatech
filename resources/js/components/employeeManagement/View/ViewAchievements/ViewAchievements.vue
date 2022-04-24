<template>
    <div id="achievementsSection">
        <div id="listOfAchievements" class="card">
            <div class="card-header">
                <h1 class="card-title font-weight-bold">
                    <i class="fas fa-list-alt mr-1"></i>
                    Achievements <span class="mr-1"></span>|
                    <span class="text-primary ml-1">
                        {{ items.length }}
                        Total Achievements
                    </span>
                </h1>
            </div>
            <div class="card-body">
                <loader v-show="showLoader" />
                <list
                    :items="items"
                    :headers="headers"
                    @onAdd="openModal('', 'add')"
                    @onEdit="openModal($event, 'edit')"
                    @onView="openModal($event, 'view')"
                    @onRemove="removeAchievement($event)"
                />
            </div>
        </div>
        <modal
            :modalTitle="modalTitle"
            :submitButtonText="submitButton"
            :item="item"
            @onSubmit="submitForm"
        />
    </div>
</template>

<script>
import Loader from "../../../customComponents/Loader";
import List from "./List";
import Modal from "./Modal/Modal";
import { EventBus } from "../../../../EventBus";

export default {
    props: {
        employeeId: Number,
    },
    components: {
        Loader,
        List,
        Modal,
    },
    data() {
        return {
            headers: [
                { text: "No", value: "index" },
                { text: "Description", value: "description" },
                { text: "Actions", value: "action", sortable: false },
            ],
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
            $("#modal").modal("show");
            if (action == "add") {
                this.method = "POST";
                this.modalTitle = "Add New Achievement";
                this.submitButton = "Submit";
            } else if (action == "edit") {
                this.method = "PUT";
                this.modalTitle = "Edit Achievement";
                this.submitButton = "Update";
                this.item = Object.assign({}, item);
            } else {
                this.modalTitle = "Achievement Information";
                this.submitButton = "";
                this.item = Object.assign({}, item);
            }
        },
        submitForm() {
            if (this.method == "POST") {
                this.addAchievement();
            } else {
                this.updateAchievement();
            }
        },
        addAchievement() {
            this.$validator.validate().then((valid) => {
                if (valid) {
                    this.$Progress.start();
                    this.showLoader = true;
                    EventBus.$emit("show-modal-submit-loader", true);
                    axios
                        .post(
                            `/api/employee/${this.employeeId}/achievement`,
                            this.item
                        )
                        .then((response) => {
                            this.getAchievements();
                            Toast.fire({
                                icon: "success",
                                title: response.data.message,
                            });
                            EventBus.$emit("show-modal-submit-loader", false);
                            $("#modal").modal("hide");
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
        updateAchievement() {
            this.$validator.validate().then((valid) => {
                if (valid) {
                    this.$Progress.start();
                    this.showLoader = true;
                    EventBus.$emit("show-modal-submit-loader", true);
                    axios
                        .put(
                            `/api/employee/${this.employeeId}/achievement/${this.item.id}`,
                            this.item
                        )
                        .then((response) => {
                            this.getAchievements();
                            Toast.fire({
                                icon: "success",
                                title: response.data.message,
                            });
                            EventBus.$emit("show-modal-submit-loader", false);
                            $("#modal").modal("hide");
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
        removeAchievement(id) {
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
                            `/api/employee/${this.employeeId}/achievement/${id}`
                        )
                        .then(() => {
                            this.getAchievements();
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
                    employee_id: this.employeeId,
                }
            );
            this.$validator.reset();
        },
        getAchievements() {
            axios
                .get(`/api/employee/${this.employeeId}/achievement`)
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
                employee_id: this.employeeId,
            }));
        },
    },
    mounted() {
        this.getAchievements();
    },
};
</script>

<style lang="scss" scoped>
.card-title {
    margin-bottom: 0px;
}
</style>

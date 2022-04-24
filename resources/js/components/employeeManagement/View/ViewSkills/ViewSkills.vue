<template>
    <div id="skillsSection">
        <div id="listOfSkills" class="card">
            <div class="card-header">
                <h1 class="card-title font-weight-bold">
                    <i class="fas fa-list-alt mr-1"></i>
                    Skills <span class="mr-1"></span>| <span class="text-primary ml-1">
                        {{ items.length }}
                        Total Skills
                    </span> 
                </h1>
            </div>
            <div class="card-body">
                <loader v-show="showLoader" />
                <list
                    :items="items"
                    :headers="headers"
                    @onAdd="openModal('', 'add')"
                    @onEdit="openModal($event,'edit')"
                    @onView="openModal($event,'view')"
                    @onRemove="removeSkill($event)"
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
            $("#skillModal").modal("show");
            if (action == "add") {
                this.method = "POST";
                this.modalTitle = "Add New Skill";
                this.submitButton = "Submit";
            } else if (action == "edit") {
                this.method = "PUT";
                this.modalTitle = "Edit Skill";
                this.submitButton = "Update";
                this.item = Object.assign({}, item);
            } else {
                this.modalTitle = "Skill Information";
                this.submitButton = "";
                this.item = Object.assign({}, item);
            }
        },
        submitForm() {
            if (this.method == "POST") {
                this.addSkill();
            } else {
                this.updateSkill();
            }
        },
        addSkill() {
            this.$validator.validate().then((valid) => {
                if (true) {
                    this.$Progress.start();
                    this.showLoader = true;
                    EventBus.$emit("show-modal-submit-loader", true);
                    axios
                        .post(`/api/employee/${this.employeeId}/skill`, this.item)
                        .then((response) => {
                            this.getSkills();
                            Toast.fire({
                                icon: "success",
                                title: response.data.message,
                            });
                            EventBus.$emit("show-modal-submit-loader", false);
                            $("#skillModal").modal("hide");
                            this.showLoader = false;
                            this.$Progress.finish();
                        })
                        .catch((error) => {
                            if (error.response.status == 422) {
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
        updateSkill() {
            this.$validator.validate().then((valid) => {
                if (valid) {
                    this.$Progress.start();
                    this.showLoader = true;
                    EventBus.$emit("show-modal-submit-loader", true);
                    axios
                        .put(
                            `/api/employee/${this.employeeId}/skill/${this.item.id}`,
                            this.item
                        )
                        .then((response) => {
                            this.getSkills();
                            Toast.fire({
                                icon: "success",
                                title: response.data.message,
                            });
                            EventBus.$emit("show-modal-submit-loader", false);
                            $("#skillModal").modal("hide");
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
        removeSkill(id) {
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
                            `/api/employee/${this.employeeId}/skill/${id}`
                        )
                        .then(() => {
                            this.getSkills();
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
            this.item = Object.assign({}, {
                    description: "",
                    employee_id: this.employeeId,
            });
            this.$validator.reset();
        },
        getSkills() {
            axios
                .get(`/api/employee/${this.employeeId}/skill`)
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
                    employee_id: this.employeeId,
                })
            );
        },
    },
    mounted() {
        this.getSkills();
    },
};
</script>

<style lang="scss" scoped>
.card-title {
    margin-bottom: 0px;
}
.modal-open {
    overflow: hidden;
    padding-right: 0 !important;
}
</style>

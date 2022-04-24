<template>
    <div id="freebiesSection" v-if="isPageLoad">
        <freebie-description :text="freebies.freebieDescription" />
        <div id="listOffreebies" class="card">
            <div class="card-header">
                <freebie-header :length="freebies.freebies.length" />
            </div>
            <div class="card-body">
                <loader v-show="showListLoader" />
                <freebie-list
                    :items="freebies.freebies"
                    :headers="headers"
                    @onAdd="openModal($event, 'add')"
                    @onEdit="openModal($event, 'edit')"
                    @onDelete="removeFreebie($event, 'delete')"
                    @onView="openModal($event, 'view')"
                />
            </div>
        </div>
        <modal
            ref="modal"
            :modalTitle="modalTitle"
            :submitButtonText="submitButton"
            :data="freebie"
            :action="method"
            @onSubmit="submitForm"
        />
    </div>
</template>

<script>
import Loader from "../../customComponents/Loader";
import { EventBus } from "../../../EventBus";
import FreebieDescription from "./FreebieDescription/FreebieDescription";
import FreebieList from "./FreebieList/FreebieList";
import FreebieHeader from "./FreebieHeader";
import Modal from "./Modal/Modal";

export default {
    components: {
        Loader,
        FreebieDescription,
        FreebieList,
        FreebieHeader,
        Modal,
    },
    data() {
        return {
            headers: [
                { text: "No", value: "index" },
                { text: "Name", value: "name" },
                { text: "Cover Image", value: "coverImage", sortable: false },
            ],
            isPageLoad: false,
            method: "",
            modalTitle: "",
            submitButton: "",
            showListLoader: "",
            freebies: [],
            freebie: {},
        };
    },
    methods: {
        openModal(item = "", action) {
            $("#freebieModal").modal("show");
            this.formReset();
            if (action == "add") {
                this.method = "POST";
                this.modalTitle = "Add New Freebie";
                this.submitButton = "Submit";
            } else if (action == "edit") {
                this.method = "PUT";
                this.modalTitle = "Edit Freebie";
                this.submitButton = "Update";
                this.setFormAttributes(item);
            } else {
                this.modalTitle = "Freebie Information";
                this.submitButton = "";
                this.setFormAttributes(item);
            }
        },
        setFormAttributes(item) {
            EventBus.$emit(
                "set-file-input",
                item.coverImage.url,
                item.coverImage.fileName
            );
            this.freebie = Object.assign({}, item);
        },
        submitForm() {
            if (this.method == "POST") {
                this.addFreebie();
            } else {
                this.updateFreebie();
            }
        },
        addFreebie() {
            this.$validator.validateAll("form2").then((valid) => {
                if (valid) {
                    var form = new FormData(this.$refs.modal.$refs.myForm);
                    this.$Progress.start();
                    EventBus.$emit("show-modal-button-spinner", true);
                    this.showListLoader = true;
                    axios
                        .post("/api/company/freebie", form)
                        .then((response) => {
                            this.getFreebies();
                            Toast.fire({
                                icon: "success",
                                title: response.data.message,
                            });
                            $("#freebieModal").modal("hide");
                            this.showListLoader = false;
                            EventBus.$emit("show-modal-button-spinner", false);
                            this.$Progress.finish();
                        })
                        .catch((error) => {
                            if (error.response.data.errors) {
                                var entries = Object.entries(
                                    error.response.data.errors
                                );
                                this.errors.clear("form2");
                                entries.forEach(function (item, index) {
                                    this.errors.add({
                                        field: item[0],
                                        msg: item[1][0],
                                        scope: "form2",
                                    });
                                }, this);
                            } else {
                                Toast.fire({
                                    icon: "error",
                                    title: "Error! " + error.message,
                                });
                                console.log("Error: ", error);
                            }
                            EventBus.$emit("show-modal-button-spinner", false);
                            this.showListLoader = false;
                            this.$Progress.fail();
                        });
                } else {
                    this.$refs.imageUploader.$refs.inputReference.value = "";
                }
            });
        },
        updateFreebie() {
            this.$validator.validateAll("form2").then((valid) => {
                if (valid) {
                    var form = new FormData(this.$refs.modal.$refs.myForm);
                    this.$Progress.start();
                    EventBus.$emit("show-modal-button-spinner", true);
                    this.showListLoader = true;
                    axios
                        .post(`/api/company/freebie/${this.freebie.id}`, form)
                        .then((response) => {
                            this.getFreebies();
                            Toast.fire({
                                icon: "success",
                                title: response.data.message,
                            });
                            $("#freebieModal").modal("hide");
                            EventBus.$emit("show-modal-button-spinner", false);
                            this.showListLoader = false;
                            this.$Progress.finish();
                        })
                        .catch((error) => {
                            if (error.response.data.errors) {
                                var entries = Object.entries(
                                    error.response.data.errors
                                );
                                this.errors.clear("form2");
                                entries.forEach(function (item, index) {
                                    this.errors.add({
                                        field: item[0],
                                        msg: item[1][0],
                                        scope: "form2",
                                    });
                                }, this);
                            } else {
                                Toast.fire({
                                    icon: "error",
                                    title: "Error! " + error.message,
                                });
                                console.log("Error: ", error);
                            }
                            EventBus.$emit("show-modal-button-spinner", false);
                            this.showListLoader = false;
                            this.$Progress.fail();
                        });
                }
            });
        },
        removeFreebie(id) {
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
                        .delete("/api/company/freebie/" + id)
                        .then(() => {
                            Toast.fire({
                                icon: "success",
                                title: "Freebie has been removed.",
                            });
                            Swal.hideLoading();
                            this.getFreebies();
                            this.showListLoader = false;
                            this.$Progress.finish();
                        })
                        .catch((error) => {
                            Swal.hideLoading();
                            Swal.fire("Failed!", error.message, "warning");
                            this.showListLoader = false;
                            this.$Progress.fail();
                        });
                }
            });
        },
        formReset() {
            EventBus.$emit(
                "set-file-input",
                "/images/default-placeholder.png",
                "Choose an Image"
            );
            this.freebie = Object.assign({}, {});
            this.$validator.reset();
        },
        getFreebies() {
            axios
                .get("/api/company/freebie")
                .then((response) => {
                    this.freebies = response.data;
                    if (this.freebies.freebies.length != 0) {
                        this.insertIndexes();
                    }
                    if (!this.isPageLoad) {
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
                    this.isPageLoad = true;
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
            this.freebies.freebies = this.freebies.freebies.map(
                (items, index) => ({
                    ...items,
                    index: index + 1,
                })
            );
        },
    },
    mounted() {
        this.getFreebies();
    },
};
</script>

<style lang="scss" scoped>
.card-title {
    margin-bottom: 0px;
}
</style>

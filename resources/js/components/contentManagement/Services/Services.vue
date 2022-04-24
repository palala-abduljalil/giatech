<template>
    <div id="servicesSection" v-if="isPageLoad">
        <service-description :text="services.serviceDescription" />
        <div id="listOfServices" class="card">
            <div class="card-header">
                <service-header :length="services.services.length" />
            </div>
            <div class="card-body">
                <loader v-show="showListLoader" />
                <service-list
                    :items="services.services"
                    :headers="headers"
                    @onAdd="openModal($event, 'add')"
                    @onEdit="openModal($event, 'edit')"
                    @onDelete="removeService($event, 'delete')"
                    @onView="openModal($event, 'view')"
                />
            </div>
        </div>
        <modal
            ref="modal"
            :modalTitle="modalTitle"
            :submitButtonText="submitButton"
            :data="service"
            :action="method"
            @onSubmit="submitForm"
        />
    </div>
</template>

<script>
import Loader from "../../customComponents/Loader";
import { EventBus } from "../../../EventBus";
import ServiceDescription from "./ServiceDescription/ServiceDescription";
import ServiceList from "./ServiceList/ServiceList";
import ServiceHeader from "./ServiceHeader";
import Modal from "./Modal/Modal";

export default {
    components: {
        Loader,
        ServiceDescription,
        ServiceList,
        ServiceHeader,
        Modal,
    },
    data() {
        return {
            headers: [
                { text: "No", value: "index" },
                { text: "Title", value: "title" },
                { text: "Description", value: "description" },
                { text: "Cover Image", value: "coverImage", sortable: false },
            ],
            isPageLoad: false,
            method: "",
            modalTitle: "",
            submitButton: "",
            showListLoader: "",
            services: [],
            service: {},
        };
    },
    methods: {
        openModal(item = "", action) {
            $("#serviceModal").modal("show");
            this.formReset();
            if (action == "add") {
                this.method = "POST";
                this.modalTitle = "Add New Service";
                this.submitButton = "Submit";
            } else if (action == "edit") {
                this.method = "PUT";
                this.modalTitle = "Edit Service";
                this.submitButton = "Update";
                this.setFormAttributes(item);
            } else {
                this.modalTitle = "Service Information";
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
            this.service = Object.assign({}, item);
        },
        submitForm() {
            if (this.method == "POST") {
                this.addService();
            } else {
                this.updateService();
            }
        },
        addService() {
            this.$validator.validateAll("form2").then((valid) => {
                if (valid) {
                    var form = new FormData(this.$refs.modal.$refs.myForm);
                    this.$Progress.start();
                    EventBus.$emit("show-modal-button-spinner", true);
                    this.showListLoader = true;
                    axios
                        .post("/api/company/service", form)
                        .then((response) => {
                            this.getServices();
                            Toast.fire({
                                icon: "success",
                                title: response.data.message,
                            });
                            $("#serviceModal").modal("hide");
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
                }
            });
        },
        updateService() {
            this.$validator.validateAll("form2").then((valid) => {
                if (valid) {
                    var form = new FormData(this.$refs.modal.$refs.myForm);
                    this.$Progress.start();
                    EventBus.$emit("show-modal-button-spinner", true);
                    this.showListLoader = true;
                    axios
                        .post(`/api/company/service/${this.service.id}`, form)
                        .then((response) => {
                            this.getServices();
                            Toast.fire({
                                icon: "success",
                                title: response.data.message,
                            });
                            $("#serviceModal").modal("hide");
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
        removeService(id) {
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
                        .delete("/api/company/service/" + id)
                        .then(() => {
                            Toast.fire({
                                icon: "success",
                                title: "Service has been removed",
                            });
                            Swal.hideLoading();
                            this.getServices();
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
            this.service = Object.assign({}, {});
            this.$validator.reset();
        },
        getServices() {
            axios
                .get("/api/company/service")
                .then((response) => {
                    this.services = response.data;
                    if (this.services.services.length != 0) {
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
            this.services.services = this.services.services.map(
                (items, index) => ({
                    ...items,
                    index: index + 1,
                })
            );
        },
    },
    mounted() {
        this.getServices();
    },
};
</script>

<style lang="scss" scoped>
.card-title {
    margin-bottom: 0px;
}
</style>

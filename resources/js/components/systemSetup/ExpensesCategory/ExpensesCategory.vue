<template>
    <div v-if="isPageLoad">
        <div class="card">
            <div class="card-header">
                <expense-category-header 
                    :length="list.length"
                    :text="`${this.TITLE}(s)`"
                />
            </div>
            <div class="card-body">
                <loader v-show="showListLoader" />
                <expense-category-list :items="list"
                    @onAdd="openModal($event, 'add')"
                    @onEdit="openModal($event, 'edit')"
                    @onDelete="removeItem($event, 'delete')"
                    @onView="openModal($event, 'view')"
                />
            </div>
        </div>
        <modal 
            ref="modal"
            :modalTitle="modalTitle"
            :submitButtonText="submitButton"
            :data="item"
            :action="method"
            @onSubmit="submitForm"
        />
    </div>
</template>

<script>
import Loader from "../../customComponents/Loader";
import { EventBus } from "../../../EventBus";
import ExpenseCategoryList from "./ExpenseCategoryList";
import ExpenseCategoryHeader from "./ExpensesCategoryHeader";
import Modal from "./Modal/Modal";

export default {
    components: {
        Loader,
        ExpenseCategoryList,
        ExpenseCategoryHeader,
        Modal,
    },
    data() {
        return {
            TITLE: 'Expense Category',
            MODAL_ID: '#expenseCategoryModal',
            AXIOS_URL: 'api/expense-category',
            isPageLoad: false,
            method: "",
            modalTitle: "",
            submitButton: "",
            showListLoader: "",
            list: [],
            item: {},
        };
    },
    methods: {
        openModal(item = '', action) {
            $(this.MODAL_ID).modal("show");
            this.formReset();
            if (action == "add") {
                this.method = "POST";
                this.modalTitle = "Add New " + this.TITLE;
                this.submitButton = "Submit";
            } else if (action == "edit") {
                this.method = "PUT";
                this.modalTitle = "Edit " + this.TITLE;
                this.submitButton = "Update";
                this.setFormAttributes(item);
            } else {
                this.modalTitle = this.TITLE + " Information";
                this.submitButton = "";
                this.setFormAttributes(item);
            }
        },
        setFormAttributes(item) {
            this.item = Object.assign({}, item);
        },
        submitForm() {
            if (this.method == "POST") {
                this.addItem();
            } else {
                this.updateItem();
            }
        },
        addItem() {
            this.$validator.validateAll('form').then((valid) => {
                if (valid) {
                    var form = new FormData(this.$refs.modal.$refs.myForm);
                    this.$Progress.start();
                    EventBus.$emit("show-modal-button-spinner", true);
                    this.showListLoader = true;
                    axios
                        .post("/" + this.AXIOS_URL, form)
                        .then((response) => {
                            this.getItems();
                            Toast.fire({
                                icon: "success",
                                title: response.data.message,
                            });
                            $(this.MODAL_ID).modal("hide");
                            this.showListLoader = false;
                            EventBus.$emit("show-modal-button-spinner", false);
                            this.$Progress.finish();
                        })
                        .catch((error) => {
                            if (error.response.data.errors) {
                                var entries = Object.entries(
                                    error.response.data.errors
                                );
                                this.errors.clear("form");
                                entries.forEach(function (item, index) {
                                    this.errors.add({
                                        field: item[0],
                                        msg: item[1][0],
                                        scope: 'form'
                                    });
                                }, this);
                            }
                            Toast.fire({
                                icon: "error",
                                title: "Error! " + error.message,
                            });
                            console.log("Error: ", error);
                            EventBus.$emit("show-modal-button-spinner", false);
                            this.showListLoader = false;
                            this.$Progress.fail();
                        });
                }
            });
        },
        updateItem() {
            this.$validator.validateAll("form").then((valid) => {
                if (valid) {
                    var form = new FormData(this.$refs.modal.$refs.myForm); 
                    this.$Progress.start();
                    EventBus.$emit("show-modal-button-spinner", true);
                    this.showListLoader = true;
                    axios
                        .post(`/${this.AXIOS_URL}/${this.item.id}`, form)
                        .then((response) => {
                            this.getItems();
                            Toast.fire({
                                icon: "success",
                                title: response.data.message,
                            });
                            $(this.MODAL_ID).modal("hide");
                            EventBus.$emit("show-modal-button-spinner", false);
                            this.showListLoader = false;
                            this.$Progress.finish();
                        })
                        .catch((error) => {
                            if (error.response.data.errors) {
                                var entries = Object.entries(
                                    error.response.data.errors
                                );
                                this.errors.clear("form");
                                entries.forEach(function (item, index) {
                                    this.errors.add({
                                        field: item[0],
                                        msg: item[1][0],
                                        scope: 'form'
                                    });
                                }, this);
                            }
                            Toast.fire({
                                icon: "error",
                                title: "Error! " + error.message,
                            });
                            console.log("Error: ", error);
                            EventBus.$emit("show-modal-button-spinner", false);
                            this.showListLoader = false;
                            this.$Progress.fail();
                        });
                }
            });
        },
        removeItem(id) {
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
                        .delete(`/${this.AXIOS_URL}/${id}`)
                        .then(() => {
                            Toast.fire({
                                icon: "success",
                                title: this.TITLE + " has been successfully removed.",
                            });
                            Swal.hideLoading();
                            this.getItems();
                            this.showListLoader = false;
                            this.$Progress.finish();
                        })
                        .catch((data) => {
                            Swal.hideLoading();
                            Swal.fire("Failed!", data.message, "warning");
                            this.showListLoader = false;
                            this.$Progress.fail();
                        });
                }
            });
        },
        formReset() {
            this.item = Object.assign({}, {});
            this.$validator.reset();
        },
        getItems() {
            axios
                .get(`/${this.AXIOS_URL}`)
                .then((response) => {
                    this.list = response.data;
                    if (this.list.length != 0) {
                        this.insertIndexes();
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
            this.list = this.list.map(
                (items, index) => ({
                    ...items,
                    index: index + 1,
                })
            );
        },
    },
    mounted() {
        this.getItems();
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

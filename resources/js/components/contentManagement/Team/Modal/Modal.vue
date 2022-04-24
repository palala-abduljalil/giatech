<template>
    <div class="modal fade" id="modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ modalTitle }}</h4>
                    <x-modal-button />
                </div>
                <form @submit.prevent="submitForm" ref="modalForm">
                    <div class="modal-body">
                        <div class="form-group">
                            <employee-select
                                label="Employee"
                                name="employee"
                                :labelAsterisk="true"
                                rules="required"
                                errorMessage="employee"
                                errorLabel="Employee"
                                url="/api/employee"
                                v-model="employee"
                            />
                        </div>
                        <div class="form-group">
                            <text-field
                                label="LinkedIn Link"
                                name="link"
                                :labelAsterisk="true"
                                rules="required|max:255|url"
                                placeholder="Enter LinkedIn Account: "
                                errorMessage="link"
                                errorLabel="LinkedIn Link"
                                v-model="form.linkedInLink"
                            />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <close-modal-button />
                        <submit-modal-button :buttonTitle="buttonTitle" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import EmployeeSelect from "./EmployeeSelect";
import TextField from "../../../customComponents/TextField";
import XModalButton from "./XModalButton";
import SubmitModalButton from "./SubmitModalButton";
import CloseModalButton from "./CloseModalButton";
import { EventBus } from "../../../../EventBus";

export default {
    props: {
        modalTitle: {
            type: String,
            default: "",
        },
        buttonTitle: {
            type: String,
            default: "Submit",
        },
        action: String,
        item: Object,
    },
    components: {
        EmployeeSelect,
        TextField,
        XModalButton,
        SubmitModalButton,
        CloseModalButton,
    },
    data() {
        return {
            form: {
                id: "",
                employee: {
                    id: "",
                },
                linkedInLink: "",
            },
            employee: "",
        };
    },
    methods: {
        addStakeholder() {
            this.$validator.validate().then((valid) => {
                if (valid) {
                    var form = new FormData(this.$refs.modalForm);
                    form.append("company_id", 1);
                    this.$Progress.start();
                    EventBus.$emit("show-button-spinner", true);
                    axios
                        .post("/api/company/stakeholder", form)
                        .then((response) => {
                            EventBus.$emit("refresh-stakeholder-list");
                            Toast.fire({
                                icon: "success",
                                title: response.data.message,
                            });
                            EventBus.$emit("show-button-spinner", false);
                            $("#modal").modal("hide");
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
                            EventBus.$emit("show-button-spinner", false);
                            this.$Progress.fail();
                        });
                }
            });
        },
        updateStakeholder() {
            this.$validator.validateAll().then((valid) => {
                if (valid) {
                    var form = new FormData(this.$refs.modalForm);
                    const companyID = 1;
                    form.append("id", this.form.id);
                    form.append("company_id", companyID);
                    form.append("_method", "PUT");
                    EventBus.$emit("show-button-spinner", true);
                    this.$Progress.start();
                    axios
                        .post(`/api/company/stakeholder/${this.form.id}`, form)
                        .then((response) => {
                            EventBus.$emit("refresh-stakeholder-list");
                            Toast.fire({
                                icon: "success",
                                title: response.data.message,
                            });
                            EventBus.$emit("show-button-spinner", false);
                            $("#modal").modal("hide");
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
                            EventBus.$emit("show-button-spinner", false);
                            this.$Progress.fail();
                        });
                }
            });
        },
        submitForm() {
            if (this.action == "POST") {
                this.addStakeholder();
            } else {
                this.updateStakeholder();
            }
        },
    },
    mounted() {
        EventBus.$on("reset-form", (data) => {
            this.form = data;
            this.employee = data.employee.id;
            this.$validator.reset();
        });
    },
};
</script>

<style></style>

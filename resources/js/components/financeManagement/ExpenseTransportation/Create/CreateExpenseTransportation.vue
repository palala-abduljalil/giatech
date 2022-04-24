<template>
    <div class="card">
        <form data-vv-scope="form" @submit.prevent="submitForm">
            <div class="card-body">
                <loader v-show="showSpinner" />
                <div class="row">
                    <div class="col-md-12 pb-0">
                        <h5 class="font-weight-normal">Expense Details</h5>
                        <hr />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 pt-0">
                        <div class="form-group">
                            <text-field
                                label="Start Point"
                                name="startPoint"
                                :labelAsterisk="true"
                                rules="required|max:255"
                                errorMessage="form.startPoint"
                                errorLabel="Start Point"
                                v-model="form.startPoint"
                            />
                        </div>
                    </div>
                    <div class="col-md-4 pt-0">
                        <div class="form-group">
                            <text-field
                                label="End Point"
                                name="endPoint"
                                :labelAsterisk="true"
                                rules="required|max:255"
                                errorMessage="form.endPoint"
                                errorLabel="End Point"
                                v-model="form.endPoint"
                            />
                        </div>
                    </div>
                    <div class="col-md-4 pt-0">
                        <div class="form-group">
                            <custom-select
                                label="Handled By"
                                name="employee"
                                :labelAsterisk="true"
                                rules="required"
                                errorMessage="form.employee"
                                errorLabel="Handled By"
                                url="/api/employee"
                                :others="false"
                                v-model="form.employee"
                            />
                        </div>
                    </div>
                </div>
                <div class="row pt-3">
                    <div class="col-md-4 pt-0">
                        <div class="form-group">
                            <label for="" class="required"
                                >Transaction Date</label
                            >
                            <VueDatePicker
                                v-model="form.transactionDate"
                                format="DD-MM-YYYY"
                                name="transactionDate"
                                v-validate="'required'"
                                fullscreen-mobile
                                validate
                            />
                            <div
                                class="date-invalid-feedback"
                                v-if="errors.has('form.transactionDate')"
                            >
                                {{ errors.first("form.transactionDate") }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 pt-0">
                        <div class="form-group">
                            <text-field
                                label="Purpose"
                                name="purpose"
                                :labelAsterisk="true"
                                rules="required|max:255"
                                errorMessage="form.purpose"
                                errorLabel="Purpose"
                                v-model="form.purpose"
                            />
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <submit-button :showSpinner="showSpinner" />
            </div>
        </form>
    </div>
</template>

<script>
import TextField from "../../../customComponents/TextField";
import CustomSelect from "../../../customComponents/CustomSelect";
import { VueDatePicker } from "@mathieustan/vue-datepicker";
import Loader from "../../../customComponents/Loader";
import SubmitButton from "./SubmitButton";
import "@mathieustan/vue-datepicker/dist/vue-datepicker.min.css";

export default {
    components: {
        TextField,
        CustomSelect,
        VueDatePicker,
        Loader,
        SubmitButton,
    },
    data() {
        return {
            showSpinner: false,
            form: {
                startPoint: "",
                endPoint: "",
                employee: "",
                transactionDate: new Date(),
                purpose: "",
            },
        };
    },
    methods: {
        async validate() {
            return this.$validator.validateAll("form").then((valid) => {
                return valid;
            });
        },
        async submitForm() {
            var isValid = await this.validate();
            if (isValid) {
                this.$Progress.start();
                this.showSpinner = true;
                axios
                    .post("/api/expense-transportation", this.form)
                    .then((response) => {
                        this.showSpinner = false;
                        this.$Progress.finish();
                        Toast.fire({
                            icon: "success",
                            title:
                                response.data.message +
                                "\nPage redirecting ... ",
                        });
                        this.$Progress.finish();
                        window.location.href = "/expenses-transportation/";
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
                                    scope: "form",
                                });
                            }, this);

                            Swal.fire({
                                icon: "error",
                                title: "Form Submission Failed!",
                                text: "Please check your inputs.",
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Error!",
                                text: error.message,
                            });
                            console.log("Error: ", error);
                        }
                        this.showSpinner = false;
                        this.$Progress.fail();
                    });
            }
        },
    },
    created() {
        setTimeout(() => this.$PageLoad.stop(), 2000);
    },
};
</script>

<style scoped>
.card-title {
    margin-bottom: 0px;
    font-size: 20px;
}
.required:after {
    content: " *";
    color: red;
}

.date-invalid-feedback {
    width: 100%;
    margin-top: 0.25rem;
    font-size: 100%;
    color: #dc3545;
}
</style>

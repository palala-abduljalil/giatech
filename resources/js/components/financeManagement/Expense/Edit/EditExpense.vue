<template>
    <div class="card" v-if="isLoad">
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
                                label="Particular"
                                name="particular"
                                :labelAsterisk="true"
                                rules="required|max:500"
                                errorMessage="form.particular"
                                errorLabel="Particular"
                                v-model="form.particular"
                            />
                        </div>
                    </div>
                    <div class="col-md-4 pt-0">
                        <div class="form-group">
                            <custom-select
                                label="Category"
                                name="category"
                                :labelAsterisk="true"
                                rules="required"
                                errorMessage="form.category"
                                errorLabel="Category"
                                url="/api/expense-category"
                                :others="false"
                                v-model="form.category"
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
                                label="Amount"
                                name="amount"
                                :labelAsterisk="true"
                                :rules="{ required: true, regex: /^[0-9]+(\.[0-9]{1,2})?$/ }"
                                errorMessage="form.amount"
                                errorLabel="Amount"
                                v-model="form.amount"
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
import Loader from "../../../customComponents/Loader";
import SubmitButton from "./SubmitButton";
import TextField from "../../../customComponents/TextField";
import CustomSelect from "../../../customComponents/CustomSelect";
import { VueDatePicker } from "@mathieustan/vue-datepicker";
import "@mathieustan/vue-datepicker/dist/vue-datepicker.min.css";
export default {
    props: {
        expenseId: Number,
    },
    components: {
        TextField,
        CustomSelect,
        VueDatePicker,
        Loader,
        SubmitButton,
    },
    data() {
        return {
            isLoad: false,
            showSpinner: false,
            form: {},
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
                    .put(`/api/expense/${this.expenseId}`, this.form)
                    .then((response) => {
                        this.showSpinner = false;
                        this.$Progress.finish();
                        Toast.fire({
                            icon: "success",
                            title: response.data.message,
                        });
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
        getExpense() {
            axios
                .get(`/api/expense/${this.expenseId}`)
                .then((response) => {
                    this.form = {
                        particular: response.data.particular,
                        category: response.data.category.id,
                        employee: response.data.employee.id,
                        transactionDate: response.data.transactionDate,
                        amount: response.data.amount,
                    };
                    this.isLoad = true;
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
    },
    mounted() {
        this.getExpense();
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

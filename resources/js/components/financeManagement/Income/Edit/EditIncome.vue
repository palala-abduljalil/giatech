<template>
    <div class="card" v-if="isLoad">
        <form data-vv-scope="form" @submit.prevent="submitForm">
            <div class="card-body">
                <loader v-show="showSpinner" />
                <div class="row">
                    <div class="col-md-12 pb-0">
                        <h5 class="font-weight-normal">Income Details</h5>
                        <hr />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 pt-0">
                        <div class="form-group">
                            <custom-select
                                label="Project"
                                name="project"
                                :labelAsterisk="true"
                                rules="required"
                                errorMessage="form.project"
                                errorLabel="Project"
                                url="/api/project"
                                :others="false"
                                v-model="form.project"
                            />
                        </div>
                    </div>
                    <div class="col-md-4 pt-0">
                        <div class="form-group">
                            <text-field
                                label="Service"
                                name="service"
                                :labelAsterisk="true"
                                rules="required|max:500"
                                errorMessage="form.service"
                                errorLabel="Service"
                                v-model="form.service"
                            />
                        </div>
                    </div>
                    <div class="col-md-4 pt-0">
                        <div class="form-group">
                            <text-field
                                label="Amount"
                                name="amount"
                                :labelAsterisk="true"
                                :rules="{
                                    required: true,
                                    regex: /^[0-9]+(\.[0-9]{1,2})?$/,
                                }"
                                errorMessage="form.amount"
                                errorLabel="Amount"
                                v-model="form.amount"
                            />
                        </div>
                    </div>
                </div>
                <div class="row pt-3">
                    <div class="col-md-4 pt-0">
                        <div class="form-group">
                            <label for="" class="required">
                                Transaction Date
                            </label>
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
                            <custom-select
                                label="Category"
                                name="category"
                                :labelAsterisk="true"
                                rules="required"
                                errorMessage="form.category"
                                errorLabel="Category"
                                url="/api/income-category"
                                :others="false"
                                v-model="form.category"
                            />
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="text-right">
                    <submit-button :showSpinner="showSpinner" />
                </div>
            </div>
        </form>
    </div>
</template>

<script>
import TextField from "../../../customComponents/TextField";
import CustomSelect from "../../../customComponents/CustomSelect";
import { VueDatePicker } from "@mathieustan/vue-datepicker";
import "@mathieustan/vue-datepicker/dist/vue-datepicker.min.css";
import Loader from "../../../customComponents/Loader";
import SubmitButton from "./SubmitButton";

export default {
    props: {
        incomeId: Number,
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
            form: {
                service: "",
                amount: 0,
                transactionDate: new Date(),
                project: 0,
                category: 0,
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
                    .put(`/api/income/${this.incomeId}`, this.form)
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
        getIncome() {
            axios
                .get(`/api/income/${this.incomeId}`)
                .then((response) => {
                    this.form = {
                        service: response.data.service,
                        category: response.data.category.id,
                        project: response.data.project.id,
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
        this.getIncome();
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

<template>
    <div class="card">
        <form data-vv-scope="form" @submit.prevent="submitForm">
            <div class="card-body">
                <loader v-show="showSpinner" />
                <div class="row">
                    <div class="col-md-12 pb-0">
                        <h5 class="font-weight-normal">
                            <i class="fas fa-file-invoice mr-2"></i>
                            Project Details
                        </h5>
                        <hr />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 pt-0">
                        <div class="form-group">
                            <text-field
                                label="Title"
                                name="title"
                                :labelAsterisk="true"
                                rules="required|max:500"
                                errorMessage="form.title"
                                errorLabel="Title"
                                v-model="form.title"
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
                                url="/api/project-category"
                                :others="false"
                                v-model="form.category"
                            />
                        </div>
                    </div>
                    <div class="col-md-4 pt-0">
                        <div class="form-group">
                            <custom-select
                                label="Client"
                                name="client"
                                :labelAsterisk="true"
                                rules="required"
                                errorMessage="form.client"
                                errorLabel="Client"
                                url="/api/client"
                                :others="false"
                                v-model="form.client"
                            />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 pt-0">
                        <text-area
                            label="Description"
                            name="description"
                            rows="5"
                            v-model="form.description"
                            rules="required|max:5000"
                            errorMessage="form.description"
                            errorLabel="Description"
                        />
                    </div>
                </div>
                <div class="row pt-3">
                    <div class="col-md-4 pt-0">
                        <div class="form-group">
                            <label for="" class="required">Duration</label>
                            <VueDatePicker
                                v-model="date"
                                format="DD-MM-YYYY"
                                :min-date="minDate"
                                :max-date="maxDate"
                                name="startDate"
                                v-validate="'required'"
                                data-vv-as="Duration"
                                range
                                range-header-text="Start Date %d End Date %d"
                                range-input-text="%d to %d"
                                fullscreen-mobile
                                validate
                            />
                            <div
                                class="date-invalid-feedback"
                                v-if="errors.has('form.startDate')"
                            >
                                {{ errors.first("form.startDate") }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 pt-0">
                        <div class="form-group">
                            <text-field
                                label="Total Contract Price"
                                name="totalContractPrice"
                                :labelAsterisk="true"
                                :rules="{ required: true, regex: /^[0-9]+(\.[0-9]{1,2})?$/ }"
                                errorMessage="form.totalContractPrice"
                                errorLabel="Total Contract Price"
                                v-model="form.totalContractPrice"
                            />
                        </div>
                    </div>
                    <div class="col-md-4 pt-0">
                        <div class="form-group">
                            <custom-select
                                label="Status"
                                name="status"
                                :labelAsterisk="true"
                                rules="required"
                                errorMessage="form.status"
                                errorLabel="Status"
                                url="/api/project-status"
                                :others="false"
                                v-model="form.status"
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
import TextField from "../../customComponents/TextField";
import Loader from "../../customComponents/Loader";
import TextArea from "../../customComponents/TextArea";
import CustomSelect from "../../customComponents/CustomSelect";
import { VueDatePicker } from "@mathieustan/vue-datepicker";
import "@mathieustan/vue-datepicker/dist/vue-datepicker.min.css";
import SubmitButton from "./SubmitButton";

export default {
    props: {
        projectId: Number,
    },
    components: {
        TextField,
        CustomSelect,
        Loader,
        VueDatePicker,
        TextArea,
        SubmitButton,
    },
    data() {
        return {
            date: {},
            currentDate: new Date(),
            form: {},
            isLoad: false,
            showSpinner: false,
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
                Object.assign(this.form, {
                    startDate: this.date.start,
                    endDate: this.date.end,
                });
                axios
                    .put(`/api/project/${this.projectId}`, this.form)
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
        getProject() {
            axios
                .get(`/api/project/${this.projectId}`)
                .then((response) => {
                    this.form = {
                        title: response.data.title,
                        category: response.data.category.id,
                        client: response.data.client.id,
                        description: response.data.description,
                        totalContractPrice: response.data.totalContractPrice,
                        status: response.data.status.id,
                    };
                    this.date = {
                        start: response.data.startDate,
                        end: response.data.endDate,
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
    computed: {
        minDate() {
            return new Date(
                this.currentDate.getFullYear() - 1,
                this.currentDate.getMonth(),
                this.currentDate.getDate()
            );
        },
        maxDate() {
            return new Date(
                this.currentDate.getFullYear() + 1,
                this.currentDate.getMonth(),
                this.currentDate.getDate()
            );
        },
    },
    mounted() {
        this.getProject();
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

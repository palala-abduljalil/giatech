<template>
    <div class="card">
        <form @submit.prevent="submitForm">
            <div class="card-body">
                <loader v-show="showSpinner" />
                <div class="row">
                    <div class="col-md-12">
                        <h5 class="font-weight-bold">
                            <i class="fas fa-id-card mr-2"></i>
                            Contact Details
                        </h5>
                        <hr />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 pt-0">
                        <div class="form-group">
                            <text-field
                                label="Email Address"
                                name="emailAddress"
                                rules="email|max:255"
                                errorMessage="emailAddress"
                                errorLabel="Email Address"
                                v-model="company.emailAddress"
                            />
                        </div>
                    </div>
                    <div class="col-md-6 pt-0">
                        <div class="form-group">
                            <text-field
                                label="Website Address"
                                name="websiteAddress"
                                rules="url|max:255"
                                errorMessage="websiteAddress"
                                errorLabel="Website Address"
                                v-model="company.websiteAddress"
                            />
                        </div>
                    </div>
                    <div class="col-md-6 pt-0">
                        <div class="form-group">
                            <text-field
                                label="LandLine Number"
                                name="landlineNumber"
                                rules="min:5|max:255"
                                errorMessage="landlineNumber"
                                errorLabel="Landline Number"
                                v-model="company.landlineNumber"
                            />
                        </div>
                    </div>
                    <div class="col-md-6 pt-0">
                        <div class="form-group">
                            <text-field
                                label="Mobile Number"
                                name="mobileNumber"
                                rules="min:5|max:255"
                                errorMessage="mobileNumber"
                                errorLabel="Mobile Number"
                                v-model="company.mobileNumber"
                            />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h5 class="font-weight-bold">
                            <i class="fas fa-globe-africa mr-2"></i>
                            Social Links
                        </h5>
                        <hr />
                    </div>
                </div>
                <div class="row">
                    <div
                        class="col-md-6 pt-0"
                        v-for="(item, index) in company.socialMediaAccounts"
                        :key="item.id"
                    >
                        <div class="form-group">
                            <text-field
                                :label="capitalize(item.name)"
                                :name="`socialMediaAccounts.${index}.link`"
                                rules="min:5|max:255|url"
                                :errorMessage="`socialMediaAccounts.${index}.link`"
                                errorLabel="Link"
                                v-model="item.link"
                            />
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <submit-button />
            </div>
        </form>
    </div>
</template>

<script>
import Loader from "../../customComponents/Loader";
import TextField from "../../customComponents/TextField";
import SubmitButton from "./SubmitButton";
import { EventBus } from "../../../EventBus";

export default {
    components: {
        Loader,
        TextField,
        SubmitButton,
    },
    data() {
        return {
            company: {},
            showSpinner: false,
        };
    },
    methods: {
        submitForm() {
            this.$validator.validate().then((valid) => {
                if (valid) {
                    const companyID = 1;
                    this.$Progress.start();
                    this.showSpinner = true;
                    EventBus.$emit("show-spinner", true);
                    axios
                        .put(`/api/company/${companyID}`, this.company)
                        .then((response) => {
                            Toast.fire({
                                icon: "success",
                                title: response.data.message,
                            });
                            this.showSpinner = false;
                            EventBus.$emit("show-spinner", false);
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
                            EventBus.$emit("show-spinner", false);
                            this.showSpinner = false;
                            this.$Progress.fail();
                        });
                }
            });
        },
        getCompany() {
            this.showSpinner = true;
            axios
                .get("/api/company")
                .then((response) => {
                    this.company = response.data;
                })
                .catch((error) => {
                    Toast.fire({
                        icon: "error",
                        title: "Error! " + error.message,
                    });
                    console.log("Error: ", error);
                })
                .finally(() => {
                    this.showSpinner = false;
                    this.$PageLoad.stop();
                });
        },
        capitalize(value) {
            if (!value) return "";
            value = value.toString();
            return value.charAt(0).toUpperCase() + value.slice(1);
        },
    },
    mounted() {
        this.getCompany();
    },
};
</script>

<style scoped>
.card-title {
    margin-bottom: 0px;
}
</style>

<template>
    <div class="card">
        <form ref="employeeForm" data-vv-scope="form">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <h5 class="text-center">Select Profile Image</h5>
                        <avatar-file-input
                            name="image"
                            rules="mimes:image/jpeg,image/jpg,image/png|size:2048"
                            errorMessage="form.image"
                            errorLabel="Image"
                        />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 pb-0">
                        <h5 class="font-weight-normal">
                            <i class="fas fa-user-circle mr-2"></i>
                            Personal Information
                        </h5>
                        <hr />
                    </div>
                </div>
                <div class="row">
                    <input type="hidden" name="_method" value="POST" />
                    <div class="col-md-3 pt-0">
                        <div class="form-group">
                            <text-field
                                label="First Name"
                                name="firstName"
                                :labelAsterisk="true"
                                rules="required"
                                errorMessage="form.firstName"
                                errorLabel="First Name"
                            />
                        </div>
                    </div>
                    <div class="col-md-3 pt-0">
                        <div class="form-group">
                            <text-field
                                label="Middle Name"
                                name="middleName"
                                :labelAsterisk="true"
                                rules="required|max:255"
                                errorMessage="form.middleName"
                                errorLabel="Middle Name"
                            />
                        </div>
                    </div>
                    <div class="col-md-3 pt-0">
                        <div class="form-group">
                            <text-field
                                label="Last Name"
                                name="lastName"
                                :labelAsterisk="true"
                                rules="required|max:255"
                                errorMessage="form.lastName"
                                errorLabel="Last Name"
                            />
                        </div>
                    </div>
                    <div class="col-md-3 pt-0">
                        <div class="form-group">
                            <text-field
                                label="Suffix"
                                name="suffix"
                                rules="max:255"
                                errorMessage="form.suffix"
                                errorLabel="Suffix"
                            />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 pb-0">
                        <h5 class="font-weight-normal">
                            <i class="fas fa-map-marker mr-2"></i>
                            Address
                        </h5>
                        <hr />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 pt-0">
                        <div class="form-group">
                            <text-field
                                label="House No. "
                                name="houseNumber"
                                rules="max:255"
                                errorMessage="form.houseNumber"
                                errorLabel="House No."
                            />
                        </div>
                    </div>
                    <div class="col-md-9 pt-0">
                        <div class="form-group">
                            <text-field
                                label="Street Name"
                                name="streetName"
                                :labelAsterisk="true"
                                rules="required|max:500"
                                errorMessage="form.streetName"
                                errorLabel="Street Name"
                            />
                        </div>
                    </div>
                    <div class="col-md-3 pt-0">
                        <div class="form-group">
                            <address-select
                                label="Region"
                                name="region"
                                rules="required"
                                errorMessage="form.region"
                                errorLabel="Region"
                                :labelAsterisk="true"
                                :items="regions"
                                :loadData="false"
                                @change="handleProvince"
                            />
                        </div>
                    </div>
                    <div class="col-md-3 pt-0">
                        <div class="form-group">
                            <address-select
                                label="Province"
                                name="province"
                                rules="required"
                                errorMessage="form.province"
                                errorLabel="Province"
                                :labelAsterisk="true"
                                :items="provinces"
                                :loadData="loadProvince"
                                :disabled="disableProvince"
                                @change="handleCity"
                            />
                        </div>
                    </div>
                    <div class="col-md-3 pt-0">
                        <div class="form-group">
                            <address-select
                                ref="city"
                                label="City"
                                name="city"
                                rules="required"
                                errorMessage="form.city"
                                errorLabel="City"
                                :labelAsterisk="true"
                                :items="cities"
                                :loadData="loadCity"
                                :disabled="disableCity"
                                @change="handleBarangay"
                            />
                        </div>
                    </div>
                    <div class="col-md-3 pt-0">
                        <div class="form-group">
                            <address-select
                                ref="barangay"
                                label="Barangay"
                                name="barangay"
                                rules="required"
                                errorMessage="form.barangay"
                                errorLabel="Barangay"
                                :labelAsterisk="true"
                                :items="barangays"
                                :loadData="loadBarangay"
                                :disabled="disableBarangay"
                            />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h5 class="font-weight-normal">
                            <i class="fa fa-address-card mr-2"></i>
                            Contact Details
                        </h5>
                        <hr />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 pt-0">
                        <div class="form-group">
                            <text-field
                                label="Business E-Mail "
                                name="businessEmail"
                                :labelAsterisk="true"
                                rules="required|email|max:255"
                                errorMessage="form.businessEmail"
                                errorLabel="Business E-Mail"
                                v-model="businessEmail"
                            />
                        </div>
                    </div>
                    <div class="col-md-4 pt-0">
                        <div class="form-group">
                            <text-field
                                label="Alternate E-Mail "
                                name="alternateEmail"
                                :rules="{ is_not: businessEmail, email: true, max:255 }"
                                errorMessage="form.alternateEmail"
                                errorLabel="Alternate E-Mail"
                            />
                        </div>
                    </div>
                    <div class="col-md-4 pt-0">
                        <div class="form-group">
                            <text-field
                                label="Contact Number "
                                name="contactNumber"
                                :labelAsterisk="true"
                                rules="required|max:255"
                                errorMessage="form.contactNumber"
                                errorLabel="Contact Number"
                            />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h5 class="font-weight-normal">
                            <i class="fas fa-briefcase mr-2"></i>
                            Job
                        </h5>
                        <hr />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 pt-0">
                        <div class="form-group">
                            <custom-select
                                label="Position"
                                name="position"
                                :labelAsterisk="true"
                                rules="required"
                                errorMessage="form.position"
                                errorLabel="Position"
                                url="/api/position"
                                :others="false"
                            />
                        </div>
                    </div>
                    <div class="col-md-4 pt-0">
                        <div class="form-group">
                            <custom-select
                                label="Department"
                                name="department"
                                :labelAsterisk="true"
                                rules="required"
                                errorMessage="form.department"
                                errorLabel="Department"
                                url="/api/department"
                                :others="false"
                            />
                        </div>
                    </div>
                    <div class="col-md-4 pt-0">
                        <div class="form-group">
                            <custom-select
                                label="Status"
                                name="employeeStatus"
                                :labelAsterisk="true"
                                rules="required"
                                errorMessage="form.employeeStatus"
                                errorLabel="Status"
                                url="/api/employee-status"
                                :others="false"
                            />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h5 class="font-weight-normal">
                            <i class="fas fa-graduation-cap mr-2"></i>
                            Education Attainment
                        </h5>
                        <hr />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 pt-0">
                        <div class="form-group">
                            <custom-select
                                label="Degree"
                                name="degree"
                                :labelAsterisk="true"
                                rules="required"
                                errorMessage="form.degree"
                                errorLabel="Degree"
                                url="/api/degree"
                                :others="false"
                            />
                        </div>
                    </div>
                    <div class="col-md-4 pt-0">
                        <div class="form-group">
                            <text-field
                                label="Year Graduated "
                                name="yearGraduated"
                                :labelAsterisk="true"
                                rules="required|numeric"
                                errorMessage="form.yearGraduated"
                                errorLabel="Year Graduated"
                            />
                        </div>
                    </div>
                    <div class="col-md-4 pt-0">
                        <div class="form-group">
                            <custom-select
                                label="School"
                                name="school"
                                :labelAsterisk="true"
                                rules="required"
                                errorMessage="form.school"
                                errorLabel="School"
                                url="/api/school"
                                :others="true"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
import TextField from "../../customComponents/TextField";
import AddressSelect from "../../customComponents/AddressSelect";
import CustomSelect from "../../customComponents/CustomSelect";
import AvatarFileInput from "../../customComponents/AvatarFileInput";

import { regions,provinces, cities, barangays } from "select-philippines-address";
import { EventBus } from "../../../EventBus";

export default {
    components: {
        TextField,
        AddressSelect,
        CustomSelect,
        AvatarFileInput,
    },
    data() {
        return {
            regions: [],
            provinces: [],
            cities: [],
            barangays: [],
            achievements: [],
            skills: [],
            attachments: [],
            loadProvince: false,
            disableProvince: true,
            loadCity: false,
            disableCity: true,
            loadBarangay: false,
            disableBarangay: true,
            businessEmail: "",
        };
    },
    methods: {
        handleProvince(e) {
            if (!this.disableProvince) {
                this.disableProvince = true;
            }
            this.loadProvince = true;
            var code = this.regions[e.target.options.selectedIndex - 1];
            provinces(code.id).then((response) => {
                this.provinces = response;
                this.loadProvince = false;
                this.disableCity = true;
                this.disableBarangay = true;
                this.disableProvince = false;
            });
        },
        handleCity(e) {
            if (!this.disableCity) {
                this.disableCity = true;
            }
            this.loadCity = true;
            var code = this.provinces[e.target.options.selectedIndex - 1];
            cities(code.id).then((response) => {
                this.cities = response;
                this.loadCity = false;
                this.disableBarangay = true;
                this.disableCity = false;
            });
        },
        handleBarangay(e) {
            if (!this.disableBarangay) {
                this.disableBarangay = true;
            }
            this.loadBarangay = true;
            var code = this.cities[e.target.options.selectedIndex - 1];
            barangays(code.id).then((response) => {
                this.barangays = response;
                this.loadBarangay = false;
                this.disableBarangay = false;
            });
        },
        async validate() {
            return this.$validator.validateAll("form").then((valid) => {
                return valid;
            });
        },
        async validateForm() {
            return await this.validate();
        },
        async submitForm() {
            var isValid = await this.validate();
            
            if (isValid) {
                this.$Progress.start();
                var data = new FormData(this.$refs.employeeForm);
                var skillKeys = Object.keys(this.skills);
                skillKeys.forEach((key, index) => {
                    data.append(
                        `skills[${index}][description]`,
                        this.skills[key].description
                    );
                });
                var achievementKeys = Object.keys(this.achievements);
                achievementKeys.forEach((key, index) => {
                    data.append(
                        `achievements[${index}][description]`,
                        this.achievements[key].description
                    );
                });
                var attachmentKeys = Object.keys(this.attachments);
                attachmentKeys.forEach((key, index) => {
                    data.append(`files[]`, this.attachments[key]);
                });
                const config = {
                    headers: { "Content-Type": "multipart/form-data" },
                };
                axios
                    .post("/api/employee", data, config)
                    .then((response) => {
                        Toast.fire({
                            icon: "success",
                            title:
                                response.data.message +
                                "\nPage redirecting ... ",
                        });
                        this.$Progress.finish();
                        window.location.href = "/employees/";
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
                        }
                        Swal.fire({
                            icon: "error",
                            title: "Form Submission Failed!",
                            text: "Please check your inputs.",
                        });
                        console.log("Error: ", error);
                        this.$Progress.fail();
                    });
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Form Submission Failed!",
                    text: "Please check your inputs.",
                });
            }
        },
        initValidatorMessage() {
            this.$validator.localize("en", {
                custom: {
                    alternateEmail: {
                        is_not: "Alternate E-Mail must be different Business E-Mail",
                    },
                },
            });
        },
    },
    mounted() {
        this.initValidatorMessage();
        regions().then((region) => {
            this.regions = region;
        });
        EventBus.$on("get-skills", (data) => {
            this.skills = data;
        });
        EventBus.$on("get-achievements", (data) => {
            this.achievements = data;
        });
        EventBus.$on("get-attachments", (data) => {
            this.attachments = data;
        });
    },
};
</script>

<style scoped>
.card-title {
    margin-bottom: 0px;
    font-size: 20px;
}
</style>

<template>
    <form
        v-if="isLoad"
        ref="employeeForm"
        data-vv-scope="form"
        @submit.prevent="submitForm"
    >
        <input type="hidden" name="_method" value="PUT" />
        <h5 class="mb-3 text-uppercase bg-light p-2">
            <i class="fas fa-user-circle mr-1"></i> Personal Info
        </h5>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <text-field
                        label="First Name"
                        name="firstName"
                        :labelAsterisk="true"
                        rules="required"
                        errorMessage="form.firstName"
                        errorLabel="First Name"
                        v-model="employee.firstName"
                    />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <text-field
                        label="Middle Name"
                        name="middleName"
                        :labelAsterisk="true"
                        rules="required|max:255"
                        errorMessage="form.middleName"
                        errorLabel="Middle Name"
                        v-model="employee.middleName"
                    />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <text-field
                        label="Last Name"
                        name="lastName"
                        :labelAsterisk="true"
                        rules="required|max:255"
                        errorMessage="form.lastName"
                        errorLabel="Last Name"
                        v-model="employee.lastName"
                    />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <text-field
                        label="Suffix"
                        name="suffix"
                        rules="max:255"
                        errorMessage="form.suffix"
                        errorLabel="Suffix"
                        v-model="employee.suffix"
                    />
                </div>
            </div>
        </div>
        <h5 class="mb-3 text-uppercase bg-light p-2">
            <i class="fas fa-map-marker-alt mr-1"></i> Address
        </h5>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <text-field
                        label="House No."
                        name="houseNumber"
                        rules="max:255"
                        errorMessage="form.houseNumber"
                        errorLabel="House No."
                        v-model="employee.address.houseNumber"
                    />
                </div>
            </div>
            <div class="col-md-8">
                <div class="form-group">
                    <text-field
                        label="Street Name"
                        name="streetName"
                        :labelAsterisk="true"
                        rules="required|max:500"
                        errorMessage="form.streetName"
                        errorLabel="Street Name"
                        v-model="employee.address.streetName"
                    />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <address-select
                        ref="region"
                        label="Region"
                        name="region"
                        rules="required"
                        errorMessage="form.region"
                        errorLabel="Region"
                        :labelAsterisk="true"
                        :items="regions"
                        :loadData="false"
                        v-model="employee.address.region"
                        @change="handleProvince"
                    />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <address-select
                        ref="province"
                        label="Province"
                        name="province"
                        rules="required"
                        errorMessage="form.province"
                        errorLabel="Province"
                        :labelAsterisk="true"
                        :items="provinces"
                        :loadData="loadProvince"
                        :disabled="disableProvince"
                        v-model="employee.address.province"
                        @change="handleCity"
                    />
                </div>
            </div>
            <div class="col-md-6">
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
                        v-model="employee.address.city"
                        @change="handleBarangay"
                    />
                </div>
            </div>
            <div class="col-md-6">
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
                        v-model="employee.address.barangay"
                    />
                </div>
            </div>
        </div>
        <h5 class="mb-3 text-uppercase bg-light p-2">
            <i class="fas fa-address-card mr-1"></i> Contact Details
        </h5>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <text-field
                        label="Business E-Mail"
                        name="businessEmail"
                        :labelAsterisk="true"
                        rules="required|email|max:255"
                        errorMessage="form.businessEmail"
                        errorLabel="Business E-Mail"
                        v-model="employee.emailAddress.businessEmail"
                    />
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <text-field
                        label="Alternate E-Mail"
                        name="alternateEmail"
                        rules="email|max:255"
                        errorMessage="form.alternateEmail"
                        errorLabel="Alternate E-Mail"
                        v-model="employee.emailAddress.alternateEmail"
                    />
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <text-field
                        label="Contact No."
                        name="contactNumber"
                        :labelAsterisk="true"
                        rules="required|max:255"
                        errorMessage="form.contactNumber"
                        errorLabel="Contact Number"
                        v-model="employee.contactNumber.contactNumber"
                    />
                </div>
            </div>
        </div>
        <h5 class="mb-3 text-uppercase bg-light p-2">
            <i class="fas fa-briefcase mr-1"></i> Job
        </h5>
        <div class="row">
            <div class="col-md-4">
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
                        v-model="employee.position.id"
                    />
                </div>
            </div>
            <div class="col-md-4">
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
                        v-model="employee.department.id"
                    />
                </div>
            </div>
            <div class="col-md-4">
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
                        v-model="employee.status.id"
                    />
                </div>
            </div>
        </div>

        <h5 class="mb-3 text-uppercase bg-light p-2">
            <i class="fas fa-graduation-cap mr-1"></i> Education Attainment
        </h5>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <custom-select
                        label="Degree"
                        name="degree"
                        :labelAsterisk="true"
                        rules="required"
                        errorMessage="form.degree"
                        errorLabel="Degree"
                        url="/api/degree"
                        v-model="employee.degree.id"
                    />
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <text-field
                        label="Year Graduated"
                        name="yearGraduated"
                        :labelAsterisk="true"
                        rules="required|numeric"
                        errorMessage="form.yearGraduated"
                        errorLabel="Year Graduated"
                        v-model="employee.yearGraduated"
                    />
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <custom-select
                        label="School"
                        name="school"
                        :labelAsterisk="true"
                        rules="required"
                        errorMessage="form.school"
                        errorLabel="School"
                        url="/api/school"
                        :others="false"
                        v-model="employee.school.id"
                    />
                </div>
            </div>
        </div>
        <submit-button />
    </form>
</template>

<script>
import TextField from "../../../customComponents/TextField";
import SubmitButton from "./SubmitButton";
import AddressSelect from "../../../customComponents/AddressSelect";
import CustomSelect from "../../../customComponents/CustomSelect";
import { EventBus } from "../../../../EventBus";

import {
    regions,
    provinces,
    cities,
    barangays,
} from "select-philippines-address";

export default {
    props: {
        data: Object,
    },
    components: {
        TextField,
        CustomSelect,
        AddressSelect,
        SubmitButton,
    },
    data() {
        return {
            isLoad: false,
            showSpinner: true,
            employee: {},
            regions: [],
            provinces: [],
            cities: [],
            barangays: [],
            loadProvince: false,
            disableProvince: false,
            loadCity: false,
            disableCity: false,
            loadBarangay: false,
            disableBarangay: false,
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
                this.disableProvince = false;
                this.disableCity = true;
                this.disableBarangay = true;
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
                this.disableCity = false;
                this.disableBarangay = true;
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
        async getAddress() {
            try {
                this.regions = await regions();
                var region = this.regions.find(
                    (element) => element.name == this.employee.address.region
                );
                this.provinces = await provinces(region.id);
                var province = this.provinces.find(
                    (element) => element.name == this.employee.address.province
                );
                this.cities = await cities(province.id);
                var city = this.cities.find(
                    (element) => element.name == this.employee.address.city
                );
                this.barangays = await barangays(city.id);
            } catch (error) {
                Swal.fire({
                    icon: "error",
                    title: "Error!",
                    text: error.message,
                });
                this.$PageLoad.stop();
            }
        },
        async loadPage() {
            await this.getAddress();
            this.isLoad = true;
            this.$PageLoad.stop();
        },
        async validate() {
            return this.$validator.validateAll("form").then((valid) => {
                return valid;
            });
        },
        async submitForm() {
            var isValid = await this.validate();
            if (isValid) {
                this.$Progress.start();
                EventBus.$emit("show-spinner", true);
                EventBus.$emit("show-submit-button-spinner", true);
                const data = new FormData(this.$refs.employeeForm);
                axios
                    .post(`/api/employee/${this.employee.id}`, data)
                    .then((response) => {
                        Toast.fire({
                            icon: "success",
                            title: response.data.message,
                        });
                        this.setAttributes(response.data.employee);
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
                        EventBus.$emit("show-submit-button-spinner", false);
                        EventBus.$emit("show-spinner", false);
                        this.$Progress.fail();
                    });
            }
        },
        setAttributes(employee) {
            const fullName = employee.fullName;
            const name = employee.name;
            const address = employee.address.fullAddress;
            const position = employee.position.name;
            const department = employee.department.name;
            EventBus.$emit("show-submit-button-spinner", false);
            EventBus.$emit(
                "hide-spinner",
                false,
                fullName,
                name,
                position,
                address,
                department
            );
            if (this.$gate.getEmployeeID() == this.employee.id) {
                EventBus.$emit("set-user-panel-name", name, position);
            }
        },
    },
    watch: {
        employee() {
            this.loadPage();
        },
    },
    mounted() {
        this.employee = this.data;
    },
};
</script>

<style scoped></style>

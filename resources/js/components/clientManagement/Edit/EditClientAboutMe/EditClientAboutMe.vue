<template>
    <form
        v-if="isLoad"
        ref="clientForm"
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
                        v-model="client.firstName"
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
                        v-model="client.middleName"
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
                        v-model="client.lastName"
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
                        v-model="client.suffix"
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
                        v-model="client.address.houseNumber"
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
                        v-model="client.address.streetName"
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
                        @change="handleProvince"
                        v-model="client.address.region"
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
                        @change="handleCity"
                        v-model="client.address.province"
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
                        @change="handleBarangay"
                        v-model="client.address.city"
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
                        v-model="client.address.barangay"
                    />
                </div>
            </div>
        </div>

        <h5 class="mb-3 text-uppercase bg-light p-2">
            <i class="fas fa-address-card mr-1"></i> Contact Details
        </h5>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <text-field
                        label="E-Mail Address"
                        name="emailAddress"
                        :labelAsterisk="true"
                        rules="required|email|max:255"
                        errorMessage="form.emailAddress"
                        errorLabel="E-Mail Address"
                        v-model="client.emailAddress.emailAddress"
                    />
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <text-field
                        label="Contact No."
                        name="contactNumber"
                        :labelAsterisk="true"
                        rules="required|max:255"
                        errorMessage="form.contactNumber"
                        errorLabel="Contact Number"
                        v-model="client.contactNumber.contactNumber"
                    />
                </div>
            </div>
        </div>

        <h5 class="mb-3 text-uppercase bg-light p-2">
            <i class="fas fa-building mr-1"></i> Organization
        </h5>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <text-field
                        label="Organization Name"
                        name="organization"
                        :labelAsterisk="true"
                        rules="required|max:255"
                        errorMessage="form.organization"
                        errorLabel="Organization Name"
                        v-model="client.organization.name"
                    />
                </div>
            </div>
        </div>

        <submit-button :showSpinner="showSpinner" />
    </form>
</template>

<script>
import TextField from "../../../customComponents/TextField";
import AddressSelect from "../../../customComponents/AddressSelect";
import CustomSelect from "../../../customComponents/CustomSelect";
import { EventBus } from "../../../../EventBus";
import SubmitButton from "./SubmitButton";

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
            showSpinner: false,
            client: {},
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
            this.loadProvince = true;
            if (!this.disableProvince) {
                this.disableProvince = true;
            }
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
                    (element) => element.name == this.client.address.region
                );
                this.provinces = await provinces(region.id);
                var province = this.provinces.find(
                    (element) => element.name == this.client.address.province
                );
                this.cities = await cities(province.id);
                var city = this.cities.find(
                    (element) => element.name == this.client.address.city
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
                const data = new FormData(this.$refs.clientForm);
                EventBus.$emit("show-spinner", true);
                this.showSpinner = true;
                axios
                    .post(`/api/client/${this.client.id}`, data)
                    .then((response) => {
                        Toast.fire({
                            icon: "success",
                            title: response.data.message,
                        });
                        this.setAttributes(response.data.client);
                        this.$Progress.finish();
                    })
                    .catch((error) => {
                        console.log(error);
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
                        EventBus.$emit("show-spinner", false);
                        this.$Progress.fail();
                    });
            }
        },
        setAttributes(client) {
            this.showSpinner = false;
            EventBus.$emit(
                "hide-spinner",
                false,
                client.fullName,
                client.name,
                client.emailAddress.emailAddress,
                client.contactNumber.contactNumber,
                client.organization.name,
                client.address.fullAddress
            );
        },
    },
    watch: {
        client() {
            this.loadPage();
        },
    },
    mounted() {
        this.client = this.data;
    },
};
</script>

<style scoped></style>

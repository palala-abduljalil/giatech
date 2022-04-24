<template>
    <section v-if="isLoad">
        <h5 class="mb-3 text-uppercase bg-light p-2">
            <i class="fas fa-user-circle mr-1"></i> Personal Info
        </h5>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <text-field
                        label="First Name"
                        name="firstName"
                        v-model="client.firstName"
                        :readonly="true"
                    />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <text-field
                        label="Middle Name"
                        name="middleName"
                        v-model="client.middleName"
                        :readonly="true"
                    />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <text-field
                        label="Last Name"
                        name="lastName"
                        v-model="client.lastName"
                        :readonly="true"
                    />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <text-field
                        label="Suffix"
                        name="suffix"
                        v-model="client.suffix"
                        :readonly="true"
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
                        v-model="client.address.houseNumber"
                        :readonly="true"
                    />
                </div>
            </div>
            <div class="col-md-8">
                <div class="form-group">
                    <text-field
                        label="Street Name"
                        name="streetName"
                        v-model="client.address.streetName"
                        :readonly="true"
                    />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <text-field
                        label="Barangay"
                        name="barangay"
                        v-model="client.address.barangay"
                        :readonly="true"
                    />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <text-field
                        label="City"
                        name="city"
                        v-model="client.address.city"
                        :readonly="true"
                    />
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <text-field
                        label="Province"
                        name="province"
                        v-model="client.address.province"
                        :readonly="true"
                    />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <text-field
                        label="Region"
                        name="region"
                        v-model="client.address.region"
                        :readonly="true"
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
                        v-model="client.emailAddress.emailAddress"
                        :readonly="true"
                    />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <text-field
                        label="Contact No."
                        name="contactNumber"
                        v-model="client.contactNumber.contactNumber"
                        :readonly="true"
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
                        label="Organization"
                        name="organization"
                        v-model="client.organization.name"
                        :readonly="true"
                    />
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import TextField from "../../customComponents/TextField";

export default {
    props: {
        data: Object
    },
    components: {
        TextField,
    },
    data() {
        return {
            isLoad: false,
            client: {},
        };
    },
    watch: {
        data() {
            this.client = this.data;
        }
    },
    mounted() {
        this.isLoad = true;
        this.client = this.data;
    },
};
</script>

<style>

</style>

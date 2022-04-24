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
                        v-model="employee.firstName"
                        :readonly="true"
                    />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <text-field
                        label="Middle Name"
                        name="middleName"
                        v-model="employee.middleName"
                        :readonly="true"
                    />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <text-field
                        label="Last Name"
                        name="lastName"
                        v-model="employee.lastName"
                        :readonly="true"
                    />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <text-field
                        label="Suffix"
                        name="suffix"
                        v-model="employee.suffix"
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
                        v-model="employee.address.houseNumber"
                        :readonly="true"
                    />
                </div>
            </div>
            <div class="col-md-8">
                <div class="form-group">
                    <text-field
                        label="Street Name"
                        name="streetName"
                        v-model="employee.address.streetName"
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
                        v-model="employee.address.barangay"
                        :readonly="true"
                    />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <text-field
                        label="City"
                        name="city"
                        v-model="employee.address.city"
                        :readonly="true"
                    />
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <text-field
                        label="Province"
                        name="province"
                        v-model="employee.address.province"
                        :readonly="true"
                    />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <text-field
                        label="Region"
                        name="region"
                        v-model="employee.address.region"
                        :readonly="true"
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
                        v-model="employee.emailAddress.businessEmail"
                        :readonly="true"
                    />
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <text-field
                        label="Alternate E-Mail"
                        name="alternateEmail"
                        v-model="employee.emailAddress.alternateEmail"
                        :readonly="true"
                    />
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <text-field
                        label="Contact No."
                        name="contactNumber"
                        v-model="employee.contactNumber.contactNumber"
                        :readonly="true"
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
                    <text-field
                        label="Position"
                        name="position"
                        v-model="employee.position.name"
                        :readonly="true"
                    />
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <text-field
                        label="Department"
                        name="department"
                        v-model="employee.department.name"
                        :readonly="true"
                    />
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <text-field
                        label="Status"
                        name="status"
                        v-model="employee.status.name"
                        :readonly="true"
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
                    <text-field
                        label="Degree"
                        name="degree"
                        v-model="employee.degree.name"
                        :readonly="true"
                    />
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <text-field
                        label="Year Graduated"
                        name="yearGraduated"
                        v-model="employee.yearGraduated"
                        :readonly="true"
                    />
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <text-field
                        label="School"
                        name="school"
                        v-model="employee.school.name"
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
        data: Object,
    },
    components: {
        TextField,
    },
    data() {
        return {
            employee: {},
            isLoad: false,
        };
    },
    watch: {
        data() {
            this.employee = this.data;
        },
    },
    mounted() {
        this.isLoad = true;
        this.employee = this.data;
    },
};
</script>

<style scoped>
.form-control:disabled,
.form-control[readonly] {
    background-color: #ffff;
    opacity: 1;
}
</style>

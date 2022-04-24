<template>
    <div class="card">
        <form data-vv-scope="form" @submit.prevent="submitForm">
            <div class="card-body">
                <div class="card-body">
                    <loader v-show="showSpinner" />
                    <div class="row">
                        <div class="col-md-6 pb-0">
                            <h5 class="font-weight-normal">
                                <i class="fas fa-user-circle mr-2"></i>
                                Account Information
                            </h5>
                            <hr />
                        </div>
                        <div class="col-md-6 pb-0">
                            <h5 class="font-weight-normal">
                                <i class="fas fa-cubes mr-2"></i>
                                Modules
                            </h5>
                            <hr />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 pt-0">
                            <div class="col-md-12 pt-0">
                                <div class="form-group">
                                    <employee-select
                                        label="Employee"
                                        name="employee"
                                        :labelAsterisk="true"
                                        rules="required"
                                        errorMessage="form.employee"
                                        errorLabel="Employee"
                                        url="/api/employee"
                                        :others="false"
                                        v-model="form.employee"
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <modules :modules="form.modules" />
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
import EmployeeSelect from "../../customComponents/EmployeeSelect";
import Modules from "../Modules";
import SubmitButton from "./SubmitButton";
import Loader from "../../customComponents/Loader";

export default {
    components: {
        Loader,
        EmployeeSelect,
        Modules,
        SubmitButton
    },
    data() {
        return {
            showSpinner: false,
            loader: false,
            form: {
                employee: "",
                modules: [],
            },
            send: {},
            disableModules: true,
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
                this.showSpinner = true;
                this.$Progress.start();
                this.send = Object.assign({}, this.form);
                this.send.modules = this.getSelectedModules();
                axios
                    .post("/api/user", this.send)
                    .then((response) => {
                        Toast.fire({
                            icon: "success",
                            title:
                                response.data.message +
                                "\nPage redirecting ... ",
                        });
                        this.showSpinner = false;
                        this.$Progress.finish();
                        window.location.href = "/users/";
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
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Form Submission Failed!",
                                text: "Please check your inputs.",
                            });
                        }
                        Swal.fire({
                            icon: "error",
                            title: "Error!",
                            text: "Error! " + error.message,
                        });
                        console.log("Error: ", error);
                        
                        this.showSpinner = false;
                        this.$Progress.fail();
                    });
            }
        },
        getModules() {
            axios
                .get("/api/module")
                .then((response) => {
                    this.form.modules = response.data;
                    if (this.form.modules.length != 0) {
                        this.setSelect(false);
                    }
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
        setSelect(value) {
            this.form.modules = this.form.modules.map((items, index) => ({
                ...items,
                select: value,
            }));
        },
        getSelectedModules() {
            let modules = [];
            this.form.modules.forEach((element) => {
                if (element.select) {
                    modules.push(element.id);
                }
            });
            return modules;
        },
    },
    watch: {
        "form.employee"() {
            this.disableModules = false;
        },
    },
    mounted() {
        this.getModules();
    },
};
</script>

<style scoped>
.card-title {
    margin-bottom: 0px;
    font-size: 20px;
}
.module-invalid-feedback {
    width: 100%;
    margin-top: 0.25rem;
    font-size: 100%;
    color: #dc3545;
}
</style>

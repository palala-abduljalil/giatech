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
                                    <text-field
                                        label="Username"
                                        name="username"
                                        :labelAsterisk="true"
                                        rules="required|min:8|max:500"
                                        errorMessage="form.username"
                                        errorLabel="Username"
                                        v-model="form.employee"
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <modules :modules="form.modules"/>
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
import Loader from "../../customComponents/Loader";
import TextField from "../../customComponents/TextField";
import Modules from "../Modules";
import SubmitButton from "./SubmitButton";

export default {
    props: {
        userId: Number,
    },
    components: {
        Loader,
        TextField,
        SubmitButton,
        Modules,
    },
    data() {
        return {
            showSpinner: false,
            form: {
                employee: "",
                modules: [],
            },
            send: {},
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
                Vue.set(this.send, "id", this.userId);
                this.send.modules = this.getSelectedModules();
                axios
                    .put(`/api/user/${this.userId}`, this.send)
                    .then((response) => {
                        Toast.fire({
                            icon: "success",
                            title: response.data.message,
                        });
                        this.showSpinner = false;
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
                        }
                        Swal.fire({
                            icon: "error",
                            title: "Form Submission Failed!",
                            text: "Please check your inputs.",
                        });
                        console.log("Error: ", error);
                        this.showSpinner = false;
                        this.$Progress.fail();
                    });
            }
        },
        async getModules() {
            this.showSpinner = true;
            axios
                .get("/api/module")
                .then((response) => {
                    this.form.modules = response.data;
                    if (this.form.modules.length != 0) {
                        this.setSelect(false);
                    }
                    this.showSpinner = false;
                    this.$Progress.finish();
                })
                .catch((error) => {
                    Toast.fire({
                        icon: "error",
                        title: "Error! " + error.message,
                    });
                    this.showSpinner = false;
                    this.$Progress.fail();
                    console.log("Error: ", error);
                });
        },
        getUser() {
            axios
                .get(`/api/user/${this.userId}`)
                .then((response) => {
                    this.assignSelect(response.data.modules);
                    Vue.set(this.form, "employee", response.data.username);
                    this.showSpinner = false;
                    this.$Progress.finish();
                })
                .catch((error) => {
                    Toast.fire({
                        icon: "error",
                        title: "Error! " + error.message,
                    });
                    this.showSpinner = false;
                    this.$Progress.fail();
                    console.log("Error: ", error);
                })
                .finally(() => {
                    this.$PageLoad.stop();
                });
        },
        assignSelect(newValue) {
            newValue = newValue.map((items) => ({
                ...items,
                select: true,
            }));
            newValue.forEach((element) => {
                let index = this.form.modules
                    .map((object) => object.id)
                    .indexOf(element.id);
                Vue.set(this.form.modules, index, element);
            });
        },
        setSelect(value) {
            this.form.modules = this.form.modules.map((items) => ({
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
        async loadData() {
            await this.getModules();
            this.getUser();
        },
    },
    mounted() {
        this.loadData();
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

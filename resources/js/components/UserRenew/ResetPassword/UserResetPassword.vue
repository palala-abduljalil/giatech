<template>
    <div class="card">
        <div class="card-header">Please set your password.</div>
        <form @submit.prevent="submitForm">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="required">New Password</label>
                            <input
                                v-validate="'required|min:8|max:500'"
                                name="passowrd"
                                type="password"
                                class="form-control"
                                :class="{
                                    'is-invalid': errors.has('passowrd'),
                                }"
                                ref="passowrd"
                                data-vv-as="Password"
                                v-model="form.password"
                            />
                            <div
                                class="invalid-feedback"
                                v-if="errors.has('passowrd')"
                            >
                                {{ errors.first("passowrd") }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="required">Confirm New Password</label>
                            <input
                                v-validate="
                                    'required|min:8|max:500|confirmed:passowrd'
                                "
                                class="form-control"
                                name="confirmPassword"
                                type="password"
                                :class="{
                                    'is-invalid': errors.has(
                                        'confirmPassword'
                                    ),
                                }"
                                data-vv-as="Password"
                                v-model="form.confirmPassword"
                            />
                            <div
                                class="invalid-feedback"
                                v-if="errors.has('confirmPassword')"
                            >
                                {{ errors.first("confirmPassword") }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <submit-button :processing="processing" />
            </div>
        </form>
    </div>
</template>

<script>
import TextField from "../../customComponents/TextField.vue";
import SubmitButton from "./SubmitButton";

export default {
    components: {
        TextField,
        SubmitButton,
    },
    data() {
        return {
            processing: false,
            form: {
                password: "",
                confirmPassword: "",
            },
        };
    },
    methods: {
        async validate() {
            return this.$validator.validate().then((valid) => {
                return valid;
            });
        },
        async submitForm() {
            var isValid = await this.validate();
            if (isValid) {
                this.$Progress.start();
                this.processing = true;
                axios
                    .put("/user-reset-password", this.form)
                    .then(() => {
                        this.processing = false;
                        this.$Progress.finish();
                        window.location.href = "/home";
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
                        this.processing = false;
                        this.$Progress.fail();
                    });
            }
        },
    },
};
</script>

<style></style>

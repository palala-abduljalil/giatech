<template>
    <div class="modal fade" id="modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        <i class="fas fa-redo mr-1"></i> Reset Password
                    </h4>
                    <x-modal-button />
                </div>
                <form @submit.prevent="submitForm" data-vv-scope="form">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <text-field
                                        label="New Password"
                                        :labelAsterisk="true"
                                        name="password"
                                        :type="showPassword ? 'text' : 'password'"
                                        rules="required|min:8|max:255"
                                        errorMessage="form.password"
                                        errorLabel="New Password"
                                        v-model="form.password"
                                    />
                                    <div class="input-group mb-3 mt-2">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input
                                                    type="checkbox"
                                                    class="form-check-input"
                                                    v-model="checkBox"
                                                    @change="showPassword =!showPassword"
                                                />
                                                Show password
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <close-button />
                        <submit-button :showLoader="showLoader" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import TextField from "../../customComponents/TextField";
import ButtonSpinner from "../../customComponents/ButtonSpinner";
import XModalButton from "./XModalButton";
import CloseButton from "./CloseButton";
import SubmitButton from "./SubmitButton";
import { EventBus } from "../../../EventBus";

export default {
    props: ["data"],
    components: {
        TextField,
        ButtonSpinner,
        XModalButton,
        CloseButton,
        SubmitButton,
    },
    data() {
        return {
            form: {
                password: "",
            },
            showLoader: false,
            showPassword: false,
            checkBox: false,
        };
    },
    methods: {
        formReset() {
            this.showPassword = false;
            this.checkBox = false;
            this.form.password = "";
            this.$validator.reset();
        },
        submitForm() {
            this.$validator.validate().then((valid) => {
                if (valid) {
                    this.$Progress.start();
                    this.showLoader = true;
                    axios
                        .put(`/api/user/${this.data}/reset-password`, this.form)
                        .then((response) => {
                            Toast.fire({
                                icon: "success",
                                title: response.data.message,
                            });
                            $("#modal").modal("hide");
                            this.showLoader = false;
                            this.$Progress.finish();
                        })
                        .catch((error) => {
                            if (error.response.data.errors) {
                                var entries = Object.entries(
                                    error.response.data.errors
                                );
                                entries.forEach(function (item, index) {
                                    this.errors.remove(item[0], "form");
                                    this.errors.add({
                                        field: item[0],
                                        msg: item[1][0],
                                        scope: "form",
                                    });
                                }, this);
                            } else {
                                Toast.fire({
                                    icon: "error",
                                    title: "Error! " + error.message,
                                });
                                console.log("Error: ", error);
                            }
                            this.showLoader = false;
                            this.$Progress.fail();
                        });
                }
            });
        },
    },
    mounted() {
        EventBus.$on("open-modal", () => {
            this.formReset();
        });
    },
};
</script>

<style></style>

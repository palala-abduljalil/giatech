<template>
    <div id="freebieDescription" class="card">
        <div class="card-header">
            <h3 class="card-title font-weight-bold">
                <i class="fas fa-file-alt mr-2"></i>
                Freebie Description
            </h3>
        </div>
        <div class="card-body">
            <loader v-show="showSpinner" />
            <form data-vv-scope="form1">
                <div class="form-group">
                    <text-area
                        label="Description"
                        name="freebieDescription"
                        rows="3"
                        v-model="form.freebieDescription"
                        rules="required|min:10|max:500"
                        errorMessage="form1.freebieDescription"
                        errorLabel="Description"
                    />
                </div>
            </form>
        </div>
        <div class="card-footer">
            <submit-button @onSubmit="update" />
        </div>
    </div>
</template>

<script>
import Loader from "../../../customComponents/Loader";
import TextArea from "../../../customComponents/TextArea";
import SubmitButton from "./SubmitButton";
import { EventBus } from "../../../../EventBus";

export default {
    components: {
        Loader,
        TextArea,
        SubmitButton,
    },
    props: {
        text: {
            type: String,
            default: "",
        },
    },
    data() {
        return {
            form: {
                freebieDescription: "",
            },
            showSpinner: false,
        };
    },
    methods: {
        update() {
            this.$validator.validateAll("form1").then((valid) => {
                if (valid) {
                    const companyID = 1;
                    this.$Progress.start();
                    this.showSpinner = true;
                    EventBus.$emit("show-spinner", true);
                    axios
                        .put(`/api/company/freebie/${companyID}/freebie-description`, this.form)
                        .then((response) => {
                            Toast.fire({
                                icon: "success",
                                title: response.data.message,
                            });
                            EventBus.$emit("show-spinner", false);
                            this.showSpinner = false;
                            this.$Progress.finish();
                        })
                        .catch((error) => {
                            if (error.response.data.errors) {
                                var entries = Object.entries(
                                    error.response.data.errors
                                );
                                this.errors.clear("form1");
                                entries.forEach(function (item, index) {
                                    this.errors.add({
                                        field: item[0],
                                        msg: item[1][0],
                                        scope: "form1",
                                    });
                                }, this);
                            } else {
                                Toast.fire({
                                    icon: "error",
                                    title: "Error! " + error.message,
                                });
                            }
                            this.$Progress.fail();
                            EventBus.$emit("show-spinner", false);
                            this.showSpinner = false;
                        });
                }
            });
        },
    },
    mounted() {
        this.form.freebieDescription = this.text;
    },
};
</script>

<style></style>

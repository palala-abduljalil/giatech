<template>
    <div class="modal fade" id="modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Security Question</h4>
                    <x-modal-button />
                </div>
                <form ref="myForm" @submit.prevent="submitForm">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <security-question-select
                                        label="Question: "
                                        name="security_question_id"
                                        rules="required"
                                        errorMessage="security_question_id"
                                        errorLabel="Question"
                                        url="/api/security-question"
                                        :labelAsterisk="true"
                                        v-model="securityQuestion.question_id"
                                        :notInclude="notInclude"
                                    />
                                </div>
                                <div class="form-group">
                                    <text-field
                                        label="Answer"
                                        name="answer"
                                        :labelAsterisk="true"
                                        rules="required|min:8|max:500"
                                        errorMessage="answer"
                                        errorLabel="Answer"
                                        v-model="securityQuestion.answer"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <close-button />
                        <submit-button :showSpinner="showSpinner"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import ButtonSpinner from "../../../../customComponents/ButtonSpinner";
import TextField from "../../../../customComponents/TextField";
import { EventBus } from "../../../../../EventBus";
import SecurityQuestionSelect from "../SecurityQuestionSelect";
import XModalButton from "./XModalButton";
import CloseButton from "./CloseButton";
import SubmitButton from "./SubmitButton";

export default {
    props: {
        item: Object,
        userId: Number,
    },
    components: {
        ButtonSpinner,
        TextField,
        SecurityQuestionSelect,
        XModalButton,
        CloseButton,
        SubmitButton
    },
    data() {
        return {
            showSpinner: false,
            notInclude: [],
            securityQuestion: {},
        };
    },
    methods: {
        submitForm() {
            this.$validator.validate().then((valid) => {
                if (valid) {
                    var data = new FormData(this.$refs.myForm);
                    data.append("_method", "PUT");
                    this.$Progress.start();
                    this.showSpinner = true;
                    axios
                        .post(
                            `/api/user/${this.userId}/security-question/${this.item.id}`,
                            data
                        )
                        .then((response) => {
                            this.$emit("onUpdateSuccess");
                            Toast.fire({
                                icon: "success",
                                title: response.data.message,
                            });
                            $("#modal").modal("hide");
                            this.showSpinner = false;
                            this.$Progress.finish();
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
                            } else {
                                Toast.fire({
                                    icon: "error",
                                    title: "Error! " + error.message,
                                });
                                console.log("Error: ", error);
                            }
                            this.showSpinner = false;
                            this.$Progress.fail();
                        });
                }
            });
        },
    },
    watch: {
        item() {
            this.securityQuestion = this.item;
        },
    },
    mounted() {
        EventBus.$on("open-modal", (data) => {
            this.notInclude = [data[0].question_id, data[1].question_id];
            this.$validator.reset();
        });
    },
};
</script>

<style></style>

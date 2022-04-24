<template>
    <div class="modal fade" id="securityQuestionModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ modalTitle }}</h4>
                    <x-modal-button />
                </div>
                <form
                    ref="myForm"
                    @submit.prevent="handleSubmit"
                    data-vv-scope="form"
                >
                    <input type="hidden" name="_method" :value="action" />
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <text-field
                                        label="Enter Current Password:"
                                        :labelAsterisk="true"
                                        name="password"
                                        type="password"
                                        rules="required|min:8|max:500"
                                        errorMessage="form.password"
                                        errorLabel="Password"
                                        v-model="password"
                                    />
                                </div>
                                <div class="form-group">
                                    <security-question-select
                                        label="Question"
                                        name="security_question"
                                        rules="required"
                                        errorMessage="form.security_question"
                                        errorLabel="Question"
                                        url="/api/security-question"
                                        :labelAsterisk="true"
                                        :notInclude="notInclude"
                                        v-model="question"
                                    />
                                </div>
                                <div class="form-group">
                                    <text-field
                                        label="Answer"
                                        name="answer"
                                        :labelAsterisk="true"
                                        rules="required|min:8|max:500"
                                        errorMessage="form.answer"
                                        errorLabel="Answer"
                                        v-model="answer"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <close-modal-button />
                        <submit-button :text="submitButtonText" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import TextField from "../../../customComponents/TextField";
import TextArea from "../../../customComponents/TextArea";
import FileInput from "../../../customComponents/FileInput";
import SubmitButton from "./SubmitButton";
import XModalButton from "./XModalButton";
import CloseModalButton from "./CloseModalButton";
import SecurityQuestionSelect from "../../../userManagement/View/ViewSecurityQuestions/SecurityQuestionSelect";
import { EventBus } from "../../../../EventBus";

export default {
    inject: ["$validator"],
    components: {
        TextField,
        TextArea,
        FileInput,
        SubmitButton,
        XModalButton,
        CloseModalButton,
        SecurityQuestionSelect,
    },
    props: {
        modalTitle: {
            type: String,
            default: "",
        },
        submitButtonText: {
            type: String,
            default: "",
        },
        action: String,
        data: Object,
    },
    data() {
        return {
            notInclude: [],
            password: "",
            question: "",
            answer: "",
        };
    },
    methods: {
        handleSubmit() {
            this.$emit("onSubmit");
        },
    },
    watch: {
        data() {
            this.question = this.data.question_id;
            this.answer = this.data.answer;
        },
    },
    mounted() {
        this.question = this.data.question_id;
        this.answer = this.data.answer;
        EventBus.$on("open-modal", (data) => {
            this.notInclude = [data[0].question_id, data[1].question_id];
            this.password = "";
            this.$validator.reset();
        });
    },
};
</script>

<style></style>

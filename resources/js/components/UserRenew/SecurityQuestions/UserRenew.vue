<template>
    <div class="card">
        <div class="card-header">Please set your security questions.</div>
        <form @submit.prevent="submitForm">
            <div class="card-body">
                <div class="form-group">
                    <security-question-select
                        :items="question1"
                        label="Security Question #1"
                        name="0.question"
                        rules="required"
                        errorMessage="0.question"
                        errorLabel="Security Question #1"
                        @change="changeQuestion2"
                        placeholder="Select Security Question #1"
                        v-model="form[0].question"
                    />
                </div>
                <div class="form-group">
                    <text-field
                        label="Answer"
                        name="0.answer"
                        rules="required|max:255"
                        errorMessage="0.answer"
                        errorLabel="Answer"
                        v-model="form[0].answer"
                    />
                </div>
                <div class="form-group">
                    <security-question-select
                        :items="question2"
                        label="Security Question #2"
                        name="1.question"
                        rules="required"
                        errorMessage="1.question"
                        errorLabel="Security Question #2"
                        @change="changeQuestion3"
                        v-model="form[1].question"
                        :disabled="disableQuestion2"
                        :placeholder="question2Placeholder"
                    />
                </div>
                <div class="form-group">
                    <text-field
                        label="Answer"
                        name="1.answer"
                        rules="required|max:255"
                        errorMessage="1.answer"
                        errorLabel="Answer"
                        v-model="form[1].answer"
                    />
                </div>
                <div class="form-group">
                    <security-question-select
                        :items="question3"
                        label="Security Question #3"
                        name="2.question"
                        rules="required"
                        errorMessage="2.question"
                        errorLabel="Security Question #3"
                        v-model="form[2].question"
                        :disabled="disableQuestion3"
                        :placeholder="question3Placeholder"
                    />
                </div>
                <div class="form-group">
                    <text-field
                        label="Answer"
                        name="2.answer"
                        rules="required|max:225"
                        errorMessage="2.answer"
                        errorLabel="Answer"
                        v-model="form[2].answer"
                    />
                </div>
            </div>
            <div class="card-footer">
                <submit-button :processing="processing" />
            </div>
        </form>
    </div>
</template>

<script>
import SecurityQuestionSelect from "./SecuritQuestionSelect";
import TextField from "../../customComponents/TextField.vue";
import SubmitButton from "./SubmitButton";

export default {
    props: {
        data: Array,
    },
    components: {
        SecurityQuestionSelect,
        TextField,
        SubmitButton,
    },
    data() {
        return {
            question1: [],
            question2: [],
            question3: [],
            question2Placeholder: "Select Question #1 first",
            question3Placeholder: "Select Question #2 first",
            processing: false,
            disableQuestion2: true,
            disableQuestion3: true,
            form: [
                { question: "", answer: "" },
                { question: "", answer: "" },
                { question: "", answer: "" },
            ],
        };
    },
    methods: {
        changeQuestion2(e) {
            this.question2 = this.question1.filter((i) => i.id != e);
            this.form[1].question = "";
            this.form[2].question = "";
            this.question2Placeholder = "Select Question #2";
            this.question3Placeholder = "Select Question #2 first";
            this.disableQuestion2 = false;
            this.disableQuestion3 = true;
        },
        changeQuestion3(e) {
            this.question3 = this.question2.filter((i) => i.id != e);
            this.form[2].question = "";
            this.question3Placeholder = "Select Question #3";
            this.disableQuestion3 = false;
        },
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
                    .post("/user-security-questions", this.form)
                    .then(() => {
                        this.processing = false;
                        this.$Progress.finish();
                        window.location.href = "/user-reset-password";
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
    mounted() {
        this.question1 = this.data;
    },
};
</script>

<style></style>

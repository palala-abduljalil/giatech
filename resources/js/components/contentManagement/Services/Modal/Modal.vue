<template>
    <div class="modal fade" id="serviceModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ modalTitle }}</h4>
                    <x-modal-button />
                </div>
                <form
                    ref="myForm"
                    @submit.prevent="handleSubmit"
                    enctype="multipart/form-data"
                    data-vv-scope="form2"
                >
                    <input type="hidden" name="_method" :value="action">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <text-field
                                        label="Title"
                                        name="title"
                                        :readonly="!submitButtonText"
                                        rules="required|min:5|max:255"
                                        errorMessage="form2.title"
                                        errorLabel="Title"
                                        v-model="inputs.title"
                                    />
                                </div>
                                <div class="form-group">
                                    <text-area
                                        label="Description: "
                                        name="description"
                                        rows="6"
                                        :readonly="!submitButtonText"
                                        rules="required|min:10|max:500"
                                        errorMessage="form2.description"
                                        errorLabel="Description"
                                        v-model="inputs.description"
                                    />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <file-input
                                    label="Cover Image"
                                    name="image"
                                    ref="imageUploader"
                                    rules="mimes:image/jpeg,image/jpg,image/png|size:2048"
                                    errorMessage="form2.image"
                                    errorLabel="Cover Image"
                                    :show="submitButtonText"
                                    :imagePreview="imagePreview"
                                    :imageLabel="imageLabel"
                                    v-model="file"
                                />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <close-modal-button />
                        <submit-button :text="submitButtonText"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import TextField from "../../../customComponents/TextField";
import TextArea from "../../../customComponents/TextArea"
import FileInput from "../../../customComponents/FileInput";
import SubmitButton from "./SubmitButton";
import XModalButton from "./XModalButton";
import CloseModalButton from "./CloseModalButton";

export default {
    inject: ['$validator'],
    components: {
        TextField,
        TextArea,
        FileInput,
        SubmitButton,
        XModalButton,
        CloseModalButton
    },
    props: {
        modalTitle: {
            type: String,
            default: '',
        },
        submitButtonText: {
            type: String,
            default: '',
        },
        action: String,
        data: Object 
    },
    data() {
        return {
            inputs: {},
            imagePreview: "",
            imageLabel: "",
            file: "",
        }
    },
    methods: {
        handleSubmit() {
            this.$emit("onSubmit");
        }
    },
    watch: {
        data() {
            this.inputs = this.data;
        }
    },
    mounted() {
        this.inputs = this.data;
    }
};
</script>

<style></style>

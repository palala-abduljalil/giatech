<template>
    <div class="modal fade" id="freebieModal" aria-hidden="true">
        <div class="modal-dialog">
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
                            <div class="col-md-12">
                                <div class="form-group">
                                    <text-field
                                        label="Name"
                                        name="name"
                                        :readonly="!submitButtonText"
                                        rules="required|min:5|max:255"
                                        errorMessage="form2.name"
                                        errorLabel="Name"
                                        v-model="inputs.name"
                                    />
                                </div>
                            </div>
                            <div class="col-md-12">
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
import FileInput from "../../../customComponents/FileInput";
import SubmitButton from "./SubmitButton";
import XModalButton from "./XModalButton";
import CloseModalButton from "./CloseModalButton";

export default {
    inject: ['$validator'],
    components: {
        TextField,
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

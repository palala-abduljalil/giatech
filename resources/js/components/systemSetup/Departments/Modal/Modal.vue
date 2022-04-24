<template>
    <div class="modal fade" id="departmentModal" aria-hidden="true">
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
                    data-vv-scope="form"
                >
                    <input type="hidden" name="_method" :value="action">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <text-field
                                        label="Department"
                                        name="name"
                                        :readonly="!submitButtonText"
                                        rules="required|min:5|max:500"
                                        errorMessage="form.name"
                                        errorLabel="Department"
                                        v-model="inputs.name"
                                    />
                                </div>
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

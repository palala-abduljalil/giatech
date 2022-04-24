<template>
    <div class="modal fade" id="modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ modalTitle }}</h4>
                    <x-modal-button />
                </div>
                <form ref="myForm" @submit.prevent="handleOnSubmit">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <text-field
                                        label="Achievement:"
                                        name="description"
                                        placeholder="Enter description"
                                        :readonly="!submitButtonText"
                                        v-model="input.description"
                                        rules="required|min:5|max:500"
                                        errorMessage="description"
                                        errorLabel="Position"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <close-button />
                        <submit-button :text="submitButtonText" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import XModalButton from "./XModalButton";
import CloseButton from "./CloseButton";
import SubmitButton from "./SubmitButton";
import TextField from "../../../../customComponents/TextField";

export default {
    inject: ['$validator'],
    props: {
        modalTitle: String,
        submitButtonText: String,
        item: Object,
    },
    data() {
        return {
            input: {},
        };
    },
    components: {
        XModalButton,
        CloseButton,
        SubmitButton,
        TextField,
    },
    methods: {
        handleOnSubmit() {
            this.$emit("onSubmit");
        },
    },
    watch: {
        item() {
            this.input = this.item;
        },
    },
    mounted() {
        this.input = this.item;
    }
};
</script>

<style></style>

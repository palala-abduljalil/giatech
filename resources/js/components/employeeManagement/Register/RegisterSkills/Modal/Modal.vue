<template>
    <div class="modal fade" id="skillModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ modalTitle }}</h4>
                    <x-modal-button />
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <text-field
                                    label="Skill Description: "
                                    :labelAsterisk="true"
                                    name="description"
                                    placeholder="Enter Skill"
                                    rules="required|min:5|max:500"
                                    errorMessage="description"
                                    errorLabel="Skill"
                                    v-model="input.description"
                                    @submit-form="handleOnSubmit"
                                />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <close-button />
                    <submit-button 
                        :text="modalSubmitButtonText"
                        @onSubmit="handleOnSubmit"
                    />
                </div>
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
    props: {
        modalTitle: {
            type: String,
            default: "Modal Title",
        },
        item: Object,
        modalSubmitButtonText: {
            type: String,
            default: "Submit",
        },
    },
    components: {
        XModalButton,
        CloseButton,
        SubmitButton,
        TextField,
    },
    data() {
        return {
            input: {},
        };
    },
    methods: {
        handleOnSubmit() {
            this.$emit("onSubmit");
        }
    },
    watch: {
        item() {
            this.input = this.item;
        }
    },
    mounted() {
        this.input = this.item;
    }
};
</script>

<style></style>

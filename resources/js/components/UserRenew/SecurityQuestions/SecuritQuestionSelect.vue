<template>
    <div>
        <label :class="{ required: labelAsterisk }">
            {{ label }}
        </label>
        <button-spinner v-show="showSpinner" class="float-right ml-1 text-primary"/>
        <select
            ref="customSelect"
            v-validate="rules"
            :name="name"
            :class="{ 'is-invalid': errors.has(errorMessage) }"
            class="form-control"
            @input="handleInput"
            @change="handleChange"
            :data-vv-as="errorLabel"
            :disabled="disabled"
            :value="input"
        >
            <option value="" disabled selected>{{ localPlaceholder }}</option>
            <option v-for="item in items" :key="item.id" :value="item.id">
                {{ item.question }}
            </option>
        </select>
        <div class="invalid-feedback" v-if="errors.has(errorMessage)">
            {{ errors.first(errorMessage) }}
        </div>
    </div>
</template>

<script>
import TextField from "../../customComponents/TextField";
import ButtonSpinner from "../../customComponents/ButtonSpinner";

export default {
    inject: ['$validator'],
    components: {
        TextField,
        ButtonSpinner,
    },
    props: [
        "items",
        "label", 
        "rules", 
        "name", 
        "errorLabel", 
        "errorMessage",
        "value",
        "labelAsterisk",
        "disabled",
        "placeholder"
    ],
    data() {
        return {
            options: [],
            showOthers: false,
            showSpinner: false,
            showOthersSpinner: false,
            input: this.value,
            localPlaceholder: "",
        }
    },
    methods: {
        handleInput(e) {
            this.input = e.target.value;
            if (this.value != undefined) {
                this.$emit("input", e.target.value);
            }
        },
        handleChange(e) {
            this.$emit("change", e.target.value);
        },
        selectLabel() {
            if (this.label == "Security Question #2") {
                this.localPlaceholder = "Select Question #1 first";
            } else if (this.label == "Security Question #3") {
                this.localPlaceholder = "Select Question #2 first";
            } else {
                this.localPlaceholder = "Select " + this.label;
            }
        }
    },
    watch: {
        value() {
            this.input = this.value;
        },
        items() {
            this.options = this.items;
        },
        placeholder() {
            this.localPlaceholder = this.placeholder;
        }
    },
    created () {
        this.selectLabel();
        this.options = this.items;
        this.localPlaceholder = this.placeholder;
    }
};
</script>

<style>
.required:after {
    content: " *";
    color: red;
}
</style>

<template>
    <div>
        <label
            :class="{
                'required': labelAsterisk,
                'text-muted': loadData,
                'text-muted': disabled,
            }"
        >
            {{ label }}
        </label>
        <button-spinner
            v-show="loadData"
            class="float-right ml-1 text-primary"
        />
        <select
            ref="selectRef"
            v-validate="rules"
            class="form-control"
            :class="{ 'is-invalid': errors.has(errorMessage) }"
            :name="name"
            :value="input"
            :disabled="disabled"
            :data-vv-as="errorLabel"
            @change="handleChange"
            @input="handleInput"
        >
            <option value="" disabled selected>{{ selectLabel }}</option>
            <option v-for="item in items" :key="item.name" :value="item.name">
                {{ item.name }}
            </option>
        </select>
        <div class="invalid-feedback" v-if="errors.has(errorMessage)">
            {{ errors.first(errorMessage) }}
        </div>
    </div>
</template>

<script>
import ButtonSpinner from "./ButtonSpinner.vue";

export default {
    components: {
        ButtonSpinner,
    },
    data() {
        return {
            selectLabel: "",
            input: "",
        };
    },
    props: [
        "label",
        "rules",
        "name",
        "errorLabel",
        "errorMessage",
        "items",
        "value",
        "disabled",
        "loadData",
        "labelAsterisk",
    ],
    methods: {
        handleChange(e) {
            this.$emit("change", e);
        },
        handleInput(e) {
            this.input = e.target.value;
            if (this.value != undefined) {
                this.$emit("input", e.target.value);
            }
        },
        setLabel() {
            if (this.name == "province") {
                this.disabled
                    ? (this.selectLabel = "Select Region First")
                    : (this.selectLabel = "Select Province");
                return;
            }
            if (this.name == "city") {
                this.disabled
                    ? (this.selectLabel = "Select Province first")
                    : (this.selectLabel = "Select City");
                return;
            }
            if (this.name == "barangay") {
                this.selectLabel = "Select Barangay";
                return;
            }
            if (this.name == "region") {
                this.selectLabel = "Select Region";
                return;
            }
        },
    },
    watch: {
        loadData() {
            this.input = "";
            if (this.loadData) {
                if (this.name == "province") {
                    this.selectLabel = "Loading Provinces . . .";
                } else if (this.name == "city") {
                    this.selectLabel = "Loading Cities . . .";
                } else if (this.name == "barangay") {
                    this.selectLabel = "Loading Barangays . . .";
                } else {
                    this.selectLabel = "Loading . . .";
                }
            } else {
                this.selectLabel = "Select " + this.name;
            }
        },
        disabled() {
            this.input = "";
            this.setLabel();
        },
        value() {
            this.input = this.value;
        },
    },
    created() {
        this.setLabel();
        this.input = this.value;
        this.$validator = this.$parent.$validator;
    },
};
</script>

<style>
.required:after {
    content: " *";
    color: red;
}
</style>

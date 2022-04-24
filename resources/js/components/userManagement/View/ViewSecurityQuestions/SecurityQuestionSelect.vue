<template>
    <div>
        <label :class="{ required: labelAsterisk }">
            {{ label }}
        </label>
        <button-spinner
            v-show="showSpinner"
            class="float-right ml-1 text-primary"
        />
        <select
            ref="customSelect"
            v-validate="rules"
            :name="name"
            :class="{ 'is-invalid': errors.has(errorMessage) }"
            class="form-control"
            @input="handleInput"
            :data-vv-as="errorLabel"
            :disabled="disabled"
            :value="input"
        >
            <option value="" disabled selected>{{ placeholder }}</option>
            <option
                v-for="item in questions"
                :key="item.id"
                :value="item.id"
                :selected="item.id == input"
            >
                {{ item.question }}
            </option>
        </select>
        <div class="invalid-feedback" v-if="errors.has(errorMessage)">
            {{ errors.first(errorMessage) }}
        </div>
    </div>
</template>

<script>
import ButtonSpinner from "../../../customComponents/ButtonSpinner";

export default {
    components: {
        ButtonSpinner,
    },
    props: [
        "label",
        "rules",
        "name",
        "errorLabel",
        "errorMessage",
        "value",
        "labelAsterisk",
        "url",
        "notInclude",
    ],
    data() {
        return {
            items: [],
            showOthers: false,
            showSpinner: false,
            disabled: false,
            placeholder: "Select " + this.label,
            item: {
                name: "",
            },
            input: this.value,
            questions: [],
        };
    },
    methods: {
        handleInput(e) {
            if (this.value == undefined) {
                this.input = e.target.value;
            } else {
                this.input = e.target.value;
                this.$emit("input", e.target.value);
            }
        },
        async getItems() {
            this.input = "";
            this.showSpinner = true;
            this.disabled = true;
            this.placeholder = "Loading . . .";
            return axios
                .get(this.url)
                .then((response) => {
                    this.items = response.data;
                    this.disabled = false;
                    this.showSpinner = false;
                    this.placeholder = "Select " + this.label;
                    return true;
                })
                .catch((error) => {
                    Toast.fire({
                        icon: "error",
                        title: "Error! " + error.message,
                    });
                    console.log("Error:", error.message);
                    this.placeholder = "Select " + this.label;
                    this.disabled = false;
                    this.showSpinner = false;
                    return false;
                });
        },
        async loadData() {
            if (await this.getItems()) {
                this.input = this.value;
                this.questions = this.items;
            }
        },
    },
    watch: {
        notInclude() {
            this.questions = this.items.filter(
                (i) => i.id != this.notInclude[0] && i.id != this.notInclude[1]
            );
            this.input = this.value;
        },
    },
    created() {
        this.loadData();
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

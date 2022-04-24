<template>
    <div>
        <label :class="{ required: labelAsterisk }">
            {{ label }}
        </label>
        <button-spinner v-show="showSpinner" class="float-right ml-1 text-primary"/>
        <select
            ref="employeeSelect"
            v-validate="rules"
            :name="name"
            :class="{ 'is-invalid': errors.has(errorMessage) }"
            class="form-control"
            @input="handleInput"
            :data-vv-as="errorLabel"
            :value="value"
            :disabled="disabled"
        >
            <option value="" disabled selected>{{ placeholer }}</option>
            <option v-for="item in items" :key="item.id" :value=item.id>
                {{ item.employeeNumber }} - {{ item.name }}
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
    ],
    data() {
        return {
            items: [],
            showOthers: false,
            showSpinner: false,
            disabled: false,
            placeholer: 'Select ' + this.label,
        }
    },
    methods: {
        handleInput(e) {
            this.$emit('input', e.target.value)
        },
        async getItems() {
            this.showSpinner = true;
            this.disabled = true;
            this.placeholer = "Loading . . .";
            return axios
                .get(this.url)
                .then((response) => {
                    this.items = response.data;
                    this.disabled = false;
                    this.showSpinner = false;
                    this.placeholer = "Select "+ this.label;
                    return true;
                })
                .catch((error) => {
                    Toast.fire({
                        icon: "error",
                        title: "Some error occured! Please try again",
                    });
                    console.log("Error:", error.message);
                    this.placeholer = "Select "+ this.label;
                    this.disabled = false;
                    this.showSpinner = false;
                    return false;
                });
        },
        async loadData() {
            await this.getItems();
        }
    },
    created () {
        this.loadData();
        this.$validator = this.$parent.$validator;
    }
};
</script>

<style scoped>
.required:after {
    content: " *";
    color: red;
}
</style>

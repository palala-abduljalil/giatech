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
            @change="handleChange"
            @input="handleInput"
            :data-vv-as="errorLabel"
            :others="others"
            :disabled="disabled"
        >
            <option value="" disabled selected>{{ placeholer }}</option>
            <option v-for="item in items" :key="item.id" :value="item.employeeNumber">
                {{ item.employeeNumber }} - {{ item.name }}
            </option>
            <option value="others" v-if="others">Others</option>
        </select>
        <div class="invalid-feedback" v-if="errors.has(errorMessage)">
            {{ errors.first(errorMessage) }}
        </div>
        <form 
            @submit.prevent="addItem"
            :data-vv-scope="`other${name}`"
        >
            <text-field
                v-show="showOthers"
                v-model="item.name"
                class="mt-3"
                :label="`Insert ${name}`"
                name="name"
                rules='required|max:500'
                :errorMessage="`other${name}.name`"
                :errorLabel="name"
            />
            <button
                v-show="showOthers"
                class="btn btn-primary float-right mt-3"
                :disabled="showSpinner"
            >
                <button-spinner v-show="showSpinner" />
                <i class="fas fa-plus mr-1" v-show="!showSpinner"></i><b> INSERT</b>
            </button>
        </form>
    </div>
</template>

<script>
import TextField from "./TextField";
import ButtonSpinner from "./ButtonSpinner";

export default {
    components: {
        TextField,
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
        "others",
    ],
    data() {
        return {
            items: [],
            showOthers: false,
            showSpinner: false,
            disabled: false,
            placeholer: 'Select ' + this.label,
            item: {
                name: ''
            },
        }
    },
    methods: {
        handleChange(e) {
            if (e.target.value == "others") {
                e.target.value = "";
                this.item.name = "";
                this.$validator.reset();
                this.showOthers = true;
            } else {
                this.showOthers = false;
            }
        },
        handleInput(e) {
            this.$emit('input', e.target.value)
        },
        addItem() {
            this.$validator.validateAll('other' + this.name).then((valid) => {
                if (true) {
                    this.showSpinner = true;
                    axios
                        .post(this.url, this.item)
                        .then((response) => {
                            this.getItems();
                            this.$refs.customSelect.value = this.items[0];
                            Toast.fire({
                                icon: "success",
                                title: response.data.message,
                            });
                            this.showOthers = false;
                            this.showSpinner = false;
                        })
                        .catch((error) => {
                            if (error.response.data.errors) {
                                var entries = Object.entries(
                                    error.response.data.errors
                                );
                                entries.forEach(function (item, index) {
                                    this.errors.remove(item[0], 'other' + this.name);
                                    this.errors.add({
                                        field: item[0],
                                        msg: item[1][0],
                                        scope: 'other' + this.name
                                    });
                                }, this);
                            }
                            Toast.fire({
                                icon: "error",
                                title: "Some error occured! Please try again",
                            });
                            console.log("Error: ", error);
                            this.showSpinner = false;
                        });
                }
            });
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
            if (await this.getItems()) {
                if (this.value) {
                    this.$refs.customSelect.value = this.value;
                }
            }
        }
    },
    created () {
        this.loadData();
        this.$validator = this.$parent.$validator;
    }
};
</script>

<style>
.required:after {
    content: " *";
    color: red;
}
</style>

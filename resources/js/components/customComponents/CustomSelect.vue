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
            :data-vv-as="errorLabel"
            :others="others"
            :disabled="disabled"
            :value="input"
        >
            <option value="" disabled selected>{{ placeholder }}</option>
            <option v-for="item in items" :key="item.id" :value="item.id">
                {{ item.name }}
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
                :disabled="showOthersSpinner"
            >
                <button-spinner v-show="showOthersSpinner" />
                <i class="fas fa-plus mr-1" v-show="!showOthersSpinner"></i><b> INSERT</b>
            </button>
        </form>
    </div>
</template>

<script>
import TextField from "./TextField";
import ButtonSpinner from "./ButtonSpinner";

export default {
    inject: ['$validator'],
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
            showOthersSpinner: false,
            disabled: false,
            placeholder: "Select " + this.label,
            item: {
                name: ""
            },
            input: this.value,
        }
    },
    methods: {
        handleInput(e) {
            if (e.target.value == "others") {
                this.item.name = "";
                this.input = "";
                this.$validator.reset();
                this.showOthers = true;
            } else {
                this.showOthers ? this.showOthers = false : '';
                if (this.value == undefined) {
                    this.input = e.target.value;
                } else {
                    this.input = e.target.value;
                    this.$emit("input", e.target.value);
                }
            }
        },
        addItem() {
            this.$validator.validateAll("other" + this.name).then((valid) => {
                if (valid) {
                    this.showOthersSpinner = true;
                    axios
                        .post(this.url, this.item)
                        .then((response) => {
                            this.loadData();
                            Toast.fire({
                                icon: "success",
                                title: response.data.message,
                            });
                        })
                        .catch((error) => {
                            if (error.response.data.errors) {
                                var entries = Object.entries(
                                    error.response.data.errors
                                );
                                this.errors.clear("other" + this.name);
                                entries.forEach(function (item, index) {
                                    this.errors.add({
                                        field: item[0],
                                        msg: item[1][0],
                                        scope: "other" + this.name
                                    });
                                }, this);
                            } else {
                                Toast.fire({
                                    icon: "error",
                                    title: "Error! " + error.message,
                                });
                                console.log("Error: ", error);
                            }
                            this.showSpinner = false;
                            this.showOthersSpinner = false;
                        });
                }
            });
        },
        async getItems() {
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
                    console.log("Error: ", error);
                    this.placeholder = "Select " + this.label;
                    this.disabled = false;
                    this.showSpinner = false;
                    return false;
                });
        },
        async loadData() {
            this.input = "";
            this.showSpinner = true;
            this.disabled = true;
            this.placeholder = "Loading . . .";
            if (await this.getItems()) {
                this.input = this.value;
                if (this.showOthers) {
                    this.input = this.items[0].id;
                    this.showOthers = false;
                    this.showOthersSpinner = false;
                }
            }
        }
    },
    watch: {
        value() {
            this.input = this.value;
        },
    },
    created () {
        this.loadData();
    }
};
</script>

<style>
.required:after {
    content: " *";
    color: red;
}
</style>

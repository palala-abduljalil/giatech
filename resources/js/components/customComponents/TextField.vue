<template>
    <div>
        <label :class="{'required': labelAsterisk}">{{ label }}</label>
        <input
            v-validate="rules"
            :data-vv-as="errorLabel"
            :type="type"
            :name="name"
            :placeholder="placeholder"
            :value="input"
            :readonly="readonly"
            :ref="name"
            class="form-control"
            :class="{'is-invalid': errors.has(errorMessage)}"
            @input="handleInput($event.target.value)"
            @keyup.enter="onEnter"
        />
        <div class="invalid-feedback" v-if="errors.has(errorMessage)">
            {{ errors.first(errorMessage) }}
        </div>
    </div>
</template>

<script>
export default {
    inject: ['$validator'],
    props: {
        type: {
            type: String,
            default: 'text'
        },
        label: String,
        value: [String, Number],
        name: String,
        readonly: {
            type: Boolean,
            default: false
        },
        placeholder: String,
        rules: [String, Object],
        errorMessage: String,
        labelAsterisk: Boolean,
        errorLabel: String,
    },
    data() {
        return {
            input: "",
        };
    },
    methods: {
        handleInput(value) {
            if (this.value == undefined) {
                this.input = value;
            } else {
                this.input = value;
                this.$emit("input", value);
            }
        },
        onEnter(event) {
            this.$emit('submit-form');
        },
    },
    watch: {
        value() {
            this.input = this.value;
        }
    },
    created() {
        this.input = this.value;
    }
};
</script>

<style>
.required:after {
    content: " *";
    color: red;
}
</style>

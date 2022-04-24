<template>
    <div>
        <label :class="{'required': labelAsterisk}">{{ label }}</label>
        <textarea
            v-validate="rules"
            :data-vv-as="errorLabel"
            :name="name"
            :value="value"
            :placeholder="placeholder"
            :readonly="readonly"
            :class="{'is-invalid': errors.has(errorMessage)}"
            class="form-control"
            :rows="rows"
            @input="handleChange($event.target.value)"
        ></textarea>
        <div class="invalid-feedback" v-if="errors.has(errorMessage)">
            {{ errors.first(errorMessage) }}
        </div>
    </div>
</template>

<script>
export default {
    props: [
        "label",
        "value", 
        "name", 
        "readonly",
        "rows",
        "placeholder", 
        "rules", 
        "errorMessage",
        "errorLabel",
        "labelAsterisk",
    ],
    methods: {
        handleChange(event) {
            this.$emit("input", event);
        },
    },
    created () {
      this.$validator = this.$parent.$validator;
    }
};
</script>

<style></style>

<template>
<div class="">
    <input 
        type="text"
        class="form-control"
        :value="value"
        :name="name"
        :placeholder="placeholder"
        v-validate="rules"
        :data-vv-as="errorLabel"
        @input="handleChange($event.target.value)"
    >
    <div>
        {{ errors.first(name) }}
    </div>
</div>
  
</template>

<script>
export default {
    props: ['value', 'rules', 'name', 'placeholder', 'readonly', 'errorLabel', 'errorMessage'],
    data() {
        return {
            errorBag: ''
        }
    },
    methods: {
        handleChange(event) {
            this.$emit("input", event);
        },
    },
    created () {
        this.$validator = this.$parent.$validator;
    },
    // watch: {
    //     'errors'() {
    //         console.log('errors');
    //         this.errorBag = this.errors.has(this.errorMessage);
    //     }
    // }
}
</script>

<style>

</style>
<template>
    <div >
        <form
            ref="changePasswordForm"
            @submit.prevent="submitForm"
            v-if="showPage"
        >
            <input type="hidden" name="_method" value="PUT"/>
            <h5 class="mb-3 text-uppercase bg-light p-2">
                <i class="fas fa-lock mr-1"></i> Change Password
            </h5>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <text-field
                            label="Current Password"
                            name="currentPassword"
                            type="password"
                            :labelAsterisk="true"
                            rules='required|min:8|max:500'
                            errorMessage="currentPassword"
                            errorLabel="Current Password"
                            v-model="form.currentPassword"
                        />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="required">New Password</label>
                        <input 
                            v-validate="'required|min:8|max:500'" 
                            name="newPassword" 
                            type="password"
                            class="form-control"
                            :class="{'is-invalid': errors.has('newPassword')}"
                            ref="newPassword"
                            data-vv-as="Password"
                            v-model="form.newPassword"
                        >
                        <div class="invalid-feedback" v-if="errors.has('newPassword')">
                            {{ errors.first('newPassword') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="required">Confirm New Password</label>
                        <input 
                            v-validate="'required|min:8|max:500|confirmed:newPassword'" 
                            class="form-control" 
                            name="confirmedNewPassword" 
                            type="password" 
                            :class="{'is-invalid': errors.has('confirmedNewPassword')}"
                            data-vv-as="Password"
                            v-model="form.confirmedNewPassword"
                        >
                        <div class="invalid-feedback" v-if="errors.has('confirmedNewPassword')">
                            {{ errors.first('confirmedNewPassword') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-right">
                <button type="submit" class="btn btn-primary waves-effect waves-light mt-2 text-white">
                    <i class="fas fa-save mr-1"></i>
                    Save
                </button>
            </div>
        </form>
        <div class="alert alert-primary" v-if="!showPage" role="alert">
            Your password has been modified. Click to  
            <a 
                class="text-blue"
                href="#" 
                @click="resetFields">
                here
            </a> to modify it again.
        </div>
    </div>
</template>

<script>
import TextField from "../customComponents/TextField";
import { EventBus } from "../../EventBus";

export default {
    components: {
        TextField
    },
    data() {
        return {
            form: {
                currentPassword: '',
                newPassword: '',
                confirmedNewPassword: '',
            },
            showPage: true,
        }
    },
    methods: {
        async validate() {
            return this.$validator.validate().then((valid) => {
                return valid;
            });
        },
        async validateForm() {
            return await this.validate();
        },
        async submitForm() {
            var isValid = await this.validate();
            if (isValid) {
                this.$Progress.start();
                const data = new FormData(this.$refs.changePasswordForm);
                EventBus.$emit('show-spinner', true);
                axios.post(`/api/user-profile/change-password`, data)
                    .then((response) => {
                        Toast.fire({
                            icon: "success",
                            title: response.data.message,
                        });
                        this.showPage = false;
                        EventBus.$emit('show-spinner', false);
                        this.$Progress.finish();
                    })
                    .catch((error) => {
                        if (error.response.data.errors) {
                            var entries = Object.entries(
                                error.response.data.errors
                            );
                            this.errors.clear();
                            entries.forEach(function (item, index) {
                                this.errors.add({
                                    field: item[0],
                                    msg: item[1][0]
                                });
                            }, this);
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Form Submission Failed!',
                            text: 'Please check your inputs.'
                        });
                        EventBus.$emit('show-spinner', false);
                        console.log("Error: ", error);
                        this.$Progress.fail();
                    });
            } 
        },
        resetFields() {
            this.showPage = true;
            this.form = Object.assign({}, {
                currentPassword: "",
                newPassword: "",
                confirmedNewPassword: "",
            });
        }
    }
};
</script>

<style scoped>
</style>

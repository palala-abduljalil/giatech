<template>
    <section class="login-body">
        <form @submit.prevent="submitForm" method="post">
            <div
                class="alert alert-danger fade in alert-dismissible show"
                v-if="errorFields.length !== 0"
            >
                <button
                    type="button"
                    class="close"
                    data-dismiss="alert"
                    aria-label="Close"
                >
                    <span aria-hidden="true" style="font-size: 20px">×</span>
                </button>
                {{ errorFields[0][0] }}
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fas fa-user-alt"></i>
                    </div>
                </div>
                <input
                    v-model="form.username"
                    type="text"
                    name="username"
                    class="form-control"
                    :class="{ 'is-invalid': errors.has('username') }"
                    placeholder="Username"
                />
                <div class="invalid-feedback" v-if="errors.has('username')">
                    {{ errors.first("username") }}
                </div>
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
                <input
                    v-model="form.password"
                    :type="showPassword ? 'text' : 'password'"
                    name="password"
                    class="form-control"
                    :class="{ 'is-invalid': errors.has('password') }"
                    placeholder="Password"
                />
                <div class="invalid-feedback" v-if="errors.has('password')">
                    {{ errors.first("password") }}
                </div>
            </div>
            <div class="input-group mb-3">
                <div class="form-check">
                    <label class="form-check-label">
                        <input
                            type="checkbox"
                            class="form-check-input"
                            @change="displayPassword"
                        />
                        Show password
                    </label>
                </div>
            </div>
            <div class="text-center mt-2 mb-3">
                <button
                    type="submit"
                    class="btn btn-block btn-primary"
                    :disabled="isSubmitting"
                >
                    <span
                        v-show="isSubmitting"
                        class="spinner-border spinner-border-sm"
                        role="status"
                        aria-hidden="true"
                    ></span>
                    Login
                </button>
            </div>
        </form>
    </section>
</template>

<script>
export default {
    props: {
        errorFields: Array,
    },
    data() {
        return {
            showPassword: false,
            isSubmitting: false,
            checkBoxPassword: [],
            form: {
                username: "",
                password: "",
            },
        };
    },
    methods: {
        submitForm() {
            this.isSubmitting = true;
            this.$Progress.start();
            axios
                .post("login", this.form)
                .then(() => {
                    window.location.href = "/home";
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
                                msg: item[1][0],
                            });
                        }, this);
                    }
                    Toast.fire({
                        icon: "error",
                        title: "Some error occured! Please try again",
                    });
                    this.$Progress.fail();
                    this.isSubmitting = false;
                });
        },
        displayPassword() {
            this.showPassword = !this.showPassword;
        },
    },
};
</script>

<style scoped>
a {
    color: #4c81a4;
    display: block;
}

a:hover {
    color: #1c658c;
}

.btn-primary {
    background-color: #4c81a4;
}

.btn-primary:hover {
    background-color: #1c658c;
}
</style>

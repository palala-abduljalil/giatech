<template>
    <section class="pb-8 pt-10" id="contact">
        <v-container fluid>
            <v-row align="center" justify="center">
                <v-col cols="10">
                    <v-row justify="center">
                        <v-col
                            cols="12"
                            sm="5"
                            v-animate-onscroll="'animate__animated animate__fadeInLeft'"
                        >
                            <h1 class="font-weight-light display-1">
                                Contact Us
                            </h1>
                            <h3 class="font-weight-light mt-3">
                                You can connect with us as easy as 1 2 3.
                            </h3>
                            <h3 class="font-weight-light mt-3">
                                Landline: {{ landLine }}
                            </h3>
                            <h3 class="font-weight-light mt-3">
                                Mobile No.: {{ mobile }}
                            </h3>
                            <h3 class="font-weight-light mt-3">
                                Email: {{ emailAddress }}
                            </h3>
                        </v-col>
                        <v-col
                            cols="12"
                            sm="7"
                            v-animate-onscroll="'animate__animated animate__fadeInRight'"
                        >
                            <v-form
                                v-model="valid"
                                :lazy-validation="lazy"
                            >
                                <v-text-field
                                    v-model="name"
                                    :rules="nameRules"
                                    label="Name"
                                    required
                                ></v-text-field>

                                <v-text-field
                                    v-model="subject"
                                    :rules="subjectRules"
                                    label="Subject"
                                    required
                                ></v-text-field>

                                <v-text-field
                                    v-model="email"
                                    :rules="emailRules"
                                    label="E-mail"
                                    required
                                ></v-text-field>

                                <v-textarea
                                    v-model="textArea"
                                    :rules="textAreaRules"
                                    label="Message"
                                    required
                                />

                                <v-btn
                                    :disabled="!valid"
                                    color="primary"
                                    :dark="valid"
                                    rounded
                                    block
                                    class="mt-3"
                                    @click="submit"
                                >
                                    Submit
                                </v-btn>
                            </v-form>
                        </v-col>
                    </v-row>
                </v-col>
            </v-row>
        </v-container>
        <div class="svg-border-waves text-white">
            <v-img src="/landing-page/images/contact/borderWavesBlue.svg" />
        </div>
        <v-snackbar
            v-model="snackbar.enabled"
            timeout="3000"
            right
            top
            :color="snackbar.color"
        >
            {{ snackbar.text }}

            <template v-slot:action="{ attrs }">
                <v-btn
                    color="blue"
                    text
                    v-bind="attrs"
                    @click="snackbar = false"
                >
                    Close
                </v-btn>
            </template>
        </v-snackbar>
    </section>
</template>

<script>
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
Vue.use(Loading, {
    color: '#171b34',
    width: 64,
    height: 64,
    backgroundColor: '#ffffff',
    opacity: 0.5,
    zIndex: 999
});

export default {
    props: {
        emailAddress: String,
        landLine: String,
        mobile: String,
    },
    data() {
        return {
            valid: true,
            name: "",
            nameRules: [
                (v) => !!v || "The name field is required",
                (v) =>
                    (v && v.length >= 6) ||
                    "Name must be longer than 6 characters",
            ],
            subject: "",
            subjectRules: [
                (v) => !!v || "The subject field is required",
                (v) =>
                    (v && v.length >= 6) ||
                    "Subject must be longer than 6 characters",
            ],
            email: "",
            emailRules: [
                (v) => !!v || "The email field is required",
                (v) => /.+@.+\..+/.test(v) || "E-mail must be valid",
            ],
            textArea: "",
            textAreaRules: [
                (v) => !!v || "The text field is required",
                (v) => (v && v.length >= 10) || "Minimum of 10 characters",
            ],
            lazy: false,
            snackbar: {
                enabled: false,
                text: "",
                color: "",
            },
        };
    },
    methods: {
        submit() {
            let loader = this.$loading.show({
                loader: "dots",
                transition: "fade",
            });
            axios
                .post("/contact", {
                    name: this.name,
                    subject: this.subject,
                    email: this.email,
                    message: this.textArea,
                })
                .then((response) => {
                    Toast.fire({
                        icon: "success",
                        title: "You have successfully send your message!"
                    });
                    loader.hide();
                });
        },
    },
};
</script>

<style scoped lang="scss">
.svg-border-waves .v-image {
    position: absolute;
    bottom: 0;
    left: 0;
    height: 3rem;
    width: 100%;
    overflow: hidden;
}
@import url("https://fonts.googleapis.com/css?family=Poppins");
.v-application {
    .display-1 {
        font-family: "Poppins", serif !important;
    }
}
.before-enter {
    opacity: 0;
    transform: translateY(100px);
    transition: all 1.8s ease-out;
}
.enter {
    opacity: 1;
    transform: translateY(0px);
}
</style>

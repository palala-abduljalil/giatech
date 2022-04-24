<template>
    <v-app>
        <navigation :color="color" :flat="flat" />
        <v-main class="pt-0">
            <home :companyName="data.fullName" :companyMotto="data.motto" />
            <about
                :background="data.background"
                :mission="data.mission"
                :vision="data.vision"
            />
            <team :stakeholders="data.stakeholders" />
            <services
                :freebieDescription="data.freebieDescription"
                :freebies="data.freebies"
                :services="data.services"
                :description="data.serviceDescription"
            />
            <contact
                :emailAddress="data.emailAddress"
                :landLine="data.landlineNumber"
                :mobile="data.mobileNumber"
            />
        </v-main>
        <v-scale-transition>
            <v-btn
                fab
                v-show="fab"
                v-scroll="onScroll"
                dark
                fixed
                bottom
                right
                color="primary"
                @click="toTop"
            >
                <v-icon>mdi-arrow-up</v-icon>
            </v-btn>
        </v-scale-transition>
        <foote :socialMediaAccounts="data.socialMediaAccounts" />
    </v-app>
</template>

<script>
import Navigation from "./components/Navigation";
import Home from "./components/Home";
import About from "./components/About";
import Team from "./components/Team";
import Services from "./components/Services";
import Contact from "./components/Contact";
import Foote from "./components/Footer";

import VueAnimateOnScroll from "vue-animate-onscroll";
Vue.use(VueAnimateOnScroll);
import "animate.css";

import ScrollAnimation from "./directives/scrollanimation";
Vue.directive("scrollanimation", ScrollAnimation);

export default {
    props: {
        data: Object,
    },
    components: {
        Navigation,
        Home,
        About,
        Team,
        Services,
        Contact,
        Foote,
    },
    data() {
        return {
            color: "",
            flat: null,
            fab: null,
        };
    },
    methods: {
        onScroll(e) {
            if (typeof window === "undefined") return;
            const top = window.pageYOffset || e.target.scrollTop || 0;
            this.fab = top > 60;
        },
        toTop() {
            this.$vuetify.goTo(0);
        },
    },
    watch: {
        fab(value) {
            if (value) {
                this.color = "#171b34";
                this.flat = false;
            } else {
                this.color = "transparent";
                this.flat = true;
            }
        },
    },
    created() {
        const top = window.pageYOffset || 0;
        if (top <= 60) {
            this.color = "transparent";
            this.flat = true;
        }
    },
};
</script>

<style lang="scss" scoped>
@import url("https://fonts.googleapis.com/css?family=Poppins");
.v-main {
    background-image: url("/landing-page/images/bgMain.png");
    background-attachment: fixed;
    background-position: center;
    background-size: cover;
}
html,
body,
.v-application,
h1,
h2,
h3,
h4,
h5,
h6 {
    font-family: "Poppins", sans-serif !important;
}
</style>

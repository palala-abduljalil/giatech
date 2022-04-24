<template>
    <div>
        <v-navigation-drawer
            v-model="drawer"
            app
            temporary
            right
            dark
            src="/landing-page/images/navigation/bgDrawer.jpg"
        >
            <v-list>
                <v-list-item>
                    <v-list-item-avatar>
                        <v-img
                            src="/landing-page/images/navigation/logo.jpg"
                            alt="Logo"
                        >
                            <template v-slot:placeholder>
                                <v-row
                                    class="fill-height ma-0"
                                    align="center"
                                    justify="center"
                                >
                                    <v-progress-circular
                                        indeterminate
                                        color="grey lighten-5"
                                    ></v-progress-circular>
                                </v-row>
                            </template>
                        </v-img>
                    </v-list-item-avatar>
                    <v-list-item-content>
                        <v-list-item-title>GIA TECH</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list>

            <v-divider />

            <v-list dense>
                <v-list-item
                    v-for="([icon, text, link], i) in items"
                    :key="i"
                    link
                    @click="$vuetify.goTo(link)"
                >
                    <v-list-item-icon class="justify-center">
                        <v-icon>{{ icon }}</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title class="subtitile-1">{{
                            text
                        }}</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>

        <v-app-bar
            app
            :color="color"
            :flat="flat"
            dark
            class="px-15"
            :class="{ expand: flat }"
        >
            <v-toolbar-title>
                <v-img
                    src="/landing-page/images/navigation/logo.jpg"
                    max-width="50px"
                />
            </v-toolbar-title>
            <h2 class="ml-3" v-bind:style="{ fontSize: fontSize + 'px' }">
                GIA TECH
            </h2>
            <v-spacer />
            <v-app-bar-nav-icon
                @click.stop="drawer = !drawer"
                class="mr-4"
                v-if="isXs"
            />
            <div v-else>
                <v-btn text @click="$vuetify.goTo('#home')">
                    <span class="mr-2">Home</span>
                </v-btn>
                <v-btn text @click="$vuetify.goTo('#about', options)">
                    <span class="mr-2">About</span>
                </v-btn>
                <v-btn text @click="$vuetify.goTo('#team')">
                    <span class="mr-2">Team</span>
                </v-btn>
                <v-btn text @click="$vuetify.goTo('#services')">
                    <span class="mr-2">Services</span>
                </v-btn>
                <v-btn text @click="$vuetify.goTo('#contact')">
                    <span class="mr-2">Contact</span>
                </v-btn>
                <v-btn text @click="goToLogin">
                    <span class="mr-2">Login</span>
                </v-btn>
            </div>
        </v-app-bar>
    </div>
</template>

<script>
export default {
    props: {
        color: String,
        flat: Boolean,
    },
    data() {
        return {
            fontSize: 30,
            drawer: null,
            isXs: false,
            items: [
                ["mdi-home-outline", "Home", "#home"],
                ["mdi-information-outline", "About", "#about"],
                ["mdi-microsoft-teams", "Team", "#team"],
                ["mdi-toolbox-outline", "Services", "#services"],
                ["mdi-email-outline", "Contact", "#contact"],
                ["mdi-log-in", "Login", "/login"],
            ],
        };
    },
    methods: {
        onResize() {
            this.isXs = window.innerWidth < 890;
            if (window.innerWidth <= 440) {
                this.fontSize = 18;
            } else {
                this.fontSize = 30;
            }
        },
        goToLogin() {
            window.location.href = "/login";
        }
    },
    computed: {
        options() {
            return {
                offset: -60,
            };
        },
    },
    watch: {
        isXs(value) {
            if (!value) {
                if (this.drawer) {
                    this.drawer = false;
                }
            }
        },
    },
    mounted() {
        this.onResize();
        window.addEventListener("resize", this.onResize, { passive: true });
    },
};
</script>

<style scoped>
.v-toolbar {
    transition: 0.6s;
}

.expand {
    height: 80px !important;
    padding-top: 10px;
}
</style>

<template>
    <section id="home">
        <v-parallax dark src="landing-page/images/home/bgHero1.jpg" height="750">
            <v-row align="center" justify="center">
                <v-col cols="10">
                    <v-row align="center" justify="center">
                        <v-col cols="12" md="6" xl="8">
                            <h1
                                class="display-2 font-weight-bold mb-4"
                                v-bind:class="{ 'text-center': center }"
                                id="companyName"
                                v-scrollanimation
                            >
                                {{ companyName }}
                            </h1>
                            <h1
                                class="font-weight-light"
                                v-bind:class="{ 'text-center': center }"
                                id="companyMotto"
                                v-scrollanimation
                            >
                                {{ companyMotto }}
                            </h1>
                        </v-col>
                        <v-col
                            cols="12"
                            md="6"
                            xl="4"
                            class="hidden-sm-and-down"
                        ></v-col>
                    </v-row>
                </v-col>
            </v-row>
            <div class="svg-border-waves text-white">
                <v-img src="landing-page/images/home/borderWaves.svg" />
            </div>
        </v-parallax>

        <div class="svg-border-waves">
            <img src="landing-page/images/home/wave2.svg" />
        </div>
    </section>
</template>

<script>
export default {
    props: {
        companyName: String,
        companyMotto: String,
    },
    data() {
        return {
            center: false,
        };
    },
    methods: {
        onResize() {
            if (window.innerWidth <= 590) {
                this.center = true;
            } else {
                this.center = false;
            }
        },
    },
    mounted() {
        this.onResize();
        window.addEventListener("resize", this.onResize, { passive: true });
    },
};
</script>

<style lang="scss" scoped>
#companyName {
    transition-delay: 0.1s;
}
#companyMotto {
    transition-delay: 0.2s;
}
.svg-border-waves .v-image {
    position: absolute;
    bottom: 0;
    left: 0;
    height: 3rem;
    width: 100%;
    overflow: hidden;
}
#home {
    z-index: 0;
}
.svg-border-waves img {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    margin-bottom: -2px;
    z-index: -1;
}

section {
    position: relative;
}

@import url("https://fonts.googleapis.com/css?family=Poppins");
.v-application {
    .display-2 {
        font-family: "Poppins", serif !important;
    }
}

.before-enter {
    opacity: 0;
    transform: translateX(100px);
    transition: all 1.8s cubic-bezier(0.41, 0.01, 0.57, 1.61);
}

.enter {
    opacity: 1;
    transform: translateX(0px);
}
</style>

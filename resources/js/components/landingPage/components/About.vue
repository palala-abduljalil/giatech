<template>
    <section id="about">
        <v-container fluid>
            <div class="mt-15"></div>
            <v-row>
                <v-col
                    md="8"
                    offset-md="2"
                    class="mb-10"
                    v-animate-onscroll="'animate__animated animate__fadeInDown'"
                >
                    <h1 class="font-weight-bold display-2 text-center mb-5">
                        About
                    </h1>
                    <h3 class="font-weight-light text-center" id="background">
                        {{ background }}
                    </h3>
                </v-col>
            </v-row>
            <v-row align="center" justify="center">
                <v-col cols="10">
                    <v-row align="center" justify="center">
                        <v-col cols="12" md="7">
                            <v-row>
                                <div v-animate-onscroll="'animate__animated animate__fadeInUp '">
                                    <div>
                                        <h2>Mission</h2>
                                        <v-col
                                            cols="12"
                                            class="d-flex align-center"
                                        >
                                            <h3 class="text-justify font-weight-light">
                                                {{ mission }}
                                            </h3>
                                        </v-col>
                                    </div>
                                    <div>
                                        <h2 class="mt-10">Vision</h2>
                                        <v-col
                                            cols="12"
                                            class="d-flex align-center"
                                        >
                                            <h3 class="text-justify font-weight-light">
                                                {{ vision }}
                                            </h3>
                                        </v-col>
                                    </div>
                                </div>
                            </v-row>
                        </v-col>
                        <v-col cols="12" md="5" class="d-none d-md-flex">
                            <v-img
                                src="/landing-page/images/about/ill1.svg"
                                class="d-block ml-auto mr-auto"
                                max-width="400px"
                                v-animate-onscroll="'animate__animated animate__zoomIn'"
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
                        </v-col>
                    </v-row>
                </v-col>
            </v-row>
        </v-container>
    </section>
</template>

<script>
export default {
    props: {
        background: String,
        mission: String,
        vision: String,
    },
};
</script>

<style scoped>
#about {
    background-color: #f4f7f5;
}

h3,
#background {
    color: #6a7c92;
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

<template>
    <section id="services" class="mt-10">
        <v-container>
            <v-row align="center" justify="center" v-scrollanimation>
                <v-col cols="12">
                    <v-row align="center" justify="space-around">
                        <v-col cols="12" class="text-center mt-10">
                            <h1 class="font-weight-bold display-2 mb-5">
                                Our Services
                            </h1>
                            <h3
                                class="font-weight-light text-center"
                                id="description"
                            >
                                {{ description }}
                            </h3>
                        </v-col>
                    </v-row>
                </v-col>
            </v-row>
        </v-container>
        <v-row justify="center" v-scrollanimation class="ma-5">
            <v-col
                v-for="(service, i) in services"
                :key="i"
                class="ma-5"
                md="3"
                sm="5"
            >
                <v-hover v-slot:default="{ hover }">
                    <v-card
                        height="100%"
                        class="pa-10 ma-0"
                        :elevation="hover ? 10 : 4"
                        :class="{ up: hover }"
                        style="border: #171b34 2px solid"
                    >
                        <v-avatar size="128" style="border: blue 2px solid">
                            <img
                                alt="Avatar"
                                :src="service.coverImage.url"
                            />
                        </v-avatar>
                        <h1 class="font-weight-regular pt-10">
                            {{ service.title }}
                        </h1>
                        <p>{{ service.description }}</p>
                    </v-card>
                </v-hover>
            </v-col>
        </v-row>
        <v-container>
            <v-row align="center" justify="center" v-scrollanimation>
                <v-col cols="12">
                    <v-row align="center" justify="space-around">
                        <v-col cols="12" class="text-center mb-10 mt-10">
                            <h3
                                class="font-weight-light text-center blue--text"
                                id="description"
                            >
                                {{ freebieDescription }}
                            </h3>
                        </v-col>
                    </v-row>
                </v-col>
            </v-row>
            <v-row no-gutters justify="center">
                <v-col>
                    <v-timeline>
                        <v-timeline-item
                            v-for="(freebie, i) in freebies"
                            :key="i"
                            small
                        >
                            <template v-slot:opposite>
                                <span
                                    :class="`headline font-weight-bold blue--text`"
                                    v-text="freebie.name"
                                ></span>
                            </template>
                            <v-hover v-slot:default="{ hover }">
                                <v-card
                                    class="pa-1"
                                    color="#171b34"
                                    :elevation="hover ? 10 : 4"
                                    :class="{ up: hover }"
                                >
                                    <v-img
                                        :class="{ 'zoom-efect': hover }"
                                        class="d-block ml-auto mr-auto"
                                        width="500"
                                        height="300"
                                        style="border: 2px solid"
                                        :src="freebie.coverImage.url"
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
                                </v-card>
                            </v-hover>
                        </v-timeline-item>
                    </v-timeline>
                </v-col>
            </v-row>
        </v-container>
    </section>
</template>

<style lang="scss" scoped>
#services {
    background-color: #f4f4f4;
}

@import url("https://fonts.googleapis.com/css?family=Poppins");
.v-application {
    .headline,
    .title {
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

<script>
export default {
    props: ["services", "description", "freebies", "freebieDescription"],
};
</script>

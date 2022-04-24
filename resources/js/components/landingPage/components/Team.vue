<template>
    <section id="team">
        <v-container fluid id="features" class="mt-15" v-scrollanimation>
            <v-row align="center" justify="center">
                <v-col cols="10">
                    <v-row align="center" justify="space-around">
                        <v-col cols="12" class="text-center mb-10">
                            <h1 class="font-weight-bold display-2">
                                Meet Our Team
                            </h1>
                        </v-col>
                    </v-row>
                </v-col>
            </v-row>
            <v-row no-gutters justify="center">
                <v-col
                    v-for="(stakeholder, index) in stakeholders"
                    :key="index"
                    class="ma-5 text-center"
                    cols="12"
                    md="3"
                    sm="5"
                >
                    <v-hover v-slot:default="{ hover }">
                        <v-card
                            height="100%"
                            class="pa-5"
                            :elevation="hover ? 10 : 4"
                            :class="{ up: hover }"
                        >
                            <v-avatar size="128" style="border: 2px solid">
                                <img
                                    alt="Avatar"
                                    :src="stakeholder.employee.profilePicture.url"
                                />
                            </v-avatar>
                            <h1 class="font-weight-regular pt-10">
                                {{ stakeholder.employee.name }}
                            </h1>
                            <p>{{ stakeholder.employee.position.name }}</p>
                            <v-btn :href="stakeholder.linkedInLink" icon
                                ><v-icon size="24px" color="primary"
                                    >mdi-linkedin</v-icon
                                ></v-btn
                            >
                        </v-card>
                    </v-hover>
                </v-col>
            </v-row>
        </v-container>
    </section>
</template>

<script>
export default {
    props: {
        stakeholders: Array,
    },
};
</script>

<style scoped>
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

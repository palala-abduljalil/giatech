<template>
    <v-footer dark padless>
        <v-card flat tile class="blueColor white--text text-center">
            <v-card-text>
                <v-btn
                    v-for="(social, index) in socialMediaAccounts"
                    :key="index"
                    class="mx-4 white--text"
                    :href="social.link"
                    target="_blank"
                    icon
                >
                    <v-icon size="24px">mdi-{{ social.name }}</v-icon>
                </v-btn>
            </v-card-text>

            <v-card-text class="white--text pt-0">
                Check our social media account above for inquiries and concerns.
            </v-card-text>

            <v-divider></v-divider>

            <v-card-text class="white--text">
                {{ new Date().getFullYear() }} —
                <strong>GIA Tech All Rights Reserved</strong>
            </v-card-text>
        </v-card>
    </v-footer>
</template>

<style scoped>
.v-card {
    width: 100%;
}
.blueColor {
    background-color: #171b34;
}
</style>

<script>
export default {
    props: {
		socialMediaAccounts: Array,
	},
};
</script>

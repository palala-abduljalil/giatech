<template>
    <span v-if="isLoad">
        <img
            :src="companyLogo"
            alt="The Logo"
            class="brand-image elevation-3"
            style="opacity: 0.8"
        />
        <span class="brand-text font-weight-light">
            {{ companyName }}
        </span>
    </span>
</template>

<script>
import { EventBus } from "../../EventBus";
export default {
    data() {
        return {
            companyName: '',
            companyLogo: '',
            isLoad: false,
        }
    },
    methods: {
        getCompany() {
            axios
                .get("/api/company")
                .then((response) => {
                    this.companyName = response.data.abbreviatedName;
                    this.companyLogo = response.data.logo.url;
                    this.isLoad = true;
                })
                .catch((error) => {
                    Toast.fire({
                        icon: "error",
                        title: "Some error occured! Please try again",
                    });
                    this.isLoad = false;
                    console.log("Error: ", error);
                });
        }
    },
    mounted() {
        this.getCompany();
        EventBus.$on("set-company-logo", (companyName, companyLogo) => {
            this.companyName = companyName;
            this.companyLogo = companyLogo;
        });
    }
};
</script>

<style></style>

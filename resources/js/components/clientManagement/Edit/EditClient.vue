<template>
    <div>
        <div v-if="isLoad">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-xl-4">
                        <div class="card-box text-center">
                            <img
                                :src="`${client.profilePicture.url}`"
                                class="rounded-circle avatar-xl img-thumbnail"
                                alt="profile-image"
                            />

                            <h4 class="mb-2">
                                {{ client.name }}
                            </h4>

                            <edit-client-avatar name="image" :client-id="client.id"/>

                            <div class="mt-3 text-left">
                                <span class="text-muted font-weight-bold">
                                    <i class="fas fa-user mr-1"></i> Full Name
                                </span>
                                <p class="text-muted font-13">
                                    {{ client.fullName }}
                                </p>
                                <hr />

                                <span class="text-muted font-weight-bold">
                                    <i class="fas fa-envelope mr-1"></i> E-Mail
                                    Address
                                </span>
                                <p class="text-muted font-13">
                                    {{ client.emailAddress.emailAddress }}
                                </p>
                                <hr />

                                <span class="text-muted font-weight-bold">
                                    <i class="fas fa-address-card mr-1"></i>
                                    Contact Number
                                </span>
                                <p class="text-muted font-13">
                                    {{ client.contactNumber.contactNumber }}
                                </p>
                                <hr />

                                <span class="text-muted font-weight-bold">
                                    <i class="fas fa-building mr-1"></i>
                                    Organization
                                </span>
                                <p class="text-muted font-13">
                                    {{ client.organization.name }}
                                </p>
                                <hr />

                                <span class="text-muted font-weight-bold">
                                    <i class="fas fa-map-marker mr-1"></i>
                                    Address
                                </span>
                                <p class="text-muted font-13">
                                    {{ client.address.fullAddress }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <loader v-if="showSpinner" />
                    <div class="col-lg-8 col-xl-8">
                        <div class="card-box">
                            <edit-client-about-me :data="client" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import EditClientAboutMe from "./EditClientAboutMe/EditClientAboutMe";
import Loader from "../../customComponents/Loader";
import EditClientAvatar from "./EditClientAboutMe/EditClientAvatar";
import { EventBus } from "../../../EventBus";

export default {
    props: {
        clientId: Number,
    },
    components: {
        Loader,
        EditClientAboutMe,
        EditClientAvatar,
    },
    data() {
        return {
            isLoad: false,
            showSpinner: false,
            client: {},
        };
    },
    methods: {
        getClient() {
            axios
                .get(`/api/client/${this.clientId}`)
                .then((response) => {
                    this.client = response.data;
                    this.isLoad = true;
                })
                .catch((error) => {
                    Toast.fire({
                        icon: "error",
                        title: "Error! " + error.message,
                    });
                    console.log("Error: ", error);
                });
        },
    },
    mounted() {
        this.getClient();
        EventBus.$on("set-client-profile-picture-preview", (data) => {
            this.client.profilePicture.url = data;
        });
        EventBus.$on("show-spinner", (data) => {
            this.showSpinner = data;
        });
        EventBus.$on(
            "hide-spinner", (
                data,
                fullName,
                name,
                emailAddress,
                contactNumber,
                organization,
                address
            ) => {
                this.showSpinner = data;
                this.client.fullName = fullName;
                this.client.name = name;
                this.client.emailAddress.emailAddress = emailAddress;
                this.client.contactNumber.contactNumber = contactNumber;
                this.client.organization.name = organization;
                this.client.address.fullAddress = address;
            });
    },
};
</script>

<style lang="scss" scoped>
.card-box {
    background-color: #fff;
    background-clip: border-box;
    border: 1px solid #e7eaed;
    padding: 1.5rem;
    margin-bottom: 24px;
    border-radius: 0.25rem;
}
.avatar-xl {
    height: 6rem;
    width: 6rem;
}
.rounded-circle {
    border-radius: 50% !important;
}
.nav-pills .nav-link.active,
.nav-pills .show > .nav-link {
    color: #fff;
    background-color: #007bff;
}
.nav-pills .nav-link {
    border-radius: 0.25rem;
}
.navtab-bg li > a {
    background-color: #f7f7f7;
    margin: 0 5px;
}
.nav-pills > li > a,
.nav-tabs > li > a {
    color: #6c757d;
    font-weight: 600;
}
.mb-4,
.my-4 {
    margin-bottom: 2.25rem !important;
}
.tab-content {
    padding: 20px 0 0 0;
}
.progress-sm {
    height: 5px;
}
.m-0 {
    margin: 0 !important;
}
</style>

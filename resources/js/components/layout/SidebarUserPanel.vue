<template>
    <div class="user-panel mt-3 pb-3 mb-3 d-flex" v-if="isLoad">
        <div class="image">
            <img
                :src="user.profilePicture.url"
                class="img-circle elevation-2"
                alt="User Image"
            />
        </div>
        <div class="info">
            {{ user.name }}
            <span class="d-block text-muted">
                {{ user.position.name }}
            </span>
        </div>
    </div>
</template>

<script>
import { EventBus } from "../../EventBus";
export default {
    props: {
        data: Object,
    },
    data() {
        return {
            user: null,
            isLoad: false,
        };
    },
    watch: {
        user() {
            this.isLoad = true;
            EventBus.$emit("set-user", this.user);
        },
    },
    mounted() {
        this.user = this.data;
        EventBus.$on("set-profile-picture-preview", (data, id) => {
            if (this.user.id == id) {
                this.user.profilePicture.url = data;
            }
        });
        EventBus.$on("set-user-panel-name", (name, position) => {
            this.user.name = name;
            this.user.position.name = position;
        });
    },
};
</script>

<style></style>

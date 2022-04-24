<template>
    <span v-if="isLoad">
        <span class="user-img">
            <img :src="url" alt="">
        </span>
        <span>{{ name }}</span>
    </span>
</template>

<script>
import { EventBus } from "../../EventBus";
export default {
    data() {
        return {
            name: '',
            url: '',
            user: {},
            isLoad: false
        }
    },
    mounted() {
        EventBus.$on('set-user', data => {
            this.user = data;
            this.name = data.name;
            this.url = data.profilePicture.url;
        });
        EventBus.$on('set-profile-picture-preview', (data, id) => {
            if (this.user.id == id) {
                this.url = data;
            }
        });
        EventBus.$on('set-user-panel-name', (data) => {
            this.name = data;
        });
        this.isLoad = true;
    }
}
</script>

<style>

</style>
<template>
    <div>
        <input
            id="fileInput"
            class="form-control"
            type="file"
            ref="fileInput"
            accept="image/png, image/gif, image/jpeg"
            v-validate="rules"
            :name="name"
            :data-vv-as="errorLabel"
            @change="fileSelected"
            style="display: none"
        />
        <button
            @click="$refs.fileInput.click()"
            type="button"
            class="btn btn-primary text-white btn-xs waves-effect mb-2 waves-light"
        >
            Update Profile Picture
        </button>
        <div class="avatar-invalid-feedback" v-if="errors.has(errorMessage)">
            {{ errors.first(errorMessage) }}
        </div>
    </div>
</template>

<script>
import { EventBus } from "../../../../EventBus";
export default {
    props: ["name", "errorMessage", "rules", "errorLabel", "url", "clientId"],
    data() {
        return {
            value: File,
        };
    },
    methods: {
        fileSelected(e) {
            var message = "";
            var title = "";
            if (e.target.files.length != 0) {
                this.value = e.target.files[0];
                let imageType = e.target.files[0].type;
                if (
                    imageType === "image/jpeg" ||
                    imageType === "image/jpg" ||
                    imageType === "image/png"
                ) {
                    if (this.toKiloBytes(e.target.files[0].size) <= 2048) {
                        this.$emit("input", e.target.files[0]);
                        let reader = new FileReader();
                        reader.readAsDataURL(e.target.files[0]);
                        reader.onload = (e) => {
                            EventBus.$emit(
                                "set-client-profile-picture-preview",
                                e.target.result
                            );
                        };
                    } else {
                        title = "Invalid File Size!";
                        message = "The file must be less than or equal to 2mb";
                    }
                } else {
                    title = "Invalid File Extension!";
                    message =
                        "The extension of the file must be in .jpg, .jpeg, or .png.";
                }
            }
            if (message.length != 0) {
                Swal.fire({
                    icon: "error",
                    title: title,
                    text: message,
                });
                if (this.$refs.inputReference) {
                    this.$refs.inputReference.value = "";
                }
            } else {
                this.updateAvatar();
            }
        },
        updateAvatar() {
            const config = {
                headers: { "Content-Type": "multipart/form-data" },
            };
            var data = new FormData();
            data.append("image", this.value);
            data.append("_method", "PUT");
            axios
                .post(`/api/client/${this.clientId}/update-avatar`, data, config)
                .then((response) => {
                    if (response.data.message != 0) {
                        Toast.fire({
                            icon: "success",
                            title: response.data.message,
                        });
                    }
                })
                .catch((error) => {
                    Toast.fire({
                        icon: "error",
                        title: "Error! " + error.message,
                    });
                    console.log("Error: ", error);
                });
        },
        toKiloBytes(size) {
            return size / 1024;
        },
        initValidator() {
            this.$validator.localize("en", {
                custom: {
                    image: {
                        mimes: "The extension of the file must be in .jpg, .jpeg, or .png.",
                    },
                },
            });
        },
    },

    created() {
        this.$validator = this.$parent.$validator;
    },
};
</script>

<style lang="scss" scoped>
.avatar-invalid-feedback {
    width: 100%;
    margin-top: 0.25rem;
    font-size: 100%;
    color: #dc3545;
    text-align: center;
    font-weight: bold;
}
</style>

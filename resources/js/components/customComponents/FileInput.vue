<template>
    <div>
        <label>{{ label }}</label>
        <div class="form-group" v-show="show">
            <div class="custom-file">
                <input
                    v-validate="rules"
                    :name="name"
                    type="file"
                    ref="inputReference"
                    class="custom-file-input"
                    :data-vv-as="errorLabel"
                    :class="{'is-invalid': errors.has(errorMessage)}"
                    accept="image/png, image/gif, image/jpeg"
                    @change="fileSelected"
                    :disabled="disabled"
                />
                <label class="custom-file-label" :for="id">
                    {{ fileLabel }}
                </label>
                <div class="invalid-feedback" v-if="errors.has(errorMessage)">
                    {{ errors.first(errorMessage) }}
                </div>
            </div>
        </div>
        <div class="form-group">
            <img :src="filePreview" class="img-fluid coverImageHeight" />
        </div>
    </div>
</template>

<script>
import { EventBus } from "../../EventBus";
export default {
    props: [
        "id",
        "label",
        "name",
        "show",
        "rules",
        "errorMessage",
        "errorLabel",
        "imagePreview",
        "imageLabel",
        "disabled",
    ],
    data() {
        return {
            value: File,
            filePreview: "",
            fileLabel: "",
        }
    },
    methods: {
        fileSelected(e) {
            var message = "";
            var title = "";
            if (e.target.files.length != 0) {
                this.value = e.target.files[0];
                let imageType = e.target.files[0].type;
                if (imageType.search("image") != -1) {
                    if (this.toKiloBytes(e.target.files[0].size) <= 2048) {
                        this.$emit('input', e.target.files[0]);
                        this.fileLabel = e.target.files[0].name;
                        let reader = new FileReader();
                        reader.readAsDataURL(e.target.files[0]);
                        reader.onload = (e) => {
                            this.filePreview = e.target.result;
                        };
                    }  else {
                        title = "Invalid File Size!";
                        message = "The file must be less than or equal to 2mb";
                    }
                } else {
                    title = "Invalid File Extension!";
                    message = "The extension of the file must be in .jpg, .jpeg, or .png.";
                }
            }
            if (message.length != 0) {
                Swal.fire({
                    icon: 'error',
                    title: title,
                    text: message
                })
                this.$refs.inputReference.value = "";
            }
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
    mounted() {
        EventBus.$on("set-file-input", (imagePreview, imageLabel) => {
            this.$refs.inputReference.value = "";
            this.filePreview = imagePreview;
            this.fileLabel = imageLabel;
        });
        this.filePreview = this.imagePreview;
        this.fileLabel = this.imageLabel;
        this.initValidator();
    },
};
</script>

<style>
.coverImageHeight {
    height: 200px;
}
</style>

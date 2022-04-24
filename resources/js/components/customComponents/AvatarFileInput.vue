<template>
    <div>
        <div class="form-group">
            <div class="avatar-wrapper">
                <img class="profile-pic" :src="filePreview" />
                <div class="upload-button" @click="$refs.fileInput.click()">
                    <i class="fa fa-arrow-circle-up" aria-hidden="true"></i>
                </div>
                <input
                    class="file-upload form-control"
                    type="file"
                    ref="fileInput"
                    accept="image/png, image/gif, image/jpeg"
                    v-validate="rules"
                    :class="{'is-invalid': errors.has(errorMessage)}"
                    :name="name"
                    :data-vv-as="errorLabel"
                    @change="fileSelected"
                />
            </div>
        </div>
        <div class="avatar-invalid-feedback" v-if="errors.has(errorMessage)">
            {{ errors.first(errorMessage) }}
        </div>
    </div>
</template>

<script>
export default {
    props: ["name", "errorMessage", "rules", "errorLabel"],
    data() {
        return {
            value: File,
            filePreview: "/profile-pictures/default.png",
        }
    },
    methods: {
        fileSelected(e) {
            var message = "";
            var title = "";
            if (e.target.files.length != 0) {
                this.value = e.target.files[0];
                let imageType = e.target.files[0].type;
                if (imageType === 'image/jpeg' || 
                    imageType === 'image/jpg' || 
                    imageType === 'image/png') {
                    if (this.toKiloBytes(e.target.files[0].size) <= 2048) {
                        this.$emit('input', e.target.files[0]);
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
                });
                if (this.$refs.inputReference) {
                    this.$refs.inputReference.value = "";
                }
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
        // this.initValidator();
    },
};
</script>

<style lang="scss" scoped>
.avatar-wrapper{
	position: relative;
	height: 200px;
	width: 200px;
	margin: 20px auto;
	border-radius: 50%;
    overflow: hidden;
	box-shadow: 1px 1px 15px -5px black;
	transition: all .3s ease;
	&:hover{
		transform: scale(1.05);
		cursor: pointer;
	}
	&:hover .profile-pic{
		opacity: .5;
	}
	.profile-pic {
    height: 100%;
		width: 100%;
		transition: all .3s ease;
		&:after{
			font-family: "Font Awesome 5 Free";
			content: "\f007";
			top: 0; left: 0;
			width: 100%;
			height: 100%;
			position: absolute;
			font-size: 190px;
			background: #ecf0f1;
			color: #34495e;
			text-align: center;
		}
	}
	.upload-button {
		position: absolute;
		top: 0; left: 0;
		height: 100%;
		width: 100%;
		.fa-arrow-circle-up{
			position: absolute;
			font-size: 234px;
			top: -17px;
			left: -17px;
			opacity: 0;
			transition: all .3s ease;
			color: #34495e;
		}
		&:hover .fa-arrow-circle-up{
			opacity: .9;
		}
	}
}

.avatar-invalid-feedback {
    width: 100%;
    margin-top: 0.25rem;
    font-size: 100%;
    color: #dc3545;
    text-align: center;
    font-weight: bold;
}
</style>

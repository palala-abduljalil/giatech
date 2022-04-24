<template>
    <div id="attachmentsSection">
        <div id="listOfAttachments" class="card">
            <div class="card-header">
                <h1 class="card-title font-weight-bold">
                    <i class="fas fa-list-alt mr-1"></i>
                    Attachments <span class="mr-1"></span>|
                    <span class="text-primary ml-1">
                        <span v-if="attachments.length != 0">
                            {{ attachments.length }}
                        </span>
                        Total Attachments
                    </span>
                </h1>
            </div>
            <div class="card-body">
                <loader v-if="showLoader" />
                <list 
                    :items="attachments"
                    :invalid-files="fileError"
                    :headers="headers"
                    @onRemove="removeAttachment($event)"
                    @onInputFileChange="handleChange($event)"
                />
            </div>
        </div>
    </div>
</template>

<script>
import Loader from "../../../customComponents/Loader";
import { EventBus } from "../../../../EventBus";
import List from "./List";

export default {
    components: {
        Loader,
        List,
    },
    data() {
        return {
            headers: [
                { text: "No", value: "index" },
                { text: "Name", value: "name" },
                { text: "Size", value: "size" },
                { text: "Actions", value: "action", sortable: false },
            ],
            showLoader: false,
            attachments: [],
            filePaths: [],
            fileError: [],
        };
    },
    methods: {
        handleChange(e) {
            const keys = Object.keys(e);
            if (this.fileError.length != 0) {
                this.fileError.splice(0);
            }
            const allowedExtensions = 
            /(\.jpg|\.jpeg|\.png|\.doc|\.docx|\.xls|\.xlsx|\.pdf|\.txt)$/i;
            const maxSizeInMb = 2;
            var isValid = false;

            keys.forEach((key) => {
                if (allowedExtensions.exec(e[key].name)) {
                    if (this.toMB(e[key].size) < maxSizeInMb) {
                        isValid = true;
                        this.filePaths.push(e[key]);
                        this.attachments.push({
                            name: e[key].name,
                            size: this.fileSizeConvert(e[key].size),
                        });
                    }  else {
                        this.fileError.push({
                            name: e[key].name,
                            description: ": File size must be less than 2MB.",
                        });
                    }
                }  else {
                    this.fileError.push({
                        name: e[key].name,
                        description: ": Invalid File Format.",
                    });
                }
            });
            if (isValid) {
                this.attachments = this.insertIndexes(this.attachments);
                EventBus.$emit('get-attachments', this.filePaths);
            }
        },
        removeAttachment(index) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes",
            }).then((result) => {
                if (result.value) {
                    this.$Progress.start();
                    this.showLoader = true;
                    this.attachments.splice(index, 1);
                    this.filePaths.splice(index, 1);
                    this.$Progress.finish();
                    this.showLoader = false;
                    this.attachments = this.insertIndexes(this.attachments);
                    EventBus.$emit("get-attachments", this.filePaths);
                    Toast.fire({
                        icon: "success",
                        title: "Successfully Removed!",
                    });
                }
            });
        },
        insertIndexes(item) {
            item = item.map((items, index) => ({
                ...items,
                index: index,
            }));
            return item;
        },
        toMB(size) {
            return (size / 1024 ** 2).toFixed(3);
        },
        fileSizeConvert(bytes, decimals = 2) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const dm = decimals < 0 ? 0 : decimals;
            const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
        }
    },
};
</script>

<style lang="scss" scoped>
.card-title {
    margin-bottom: 0px;
}
.v-card__title {
    display: block;
}
</style>

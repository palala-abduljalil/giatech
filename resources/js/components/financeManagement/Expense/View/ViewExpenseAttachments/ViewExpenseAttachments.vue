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
                    :headers="headers"
                    :invalidFiles="fileError"
                    @onInputFileChange="handleChange($event)"
                    @onView="viewAttachment($event)"
                    @onDownload="downloadAttachment($event)"
                    @onRemove="removeAttachment($event)"
                />
            </div>
        </div>
    </div>
</template>

<script>
import Loader from "../../../../customComponents/Loader";
import List from "./List";

export default {
    props: {
        expenseId: Number,
    },
    components: {
        Loader,
        List,
    },
    data() {
        return {
            headers: [
                { text: "No", value: "index" },
                { text: "Name", value: "fileName" },
                { text: "Size", value: "size" },
                { text: "Actions", value: "action", sortable: false },
            ],
            showLoader: false,
            attachments: [],
            fileError: [],
        };
    },
    methods: {
        handleChange(e) {
            if (this.fileError.length != 0) {
                this.fileError.splice(0);
            }
            const keys = Object.keys(e);
            var files = new FormData();
            var isValid = false;
            const allowedExtensions =
                /(\.jpg|\.jpeg|\.png|\.doc|\.docx|\.xls|\.xlsx|\.pdf|\.txt)$/i;
            const maxSizeInMb = 2;

            keys.forEach((key, index) => {
                if (allowedExtensions.exec(e[key].name)) {
                    if (this.toMB(e[key].size) < maxSizeInMb) {
                        files.append("files[]", e[key]);
                        isValid = true;
                    } else {
                        this.fileError.push({
                            name: e[key].name,
                            description: ": File size must be less than 2MB.",
                        });
                    }
                } else {
                    this.fileError.push({
                        name: e[key].name,
                        description: ": Invalid File Format.",
                    });
                }
            });
            if (isValid) {
                this.addAttachments(files);
            }
        },
        addAttachments(files) {
            this.showLoader = true;
            const config = {
                headers: { "Content-Type": "multipart/form-data" },
            };
            axios
                .post(`/api/expense/${this.expenseId}/attachment`, files, config)
                .then((response) => {
                    this.getAttachments();
                    Toast.fire({
                        icon: "success",
                        title: response.data.message,
                    });
                    this.$Progress.finish();
                })
                .catch((error) => {
                    if (error.response.data.errors) {
                        var entries = Object.entries(
                            error.response.data.errors
                        );
                        this.errors.clear("form");
                        entries.forEach(function (item, index) {
                            this.errors.add({
                                field: item[0],
                                msg: item[1][0],
                                scope: "form",
                            });
                        }, this);
                    }
                    Swal.fire({
                        icon: "error",
                        title: "Form Submission Failed!",
                        text: "Please check your inputs.",
                    });
                    console.log("Error: ", error);
                    this.$Progress.fail();
                });
        },
        removeAttachment(item) {
            this.showLoader = true;
            axios
                .delete(`/api/expense/${this.expenseId}/attachment/${item.uuid}`)
                .then(() => {
                    this.getAttachments();
                    Toast.fire({
                        icon: "success",
                        title: "Attachment Removed.",
                    });
                    if (this.attachments.length != 0) {
                        this.attachments = this.insertIndexes(this.attachments);
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
        getAttachments() {
            axios
                .get(`/api/expense/${this.expenseId}/attachment`)
                .then((response) => {
                    this.attachments = response.data;
                    if (this.attachments.length != 0) {
                        this.attachments = this.insertIndexes(this.attachments);
                    }
                    this.showLoader = false;
                })
                .catch((error) => {
                    Toast.fire({
                        icon: "error",
                        title: "Error! " + error.message,
                    });
                    console.log("Error: ", error);
                    this.showLoader = false;
                });
        },
        downloadAttachment(item) {
            try {
                var fileURL = item.url;
                var fileLink = document.createElement('a');
                fileLink.href = fileURL;
                fileLink.setAttribute('download', item.fileName);
                document.body.appendChild(fileLink);
                fileLink.click();
            } catch (error) {
                Toast.fire({
                    "icon": "error",
                    "title": "Error!" + error.message 
                });
            }
        },
        viewAttachment(item) {
            window.open(item.url, "_blank");
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
    },
    mounted() {
        this.getAttachments();
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
.v-alert {
    font-size: 14px;
}
</style>

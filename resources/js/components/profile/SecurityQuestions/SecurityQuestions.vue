<template>
    <div v-if="isPageLoad">
        <div class="card">
            <div class="card-header">
                <security-question-header 
                    :length="list.length"
                    :text="`${this.TITLE}(s)`"
                />
            </div>
            <div class="card-body">
                <loader v-show="showListLoader" />
                <security-question-list :items="list"
                    @onEdit="openModal($event, 'edit')"
                />
            </div>
        </div>
        <modal 
            ref="modal"
            :modalTitle="`Edit ${TITLE}`"
            submitButtonText="Update"
            :data="item"
            action="PUT"
            @onSubmit="submitForm"
        />
    </div>
</template>

<script>
import Loader from "../../customComponents/Loader";
import { EventBus } from "../../../EventBus";
import SecurityQuestionList from "./SecurityQuestionList";
import SecurityQuestionHeader from "./SecurityQuestionsHeader";
import Modal from "./Modal/Modal";

export default {
    components: {
        Loader,
        SecurityQuestionList,
        SecurityQuestionHeader,
        Modal,
    },
    data() {
        return {
            TITLE: 'Security Question',
            MODAL_ID: '#securityQuestionModal',
            AXIOS_URL: 'api/user',
            isPageLoad: false,
            method: "",
            modalTitle: "",
            submitButton: "",
            showListLoader: "",
            list: [],
            item: {},
        };
    },
    methods: {
        openModal(item) {
            $(this.MODAL_ID).modal("show");
            this.item = Object.assign({}, item);
            let notInclude = this.list.filter(i => i.question_id != this.item.question_id);
            EventBus.$emit('open-modal', notInclude);
        },
        submitForm() {
            this.updateItem();
        },
        updateItem() {
            this.$validator.validateAll("form").then((valid) => {
                if (valid) {
                    var form = new FormData(this.$refs.modal.$refs.myForm);
                    form.append('id', this.item.id);
                    const userID = this.$gate.getUserID(); 
                    this.$Progress.start();
                    EventBus.$emit("show-modal-button-spinner", true);
                    this.showListLoader = true;
                    axios
                        .post(`/api/user-profile/change-security-question`, form)
                        .then((response) => {
                            this.getItems();
                            Toast.fire({
                                icon: "success",
                                title: response.data.message,
                            });
                            $(this.MODAL_ID).modal("hide");
                            EventBus.$emit("show-modal-button-spinner", false);
                            this.showListLoader = false;
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
                                        scope: 'form'
                                    });
                                }, this);
                            }
                            Toast.fire({
                                icon: "error",
                                title: "Error! " + error.message,
                            });
                            console.log("Error: ", error);
                            EventBus.$emit("show-modal-button-spinner", false);
                            this.showListLoader = false;
                            this.$Progress.fail();
                        });
                }
            });
        },
        formReset() {
            this.item = Object.assign({}, {});
            this.$validator.reset();
        },
        getItems() {
            const id = this.$gate.getUserID();
            axios
                .get(`/${this.AXIOS_URL}/${id}/security-question`)
                .then((response) => {
                    this.list = response.data;
                    if (this.list.length != 0) {
                        this.insertIndexes();
                    }
                    this.isPageLoad = true;
                })
                .catch((error) => {
                    Toast.fire({
                        icon: "error",
                        title: "Error! " + error.message,
                    });
                    console.log("Error: ", error);
                })
                .finally(() => {
                    this.$PageLoad.stop();
                });
        },
        insertIndexes() {
            this.list = this.list.map(
                (items, index) => ({
                    ...items,
                    index: index + 1,
                })
            );
        },
    },
    mounted() {
        this.getItems();
    },
};
</script>

<style lang="scss" scoped>
.card-title {
    margin-bottom: 0px;
}
.modal-open {
    overflow: hidden;
    padding-right: 0 !important;
}
</style>

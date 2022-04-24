<template>
    <div id="securityQuestionsSection">
        <div id="listOfSecurityQuestions" class="card">
            <div class="card-header">
                <h1 class="card-title font-weight-bold">
                    <i class="fas fa-list-alt mr-1"></i>
                    Security Questions
                    <span v-if="items.length != 0" class="ml-1">
                        |
                        <span class="text-primary ml-1">
                            {{ items.length }}
                            Total Security Questions
                        </span>
                    </span>
                </h1>
            </div>
            <div class="card-body">
                <loader v-show="showLoader" />
                <list :items="items" @onEdit="openModal($event)" />
            </div>
        </div>
        <security-question-modal
            :item="item"
            :user-id="userId"
            @onUpdateSuccess="getSecurityQuestions"
        />
    </div>
</template>

<script>
import Loader from "../../../customComponents/Loader";
import SecurityQuestionModal from "./Modal/SecurityQuestionModal";
import List from "./List";
import { EventBus } from "../../../../EventBus";

export default {
    props: {
        userId: Number,
    },
    components: {
        Loader,
        SecurityQuestionModal,
        List,
    },
    data() {
        return {
            showLoader: false,
            items: [],
            item: {},
        };
    },
    methods: {
        openModal(item) {
            $("#modal").modal("show");
            this.item = Object.assign({}, item);
            let notInclude = this.items.filter((i) => i.id != this.item.id);
            EventBus.$emit("open-modal", notInclude);
        },
        getSecurityQuestions() {
            this.showLoader = true;
            axios
                .get(`/api/user/${this.userId}/security-question`)
                .then((response) => {
                    console.log(response.data);
                    this.items = response.data;
                    if (this.items.length != 0) {
                        this.insertIndexes();
                    }
                })
                .catch((error) => {
                    Toast.fire({
                        icon: "error",
                        title: "Error! " + error.message,
                    });
                    console.log("Error: ", error);
                })
                .finally(() => {
                    this.showLoader = false;
                });
        },
        insertIndexes() {
            this.items = this.items.map((items, index) => ({
                ...items,
                index: index + 1,
            }));
        },
    },
    mounted() {
        this.getSecurityQuestions();
    },
};
</script>

<style lang="scss" scoped>
.card-title {
    margin-bottom: 0px;
}
</style>

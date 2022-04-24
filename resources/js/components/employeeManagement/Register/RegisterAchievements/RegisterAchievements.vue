<template>
    <div id="achievementSection">
        <div id="listOfAchievement" class="card">
            <div class="card-header">
                <h1 class="card-title font-weight-bold">
                    <i class="fas fa-list-alt mr-1"></i>
                    Achievements <span class="mr-1"></span>| 
                        <span class="text-primary ml-1">
                        <span v-if="achievements.length != 0">
                            {{ achievements.length }}
                        </span>
                        Total Achievements
                    </span> 
                </h1>
            </div>
            <div class="card-body">
                <loader v-show="showLoader" />
                <list 
                    :items="achievements"
                    :headers="headers"
                    @onAdd="openModal($event,'add')"
                    @onEdit="openModal($event,'edit')"
                    @onRemove="removeAchievement($event)"
                />
            </div>
            <modal 
                :modalTitle="modalTitle"
                :modalSubmitButtonText="submitButton"
                :item="achievement"
                @onSubmit="submitForm"
            />
        </div>
    </div>
</template>

<script>
import Loader from "../../../customComponents/Loader";
import { EventBus } from "../../../../EventBus";
import List from "./List";
import Modal from "./Modal/Modal";

export default {
    components: {
        Loader,
        List,
        Modal,
    },
    data() {
        return {
            headers: [
                { text: "No", value: "index" },
                { text: "Description", value: "description" },
                { text: "Actions", value: "action", sortable: false },
            ],
            action: "",
            modalTitle: "",
            submitButton: "",
            showLoader: false,
            achievements: [],
            achievement: {},
        };
    },
    methods: {
        openModal(item = "", action) {
            this.formReset();
            $("#achievementModal").modal("show");
            if (action == "add") {
                this.action = "Add";
                this.modalTitle = "Add New Achievement";
                this.submitButton = "Submit";
                return;
            }             
            if (action == "edit") {
                this.action = "Edit";
                this.modalTitle = "Edit Achievement";
                this.submitButton = "Update";
                this.achievement = Object.assign({}, item);
                return;
            } 
        },
        submitForm() {
            if (this.action == "Add") {
                this.addAchievement();
            } else {
                this.updateAchievement();
            }
        },
        addAchievement() {
            this.$validator.validate().then((valid) => {
                if (valid) {
                    this.$Progress.start();
                    this.showLoader = true;
                    this.achievements.push(this.achievement);
                    this.$Progress.finish();
                    this.showLoader = false;
                    this.insertIndexes();
                    EventBus.$emit('get-achievements', this.achievements);
                    Toast.fire({
                        icon: "success",
                        title: "Successfully Added!",
                    });
                    $('#achievementModal').modal("hide");
                } else {
                    this.$Progress.start();
                    this.showLoader = true;
                    Toast.fire({
                        icon: "error",
                        title: "Please check your inputs!",
                    });
                    this.$Progress.fail();
                    this.showLoader = false;
                }
                
            });
        },
        updateAchievement() {
            this.$validator.validate().then((valid) => {
                if (valid) {
                    this.$Progress.start();
                    this.showLoader = true;
                    this.$set(this.achievements, this.achievement.index, this.achievement)
                    this.$Progress.finish();
                    this.showLoader = false;
                    this.insertIndexes();
                    EventBus.$emit('get-achievements', this.achievements);
                    Toast.fire({
                        icon: "success",
                        title: "Successfully Updated!",
                    });
                    $('#achievementModal').modal("hide");
                } else {
                    this.$Progress.start();
                    this.showLoader = true;
                    Toast.fire({
                        icon: "error",
                        title: "Please check your inputs!",
                    });
                    this.$Progress.fail();
                    this.showLoader = false;
                }
            });
        },
        removeAchievement(index) {
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
                    this.achievements.splice(index, 1);
                    this.$Progress.finish();
                    this.showLoader = false;
                    this.insertIndexes();
                    EventBus.$emit('get-achievements', this.achievements);
                    Toast.fire({
                        icon: "success",
                        title: "Successfully Removed!",
                    });
                }
            });
        },
        formReset() {
            this.achievement = Object.assign({},{
                description: "",
            });
            this.$validator.reset();
        },
        insertIndexes() {
            this.achievements = this.achievements.map(
                (items, index) => ({
                    ...items,
                    index: index,
                })
            );
        },
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

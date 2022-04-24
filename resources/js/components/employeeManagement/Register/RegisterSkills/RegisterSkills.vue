<template>
    <div id="skillsSection">
        <div id="listOfSkills" class="card">
            <div class="card-header">
                <h1 class="card-title font-weight-bold">
                    <i class="fas fa-list-alt mr-1"></i>
                    Skills <span class="mr-1"></span>|
                    <span class="text-primary ml-1">
                        <span v-if="skills.length != 0">
                            {{ skills.length }}
                        </span>
                        Total Skills
                    </span>
                </h1>
            </div>
            <div class="card-body">
                <loader v-show="showLoader" />
                <list
                    :items="skills"
                    :headers="headers"
                    @onAdd="openModal($event, 'add')"
                    @onEdit="openModal($event, 'edit')"
                    @onRemove="removeSkill($event)"
                />
            </div>
            <modal
                :modalTitle="modalTitle"
                :modalSubmitButtonText="submitButton"
                :item="skill"
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
            skills: [],
            skill: {},
        };
    },
    methods: {
        openModal(item = "", action) {
            $("#skillModal").modal("show");
            this.formReset();
            if (action == "add") {
                this.action = "Add";
                this.modalTitle = "Add New Skill";
                this.submitButton = "Submit";
                return;
            }
            if (action == "edit") {
                this.action = "Edit";
                this.modalTitle = "Edit Skill";
                this.submitButton = "Update";
                this.skill = Object.assign({}, item);
                return;
            }
        },
        submitForm() {
            if (this.action == "Add") {
                this.addSkill();
            } else {
                this.updateSkill();
            }
        },
        addSkill() {
            this.$validator.validate().then((valid) => {
                if (valid) {
                    this.$Progress.start();
                    this.showLoader = true;
                    this.skills.push(this.skill);
                    this.$Progress.finish();
                    this.showLoader = false;
                    this.insertIndexes();
                    EventBus.$emit("get-skills", this.skills);
                    Toast.fire({
                        icon: "success",
                        title: "Successfully Added!",
                    });
                    $("#skillModal").modal("hide");
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
        updateSkill() {
            this.$validator.validate().then((valid) => {
                if (valid) {
                    this.$Progress.start();
                    this.showLoader = true;
                    this.$set(this.skills, this.skill.index, this.skill);
                    this.$Progress.finish();
                    this.showLoader = false;
                    this.insertIndexes();
                    EventBus.$emit("get-skills", this.skills);
                    Toast.fire({
                        icon: "success",
                        title: "Successfully Updated!",
                    });
                    $("#skillModal").modal("hide");
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
        removeSkill(index) {
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
                    this.skills.splice(index, 1);
                    this.$Progress.finish();
                    this.showLoader = false;
                    this.insertIndexes();
                    EventBus.$emit("get-skills", this.skills);
                    Toast.fire({
                        icon: "success",
                        title: "Successfully Removed!",
                    });
                }
            });
        },
        formReset() {
            this.skill = Object.assign({},{
                description: "",
            });
            this.$validator.reset();
        },
        insertIndexes() {
            this.skills = this.skills.map((items, index) => ({
                ...items,
                index: index,
            }));
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

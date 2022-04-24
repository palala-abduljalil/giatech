<template>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Team</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <add-member @onAdd="openModal($event, 'add')" />
                </div>
            </div>
            <div class="row">
                <loader v-if="showSpinner" />
                <div
                    class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column"
                    v-for="stakeholder in stakeholders.data"
                    :key="stakeholder.id"
                >
                    <member
                        :item="stakeholder"
                        @onEdit="openModal($event, 'edit')"
                        @onDelete="removeStakeholder($event)"
                    />
                </div>
            </div>
        </div>
        <div class="card-footer">
            <pagination
                align="center"
                :data="stakeholders"
                @pagination-change-page="getResults"
            ></pagination>
        </div>
        <modal
            :modalTitle="modalTitle"
            :buttonTitle="submitButton"
            :item="stakeholder"
            :action="action"
        />
    </div>
</template>

<script>
import Member from "./Member";
import Loader from "../../customComponents/Loader";
import AddMember from "./AddMember";
import Modal from "./Modal/Modal";
import { EventBus } from "../../../EventBus";

export default {
    components: {
        Loader,
        Member,
        AddMember,
        Modal,
    },
    data() {
        return {
            stakeholder: {},
            modalTitle: "",
            submitButton: "",
            stakeholders: {},
            showSpinner: false,
            action: "",
        };
    },
    methods: {
        getResults(page = 1) {
            this.showSpinner = true;
            this.$Progress.start();
            axios
                .get("/api/company/stakeholder?page=" + page)
                .then((response) => {
                    this.stakeholders = response.data;
                    this.$Progress.finish();
                    this.showSpinner = false;
                });
        },
        openModal(item = "", action) {
            if (action == "add") {
                this.formReset();
                this.action = "POST";
                this.modalTitle = "Add New Stakeholder";
                this.submitButton = "Submit";
            } else {
                this.action = "PUT";
                this.modalTitle = "Edit Stakeholder";
                this.submitButton = "Update";
                EventBus.$emit("reset-form", item);
            }
            $("#modal").modal("show");
        },
        formReset() {
            this.stakeholder = Object.assign(
                {},
                {
                    id: "",
                    employee: {
                        id: "",
                    },
                    linkedInLink: "",
                }
            );
            EventBus.$emit("reset-form", this.stakeholder);
        },
        async getStakeholders() {
            return axios
                .get("/api/company/stakeholder")
                .then((response) => {
                    this.stakeholders = response.data;
                    return;
                })
                .catch((error) => {
                    Toast.fire({
                        icon: "error",
                        title: "Error! " + error.message,
                    });
                    console.log("Error: ", error);
                    return;
                })
                .finally(() => {
                    this.$PageLoad.stop();
                });
        },
        removeStakeholder(item) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes",
            }).then((result) => {
                if (result.value) {
                    this.showSpinner = true;
                    this.$Progress.start();
                    axios
                        .delete(`/api/company/stakeholder/${item.id}`)
                        .then(() => {
                            Toast.fire({
                                icon: "success",
                                title: "Stakeholder has been successfully removed.",
                            });
                            this.loadPage();
                            this.$Progress.finish();
                        })
                        .catch((error) => {
                            Toast.fire({
                                icon: "error",
                                title: "Error! " + error.message,
                            });
                            this.$Progress.fail();
                        })
                        .finally(() => {
                            this.showSpinner = false;
                        });
                }
            });
        },
        async loadPage() {
            await this.getStakeholders();
        },
    },
    mounted() {
        this.loadPage();
        EventBus.$on("refresh-stakeholder-list", (data) => {
            this.loadPage();
        });
    },
};
</script>

<style scoped>
.card-tools {
    float: right;
    margin-right: -0.625rem;
}
</style>

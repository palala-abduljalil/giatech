<template>
    <div class="card" v-if="isLoad">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 pb-0">
                    <h5 class="font-weight-normal">
                        <i class="fas fa-file-invoice mr-2"></i>
                        Project Details
                    </h5>
                    <hr />
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 pt-0">
                    <div class="form-group">
                        <text-field
                            label="Title"
                            name="title"
                            :readonly="true"
                            v-model="form.title"
                        />
                    </div>
                </div>
                <div class="col-md-4 pt-0">
                    <div class="form-group">
                        <text-field
                            label="Category"
                            name="category"
                            :readonly="true"
                            v-model="form.category"
                        />
                    </div>
                </div>
                <div class="col-md-4 pt-0">
                    <div class="form-group">
                        <text-field
                            label="Client"
                            name="client"
                            :readonly="true"
                            v-model="form.client"
                        />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 pt-0">
                    <text-area
                        label="Description"
                        name="description"
                        rows="5"
                        :readonly="true"
                        v-model="form.description"
                    />
                </div>
            </div>
            <div class="row pt-3">
                <div class="col-md-4 pt-0">
                    <div class="form-group">
                        <label for="">Duration</label>
                        <VueDatePicker
                            v-model="date"
                            format="DD-MM-YYYY"
                            :min-date="minDate"
                            :max-date="maxDate"
                            name="startDate"
                            v-validate="'required'"
                            range
                            range-header-text="Start Date %d End Date %d"
                            range-input-text="%d to %d"
                            fullscreen-mobile
                            validate
                        />
                    </div>
                </div>
                <div class="col-md-4 pt-0">
                    <div class="form-group">
                        <text-field
                            label="Total Contract Price"
                            name="totalContractPrice"
                            :readonly="true"
                            v-model="form.totalContractPrice"
                        />
                    </div>
                </div>
                <div class="col-md-4 pt-0">
                    <div class="form-group">
                        <text-field
                            label="Status"
                            name="status"
                            :readonly="true"
                            v-model="form.status"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import TextField from "../../customComponents/TextField";
import TextArea from "../../customComponents/TextArea";
import { VueDatePicker } from "@mathieustan/vue-datepicker";
import "@mathieustan/vue-datepicker/dist/vue-datepicker.min.css";

export default {
    props: {
        projectId: Number
    },
    components: {
        TextField,
        VueDatePicker,
        TextArea,
    },
    data() {
        return {
            date: {},
            currentDate: new Date(),
            form: {},
            isLoad: false,
        };
    },
    methods: {
        getProject() {
            this.isLoad = false;
            axios
                .get(`/api/project/${this.projectId}`)
                .then((response) => {
                    this.form = {
                        title: response.data.title,
                        category: response.data.category.name,
                        client: response.data.client.name,
                        description: response.data.description,
                        totalContractPrice: response.data.totalContractPrice,
                        status: response.data.status.name,
                    };
                    this.date = {
                        start: response.data.startDate,
                        end: response.data.endDate,
                    };
                    this.isLoad = true;
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
    },
    computed: {
        minDate() {
            return new Date(
                this.currentDate.getFullYear() - 1,
                this.currentDate.getMonth(),
                this.currentDate.getDate()
            );
        },
        maxDate() {
            return new Date(
                this.currentDate.getFullYear() + 1,
                this.currentDate.getMonth(),
                this.currentDate.getDate()
            );
        },
    },
    mounted() {
        this.getProject();
    },
};
</script>

<style scoped>
.card-title {
    margin-bottom: 0px;
    font-size: 20px;
}
</style>

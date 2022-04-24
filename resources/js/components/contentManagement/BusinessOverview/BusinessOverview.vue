<template>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Business Overview</h3>
        </div>
        <div class="card-body">
            <loader v-show="showSpinner" />
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <text-area
                            label="About"
                            name="background"
                            :labelAsterisk="true"
                            rows="5"
                            v-model="items.background"
                            rules="required|min:10|max:65535"
                            errorLabel="About"
                            errorMessage="background"
                        />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <text-area
                            label="Mission"
                            name="mission"
                            :labelAsterisk="true"
                            rows="5"
                            v-model="items.mission"
                            rules="required|min:10|max:500"
                            errorLabel="Mission"
                            errorMessage="mission"
                        />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <text-area
                            label="Vision"
                            name="vision"
                            :labelAsterisk="true"
                            rows="5"
                            v-model="items.vision"
                            rules="required|min:10|max:500"
                            errorLabel="Vision"
                            errorMessage="vision"
                        />
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <submit-button @onSubmit="update" />
        </div>
    </div>
</template>

<script>
import Loader from "../../customComponents/Loader";
import TextArea from "../../customComponents/TextArea";
import SubmitButton from "./SubmitButton";
import { EventBus } from "../../../EventBus";

export default {
    components: {
        Loader,
        TextArea,
        SubmitButton,
    },
    data() {
        return {
            showSpinner: false,
            items: {},
        };
    },
    methods: {
        getData() {
            const companyID = 1;
            this.showSpinner = true;
            axios
                .get(`/api/company/about/${companyID}`)
                .then((response) => {
                    this.items = response.data;
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
                    this.showSpinner = false;
                });
        },
        update() {
            this.$validator.validateAll().then((valid) => {
                if (valid) {
                    const comnpanyID = 1;
                    this.$Progress.start();
                    this.showSpinner = true;
                    EventBus.$emit("show-spinner", true);
                    axios
                        .put(`/api/company/about/${comnpanyID}`, this.items)
                        .then((response) => {
                            Toast.fire({
                                icon: "success",
                                title: response.data.message,
                            });
                            this.showSpinner = false;
                            EventBus.$emit("show-spinner", false);
                            this.$Progress.finish();
                        })
                        .catch((error) => {
                            if (error.response.data.errors) {
                                var entries = Object.entries(
                                    error.response.data.errors
                                );
                                this.errors.clear();
                                entries.forEach(function (item, index) {
                                    this.errors.add({
                                        field: item[0],
                                        msg: item[1][0],
                                    });
                                }, this);
                            } else {
                                Toast.fire({
                                    icon: "error",
                                    title: "Error! " + error.message,
                                });
                            }
                            this.$Progress.fail();
                            this.showSpinner = false;
                            EventBus.$emit("show-spinner", false);
                        });
                }
            });
        },
    },
    mounted() {
        this.getData();
    },
};
</script>

<style scoped>
.card-title {
    margin-bottom: 0px;
}
</style>

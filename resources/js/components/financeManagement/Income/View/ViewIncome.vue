<template>
    <div class="card" v-if="isLoad">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 pb-0">
                    <h5 class="font-weight-normal">Income Details</h5>
                    <hr />
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 pt-0">
                    <div class="form-group">
                        <text-field
                            label="Project"
                            name="project"
                            v-model="form.project"
                            :readonly="true"
                        />
                    </div>
                </div>
                <div class="col-md-4 pt-0">
                    <div class="form-group">
                        <text-field
                            label="Service"
                            name="service"
                            v-model="form.service"
                            :readonly="true"
                        />
                    </div>
                </div>
                <div class="col-md-4 pt-0">
                    <div class="form-group">
                        <text-field
                            label="Amount"
                            name="amount"
                            v-model="form.amount"
                            :readonly="true"
                        />
                    </div>
                </div>
            </div>
            <div class="row pt-3">
                <div class="col-md-4 pt-0">
                    <div class="form-group">
                        <label for="">Transaction Date</label>
                        <VueDatePicker
                            v-model="form.transactionDate"
                            format="DD-MM-YYYY"
                            name="transactionDate"
                            fullscreen-mobile
                            validate
                        />
                    </div>
                </div>
                <div class="col-md-4 pt-0">
                    <div class="form-group">
                        <text-field
                            label="Category"
                            name="category"
                            v-model="form.category"
                            :readonly="true"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import TextField from "../../../customComponents/TextField";
import { VueDatePicker } from "@mathieustan/vue-datepicker";
import "@mathieustan/vue-datepicker/dist/vue-datepicker.min.css";

export default {
    props: {
        incomeId: Number,
    },
    components: {
        TextField,
        VueDatePicker,
    },
    data() {
        return {
            isLoad: false,
            form: {
                service: "",
                amount: 0,
                transactionDate: new Date(),
                project: 0,
                category: 0,
            },
        };
    },
    methods: {
        getIncome() {
            axios
                .get(`/api/income/${this.incomeId}`)
                .then((response) => {
                    this.form = {
                        service: response.data.service,
                        category: response.data.category.name,
                        project: response.data.project.name,
                        transactionDate: response.data.transactionDate,
                        amount: response.data.amount,
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
    mounted() {
        this.getIncome();
    },
};
</script>

<style scoped>
.card-title {
    margin-bottom: 0px;
    font-size: 20px;
}
</style>

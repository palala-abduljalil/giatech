<template>
    <div class="card" v-if="isLoad">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 pb-0">
                    <h5 class="font-weight-normal">Expense Details</h5>
                    <hr />
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 pt-0">
                    <div class="form-group">
                        <text-field
                            label="Start Point"
                            name="startPoint"
                            v-model="form.startPoint"
                            :readonly="true"
                        />
                    </div>
                </div>
                <div class="col-md-4 pt-0">
                    <div class="form-group">
                        <text-field
                            label="End Point"
                            name="endPoint"
                            v-model="form.endPoint"
                            :readonly="true"
                        />
                    </div>
                </div>
                <div class="col-md-4 pt-0">
                    <div class="form-group">
                        <text-field
                            label="Handled By"
                            name="employee"
                            v-model="form.employee"
                            :readonly="true"
                        />
                    </div>
                </div>
            </div>
            <div class="row pt-3">
                <div class="col-md-4 pt-0">
                    <div class="form-group">
                        <label>Transaction Date</label>
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
                            label="Purpose"
                            name="purpose"
                            v-model="form.purpose"
                            :readonly="true"
                        />
                    </div>
                </div>
                <div class="col-md-4 pt-0">
                    <div class="form-group">
                        <text-field
                            label="Date Encoded"
                            name="date"
                            v-model="form.created_at"
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
import CustomSelect from "../../../customComponents/CustomSelect";
import { VueDatePicker } from "@mathieustan/vue-datepicker";
import "@mathieustan/vue-datepicker/dist/vue-datepicker.min.css";

export default {
    props: {
        data: Object,
    },
    components: {
        TextField,
        CustomSelect,
        VueDatePicker,
    },
    data() {
        return {
            isLoad: false,
            form: {},
        };
    },
    watch: {
        form() {
            this.isLoad = true;
            setTimeout(() => {
                this.$PageLoad.stop();
            }, 0.1);
        }
    },
    mounted() {
        this.form = {
            startPoint: this.data.startPoint,
            endPoint: this.data.endPoint,
            employee: this.data.employee.name,
            transactionDate: this.data.transactionDate,
            purpose: this.data.purpose,
            created_at: this.data.created_at,
        };
    },
};
</script>

<style scoped>
.card-title {
    margin-bottom: 0px;
    font-size: 20px;
}
</style>

<template>
    <div class="card" v-if="isLoad">
        <form 
            ref="expenseForm"
            data-vv-scope="form"
            @submit.prevent="submitForm"
        >
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 pb-0">
                        <h5 class="font-weight-normal">
                            Expense Details
                        </h5>
                        <hr />
                    </div>
                </div>
                <div class="row">
                    <input type="hidden" name="_method" value="PUT"/>
                    <div class="col-md-4 pt-0">
                        <div class="form-group">
                            <text-field
                                label="Particular"
                                name="particular"
                                v-model="form.particular"
                                :readonly="true"
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
                            <label for="" class="required">Transaction Date</label>
                            <VueDatePicker  
                                v-model="form.transactionDate"
                                format="DD-MM-YYYY"
                                name="transactionDate"
                                v-validate="'required'"
                                fullscreen-mobile
                                validate
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
        </form>
    </div>
</template>

<script>

import TextField from "../../../customComponents/TextField";
import CustomSelect from "../../../customComponents/CustomSelect" 
import { VueDatePicker } from '@mathieustan/vue-datepicker';
import '@mathieustan/vue-datepicker/dist/vue-datepicker.min.css';
export default {
    props: {
        expenseId: Number
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
        }
    },
    methods: {
        getExpense() {
            axios
                .get(`/api/expense/${this.expenseId}`)
                .then((response) => {
                    this.form = {
                        particular: response.data.particular,
                        category: response.data.category.name,
                        employee: response.data.employee.name,
                        transactionDate: response.data.transactionDate,
                        amount: response.data.amount,
                        created_at: response.data.created_at
                    };
                    this.isLoad = true;
                })
                .catch((error) => {
                    Toast.fire({
                        icon: "error",
                        title: "Error",
                    });
                    console.log("Error: ", error);
                })
                .finally(() => {
                    this.$PageLoad.stop();
                });
        }
    },
    mounted() {
        this.getExpense();
    },
};
</script>

<style scoped>
.card-title {
    margin-bottom: 0px;
    font-size: 20px;
}
.required:after {
    content: " *";
    color: red;
}

.date-invalid-feedback {
    width: 100%;
    margin-top: 0.25rem;
    font-size: 100%;
    color: #dc3545;
}
</style>

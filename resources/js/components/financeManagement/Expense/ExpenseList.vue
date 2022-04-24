<template>
    <div id="expenseSection">
        <div id="listOfExpense" class="card">
            <div class="card-header">
                <h1 class="card-title font-weight-bold">
                    <i class="fas fa-list-alt mr-1"></i>
                    Expense <span class="mr-1"></span>| <span class="text-primary ml-1">
                        {{ expenses.length }}
                        Total Expense
                    </span> 
                </h1>
            </div>
            <div class="card-body">
                <loader v-show="loader" />
                <list 
                    :items="expenses"
                    :headers="headers"
                    @onAdd="addExpense"
                    @onEdit="editExpense($event)"
                    @onRemove="removeExpense($event)"
                    @onView="viewExpense($event)"
                />
            </div>
        </div>
    </div>
</template>

<script>
import Loader from "../../customComponents/Loader";
import List from "./List";
export default {
    components: {
        Loader,
        List,
    },
    data() {
        return {
            headers: [
                { text: "No", value: "index" },
                { text: "Particular", value: "particular" },
                { text: "Handled By", value: "employee.name" },
                { text: "Category", value: "category.name"},
                { text: "Amount", value: "amount" },
                { text: "Transaction Date", value: "transactionDate"},
            ],
            loader: false,
            isPageLoaded: false,
            expenses: [],
        };
    },
    methods: {
        viewExpense(item) {
            window.location.href = "/expenses/" + item.id;
        },
        editExpense(item) {
            window.location.href = "/expenses/" + item.id + "/edit";
        },
        addExpense() {
            window.location.href = "/expenses/create";
        },
        removeExpense(item) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes",
            }).then((result) => {
                if (result.value) {
                    Swal.showLoading();
                    this.loader = true;
                    this.$Progress.start();
                    axios
                        .delete(`/api/expense/${item.id}`)
                        .then(() => {
                            this.getExpenses();
                            Toast.fire({
                                icon: "success",
                                title: "Expense Succesfully removed.",
                            });
                            this.loader = false;
                            Swal.hideLoading();
                            this.$Progress.finish();
                        })
                        .catch((error) => {
                            this.loader = false;
                            Swal.hideLoading();
                            Swal.fire("Failed!", error.message, "warning");
                            this.$Progress.fail();
                        });
                }
            });
        },
        getExpenses() {
            this.loader = true;
            axios
                .get("/api/expense")
                .then((response) => {
                    this.expenses = response.data;
                    if (this.expenses.length != 0) {
                        this.insertIndexes();
                    }
                    if (!this.isPageLoaded) {
                        if (this.$gate.isAdmin()) {
                            this.headers.push({'text': 'Created by', 'value': 'createdBy.name'});
                        }
                        this.headers.push({text: "Actions", value: "action", sortable: false});
                    }
                    this.isPageLoaded = true;
                    this.$Progress.finish();
                })
                .catch((error) => {
                    Toast.fire({
                        icon: "error",
                        title: "Error! " + error.message,
                    });
                    this.$Progress.fail();
                    console.log("Error: ", error);
                })
                .finally(() => {
                    this.$PageLoad.stop();
                    this.loader = false;
                });
        },
        insertIndexes() {
            this.expenses = this.expenses.map(
                (items, index) => ({
                    ...items,
                    index: index + 1,
                })
            );
        },
    },
    mounted() {
        this.getExpenses();
    },
};
</script>

<style lang="scss" scoped>
.card-title {
    margin-bottom: 0px;
}
</style>

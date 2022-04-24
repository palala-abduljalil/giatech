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
                <list 
                    :items="expenses"
                    @onPrintList="printExpenseList"
                />
            </div>
        </div>
    </div>
</template>

<script>
import List from "./List";
export default {
    components: {
        List,
    },
    data() {
        return {
            expenses: [],
        };
    },
    methods: {
        printExpenseList() {
            window.open("/expense-report-print",'_blank');
        },
        getExpenses() {
            axios
                .get("/api/expense")
                .then((response) => {
                    this.expenses = response.data;
                    if (this.expenses.length != 0) {
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
                    this.$PageLoad.stop();
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

<template>
    <div id="incomeSection">
        <div id="listOfIncome" class="card">
            <div class="card-header">
                <h1 class="card-title font-weight-bold">
                    <i class="fas fa-list-alt mr-1"></i>
                    Income <span class="mr-1"></span>| <span class="text-primary ml-1">
                        {{ incomes.length }}
                        Total Income
                    </span> 
                </h1>
            </div>
            <div class="card-body">
                <list
                    :items="incomes"
                    @onPrintList="printIncomeList"
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
            incomes: [],
        };
    },
    methods: {
        printIncomeList() {
            window.open("/income-report-print",'_blank');
        },
        getIncomes() {
            axios
                .get("/api/income")
                .then((response) => {
                    this.incomes = response.data;
                    if (this.incomes.length != 0) {
                        this.insertIndexes();
                    }
                })
                .catch((error) => {
                    Toast.fire({
                        icon: "error",
                        title: "Error!" + error.message,
                    });
                    console.log("Error: ", error);
                })
                .finally(() => {
                    this.$PageLoad.stop();
                });
        },
        insertIndexes() {
            this.incomes = this.incomes.map(
                (items, index) => ({
                    ...items,
                    index: index + 1,
                })
            );
        },
    },
    mounted() {
        this.getIncomes();
    },
};
</script>

<style lang="scss" scoped>
.card-title {
    margin-bottom: 0px;
}
</style>

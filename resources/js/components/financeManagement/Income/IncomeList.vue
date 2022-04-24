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
                <loader v-show="loader" />
                <list 
                    :items="incomes"
                    :headers="headers"
                    @onAdd="addIncome"
                    @onEdit="editIncome($event)"
                    @onRemove="removeIncome($event)"
                    @onView="viewIncome($event)"
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
        List
    },
    data() {
        return {
            headers: [
                { text: "No", value: "index" },
                { text: "Project", value: "project.name" },
                { text: "Service", value: "service" },
                { text: "Category", value: "category.name" },
                { text: "Amount", value: "amount"},
                { text: "Transaction Date", value: "transactionDate"},
            ],
            loader: false,
            isPageLoad: false,
            incomes: [],
        };
    },
    methods: {
        viewIncome(item) {
            window.location.href = "/incomes/" + item.id;
        },
        editIncome(item) {
            window.location.href = "/incomes/" + item.id + "/edit";
        },
        addIncome() {
            window.location.href = "/incomes/create";
        },
        removeIncome(item) {
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
                        .delete(`/api/income/${item.id}`)
                        .then(() => {
                            this.getIncomes();
                            Toast.fire({
                                icon: "success",
                                title: "Income Succesfully removed.",
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
        getIncomes() {
            this.loader = true;
            axios
                .get("/api/income")
                .then((response) => {
                    this.incomes = response.data;
                    if (this.incomes.length != 0) {
                        this.insertIndexes();
                    }
                    if (!this.isPageLoaded) {
                        if (this.$gate.isAdmin()) {
                            this.headers.push({'text': 'Created by', 'value': 'createdBy.name'});
                        }
                        this.headers.push({text: "Actions", value: "action", sortable: false});
                    }
                    this.isPageLoaded = true;
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
                    this.loader = false;
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

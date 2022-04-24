<template>
    <div id="employeesSection">
        <div id="listOfEmployees" class="card">
            <div class="card-header">
                <h1 class="card-title font-weight-bold">
                    <i class="fas fa-list-alt mr-1"></i>
                    Employees <span class="mr-1"></span>| <span class="text-primary ml-1">
                        {{ employees.length }}
                        Total Employees
                    </span> 
                </h1>
            </div>
            <div class="card-body">
                <list 
                    :items="employees"
                    @onPrintList="printEmployeeList"
                    @onPrintDetails="printEmployeeDetails($event)"
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
            employees: [],
        };
    },
    methods: {
        printEmployeeDetails(item) {
            window.open("/employee-report-print/" + item.id,'_blank');
        },
        printEmployeeList() {
            console.log('printlist');
            window.open("/employee-report-print",'_blank');
        },
        getEmployees() {
            axios
                .get("/api/employee")
                .then((response) => {
                    this.employees = response.data;
                    if (this.employees.length != 0) {
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
            this.employees = this.employees.map(
                (items, index) => ({
                    ...items,
                    index: index + 1,
                })
            );
        },
    },
    mounted() {
        this.getEmployees();
    },
};
</script>

<style lang="scss" scoped>
.card-title {
    margin-bottom: 0px;
}
</style>

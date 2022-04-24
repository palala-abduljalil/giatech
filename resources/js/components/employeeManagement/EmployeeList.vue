<template>
    <div id="employeesSection">
        <div id="listOfEmployees" class="card">
            <div class="card-header">
                <h1 class="card-title font-weight-bold">
                    <i class="fas fa-list-alt mr-1"></i>
                    Employees <span class="mr-1"></span>|
                    <span class="text-primary ml-1">
                        {{ employees.length }}
                        Total Employees
                    </span>
                </h1>
            </div>
            <div class="card-body">
                <loader v-show="loader" />
                <list
                    :items="employees"
                    :headers="headers"
                    @onAdd="registerEmployee"
                    @onEdit="editEmployee($event)"
                    @onDelete="removeEmployee($event)"
                    @onView="viewEmployee($event)"
                />
            </div>
        </div>
    </div>
</template>

<script>
import Loader from "../customComponents/Loader";
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
                { text: "Name", value: "name" },
                { text: "Employee Number", value: "employeeNumber" },
                { text: "Department", value: "department.name" },
                { text: "Date Hired", value: "dateHired" },
            ],
            loader: false,
            isPageLoaded: false,
            employees: [],
        };
    },
    methods: {
        viewEmployee(item) {
            window.location.href = "/employees/" + item.id;
        },
        editEmployee(item) {
            window.location.href = "/employees/" + item.id + "/edit";
        },
        registerEmployee() {
            window.location.href = "/employees/create";
        },
        removeEmployee(item) {
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
                    this.showListLoader = true;
                    this.$Progress.start();
                    axios
                        .delete(`/api/employee/${item.id}`)
                        .then(() => {
                            this.getEmployees();
                            Toast.fire({
                                icon: "success",
                                title: "Employee Succesfully removed.",
                            });
                            Swal.hideLoading();
                            this.$Progress.finish();
                        })
                        .catch((error) => {
                            Swal.hideLoading();
                            Swal.fire("Failed!", error.message, "warning");
                            this.$Progress.fail();
                        });
                }
            });
        },
        getEmployees() {
            this.loader = true;
            axios
                .get("/api/employee")
                .then((response) => {
                    this.employees = response.data;
                    if (this.employees.length != 0) {
                        this.insertIndexes();
                    }
                    if (!this.isPageLoaded) {
                        if (this.$gate.isAdmin()) {
                            this.headers.push({
                                text: "Created by",
                                value: "createdBy.name",
                            });
                        }
                        this.headers.push({
                            text: "Actions",
                            value: "action",
                            sortable: false,
                        });
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
                    this.loader = false;
                    this.$PageLoad.stop();
                });
        },
        insertIndexes() {
            this.employees = this.employees.map((items, index) => ({
                ...items,
                index: index + 1,
            }));
        },
    },
    mounted() {
        this.getEmployees();
    },
};
</script>

<style>
.card-title {
    margin-bottom: 0px;
}
</style>

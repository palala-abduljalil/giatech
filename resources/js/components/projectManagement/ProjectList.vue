<template>
    <div id="projectSection">
        <div id="listOfProject" class="card">
            <div class="card-header">
                <h1 class="card-title font-weight-bold">
                    <i class="fas fa-list-alt mr-1"></i>
                    Project <span class="mr-1"></span>| <span class="text-primary ml-1">
                        {{ projects.length }}
                        Total Project
                    </span> 
                </h1>
            </div>
            <div class="card-body">
                <loader v-show="loader" />
                <list 
                    :items="projects"
                    :headers="headers"
                    @onAdd="createProject"
                    @onEdit="editProject($event)"
                    @onRemove="removeProject($event)"
                    @onView="viewProject($event)"
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
        List
    },
    data() {
        return {
            headers: [
                { text: "No", value: "index" },
                { text: "Title", value: "title" },
                { text: "Client", value: "client.name" },
                { text: "Category", value: "category.name" },
                { text: "Status", value: "status.name" },
            ],
            loader: false,
            isPageLoaded: false,
            projects: [],
        };
    },
    methods: {
        viewProject(item) {
            window.location.href = "/projects/" + item.id;
        },
        editProject(item) {
            window.location.href = "/projects/" + item.id + "/edit";
        },
        createProject() {
            window.location.href = "/projects/create";
        },
        removeProject(item) {
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
                        .delete(`/api/project/${item.id}`)
                        .then(() => {
                            this.getProjects();
                            Toast.fire({
                                icon: "success",
                                title: "Project Succesfully removed.",
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
        getProjects() {
            this.loader = true;
            axios
                .get("/api/project")
                .then((response) => {
                    this.projects = response.data;
                    if (this.projects.length != 0) {
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
            this.projects = this.projects.map(
                (items, index) => ({
                    ...items,
                    index: index + 1,
                })
            );
        },
    },
    mounted() {
        this.getProjects();
    },
};
</script>

<style lang="scss" scoped>
.card-title {
    margin-bottom: 0px;
}
</style>

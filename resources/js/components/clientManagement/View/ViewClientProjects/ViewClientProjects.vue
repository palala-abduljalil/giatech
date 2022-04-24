<template>
    <div id="projectSection">
        <div id="listOfProject" class="card">
            <div class="card-header">
                <h1 class="card-title font-weight-bold">
                    <i class="fas fa-list-alt mr-1"></i>
                    Projects <span class="mr-1"></span>| <span class="text-primary ml-1">
                        {{ projects.length }}
                        Total Projects
                    </span> 
                </h1>
            </div>
            <div class="card-body">
                <loader v-show="loader" />
                <list :items="projects"/>
            </div>
        </div>
    </div>
</template>

<script>
import Loader from "../../../customComponents/Loader";
import List from "./List";
export default {
    props: {
        clientId: Number,
    },
    components: {
        Loader,
        List
    },
    data() {
        return {
            loader: false,
            projects: [],
        };
    },
    methods: {
        getProjects() {
            this.loader = true;
            axios
                .get(`/api/client/${this.clientId}/project`)
                .then((response) => {
                    this.projects = response.data;
                    if (this.projects.length != 0) {
                        this.insertIndexes();
                    }
                    this.loader = false;
                })
                .catch((error) => {
                    Toast.fire({
                        icon: "error",
                        title: "Error! " + error.message,
                    });
                    this.loader = false;
                    console.log("Error: ", error);
                })
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

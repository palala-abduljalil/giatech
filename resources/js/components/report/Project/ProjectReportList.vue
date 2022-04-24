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
                <list 
                    :items="projects"
                    @onPrintList="printProjectList"
                    @onPrintActivities="printActivityList($event)"
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
            projects: [],
        };
    },
    methods: {
        printActivityList(item) {
            window.open("/project-report-print/" + item.id,'_blank');
        },
        printProjectList() {
            window.open("/project-report-print",'_blank');
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
.user-block {
    float: left;

    img {
        float: left;
        height: 40px;
        width: 40px;
    }

    .fullName,
    .organization {
        display: block;
        margin-left: 50px;
    }

    .fullName {
        font-size: 16px;
        margin-top: -1px;
    }

    .organization {
        font-size: 13px;
        margin-top: -3px;
    }
}
</style>

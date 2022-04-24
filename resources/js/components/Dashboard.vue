<template>
    <div id="manage-content">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mt-1">
                    <div class="col-md-10 offset-md-1">
                        <h4 class="font-weight-bold">
                            <i class="fas fa-file-invoice mr-2"></i>
                            Content Management
                        </h4>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="row ">
                    <div class="col-md-10 offset-md-1">
                        <about />
                        <!-- <business-overview /> -->

                        <!-- <team /> -->
                        <!-- <services/> -->
                        <!-- <freebies /> -->
                        
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
// import About from "./contentManagement/About";
// import Team from "./contentManagement/Team";
// import Services from "./contentManagement/Services";
// import ContactDetails from "./contentManagement/ContactDetails";
// import Freebies from "./contentManagement/Freebies";
// import BusinessOverview from './contentManagement/BusinessOverview';

export default {
    components: {
        // About,
        // Team,
        // Services,
        // ContactDetails,
        // Freebies,
        // BusinessOverview,
    },
    data() {
        return {
            isLoad: false,
            showSpinner: false,
            isDisplay: false,
            company: {},
            items: [
                { text: "Business Overview", isActive: true },
                { text: "Objectives", isActive: false },
                { text: "Team", isActive: false },
                { text: "Services", isActive: false },
                { text: "Contact Details", isActive: false },
            ],
        };
    },
    mounted() {
        this.isLoad = true;
    },
    created() {
        // this.loadCompany();
    },
    methods: {
        toggle(item, index) {
            this.items[index].isActive = true;
            this.showSpinner = true;
            this.items.forEach(function (element, index) {
                if (element.text != item.text) {
                    this.items[index].isActive = false;
                }
            }, this);
            this.showSpinner = false;
        },
        loadCompany() {
            axios.get("/company/").then((response) => {
                this.company = response.data;
            });
        },
    },
    watch: {
        $route(to, from) {
            console.log("DASHBOARD ROUTE.");
        },
    },
};
</script>

<style>
.content-wrapper .content {
    padding: 0 0.5rem;
}
.container-fluid {
    padding-right: 7.5px;
    padding-left: 7.5px;
}

.card-primary.card-outline {
    border-top: 3px solid #4c81a4;
}

#companyLogo {
    border: 3px solid #adb5bd;
    margin: 0 auto;
    padding: 3px;
    height: 60%;
    width: 60%;
}

.nav-link {
    color: #4c81a4;
}

.card-title {
    margin-bottom: 0px;
}
</style>

<template>
    <section>
        <div class="container" v-if="isLoad">
            <div class="row">
                <div class="col-lg-4 col-xl-4">
                    <div class="card-box text-center">
                        <img
                            :src="`${employee.profilePicture.url}`"
                            class="rounded-circle avatar-xl img-thumbnail"
                            alt="profile-image"
                        />
                        <h4 class="mb-0">
                            {{ employee.name }}
                        </h4>
                        <p class="text-muted">
                            <strong>{{ employee.position.name }}</strong>
                        </p>

                        <edit-avatar name="image" :employee-id="employee.id" />

                        <div class="mt-3 text-left">
                            <span class="text-muted font-weight-bold">
                                <i class="fas fa-user mr-1"></i> Full Name
                            </span>
                            <p class="text-muted font-13">
                                {{ employee.fullName }}
                            </p>
                            <hr />

                            <span class="text-muted font-weight-bold">
                                <i class="fas fa-id-badge mr-1"></i>
                                Employee ID
                            </span>
                            <p class="text-muted font-13">
                                {{ employee.employeeNumber }}
                            </p>
                            <hr />

                            <span class="text-muted font-weight-bold">
                                <i class="fas fa-calendar-alt mr-1"></i>
                                Date Hired
                            </span>
                            <p class="text-muted font-13">
                                {{ employee.dateHired }}
                            </p>
                            <hr />

                            <span class="text-muted font-weight-bold">
                                <i class="fas fa-building mr-1"></i>
                                Department
                            </span>
                            <p class="text-muted font-13">
                                {{ employee.department.name }}
                            </p>
                            <hr />

                            <span class="text-muted font-weight-bold">
                                <i class="fas fa-map-marker mr-1"></i>
                                Address
                            </span>
                            <p class="text-muted font-13">
                                {{ employee.address.fullAddress }}
                            </p>
                        </div>
                    </div>
                </div>
                <loader v-if="showSpinner" />
                <div class="col-lg-8 col-xl-8">
                    <div class="card-box">
                        <edit-about-me :data="employee" />
                    </div>
                </div>
            </div>
        </div>
        <div v-else>
            <not-found />
        </div>
    </section>
</template>

<script>
import EditAboutMe from "./EditAboutMe/EditAboutMe";
import Loader from "../../customComponents/Loader";
import EditAvatar from "./EditAboutMe/EditAvatar";
import { EventBus } from "../../../EventBus";

export default {
    props: {
        employeeId: Number,
    },
    components: {
        Loader,
        EditAboutMe,
        EditAvatar,
    },
    data() {
        return {
            isLoad: false,
            showSpinner: false,
            employee: {},
        };
    },
    methods: {
        getEmployee() {
            axios
                .get(`/api/employee/${this.employeeId}`)
                .then((response) => {
                    this.employee = response.data;
                    this.isLoad = true;
                })
                .catch((error) => {
                    Toast.fire({
                        icon: "error",
                        title: "Error! " + error.message,
                    });
                    console.log("Error: ", error);
                });
        },
    },
    mounted() {
        this.getEmployee();
        EventBus.$on("set-profile-picture-preview", (data) => {
            this.employee.profilePicture.url = data;
        });
        EventBus.$on("show-spinner", (data) => {
            this.showSpinner = data;
        });
        EventBus.$on(
            "hide-spinner",
            (data, fullName, name, position, address, department) => {
                this.showSpinner = data;
                this.employee.fullName = fullName;
                this.employee.department.name = department;
                this.employee.address.fullAddress = address;
                this.employee.position.name = position;
                this.employee.name = name;
            }
        );
    },
};
</script>

<style lang="scss" scoped>
.card-box {
    background-color: #fff;
    background-clip: border-box;
    border: 1px solid #e7eaed;
    padding: 1.5rem;
    margin-bottom: 24px;
    border-radius: 0.25rem;
}
.avatar-xl {
    height: 6rem;
    width: 6rem;
}
.rounded-circle {
    border-radius: 50% !important;
}
.nav-pills .nav-link.active,
.nav-pills .show > .nav-link {
    color: #fff;
    background-color: #007bff;
}
.nav-pills .nav-link {
    border-radius: 0.25rem;
}
.navtab-bg li > a {
    background-color: #f7f7f7;
    margin: 0 5px;
}
.nav-pills > li > a,
.nav-tabs > li > a {
    color: #6c757d;
    font-weight: 600;
}
.mb-4,
.my-4 {
    margin-bottom: 2.25rem !important;
}
.tab-content {
    padding: 20px 0 0 0;
}
.progress-sm {
    height: 5px;
}
.m-0 {
    margin: 0 !important;
}
</style>

<template>
    <div v-if="isLoad" data-app>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-xl-12">
                    <div class="card-box">
                        <ul class="nav nav-pills navtab-bg">
                            <li class="nav-item">
                                <a
                                    href="#project-info"
                                    data-toggle="tab"
                                    aria-expanded="true"
                                    class="nav-link ml-0 active"
                                >
                                    Project Information
                                </a>
                            </li>
                            <li class="nav-item">
                                <a
                                    href="#activities"
                                    data-toggle="tab"
                                    aria-expanded="false"
                                    class="nav-link"
                                >
                                    Activities
                                </a>
                            </li>
                            <li class="nav-item">
                                <a
                                    href="#attachments"
                                    data-toggle="tab"
                                    aria-expanded="false"
                                    class="nav-link"
                                >
                                    Attachments
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane show active" id="project-info">
                                <view-project-information
                                    :project-id="projectId"
                                />
                            </div>
                            <div class="tab-pane" id="activities">
                                <view-project-activities
                                    :project-id="projectId"
                                />
                            </div>
                            <div class="tab-pane" id="attachments">
                                <view-project-attachments
                                    :project-id="projectId"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ViewProjectInformation from "./ViewProjectInformation";
import ViewProjectActivities from "./ViewActivities/ViewActivities";
import ViewProjectAttachments from "./ViewProjectAttachments/ViewProjectAttachments";

export default {
    props: {
        projectId: Number,
    },
    components: {
        ViewProjectActivities,
        ViewProjectInformation,
        ViewProjectAttachments,
    },
    data() {
        return {
            isLoad: true,
        };
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

.nav-borders .nav-link.active {
    color: #0061f2;
    border-bottom-color: #0061f2;
}
.nav-borders .nav-link {
    color: #69707a;
    border-bottom-width: 0.125rem;
    border-bottom-style: solid;
    border-bottom-color: transparent;
    padding-top: 0.5rem;
    padding-bottom: 0.5rem;
    padding-left: 0;
    padding-right: 0;
    margin-left: 1rem;
    margin-right: 1rem;
}
</style>

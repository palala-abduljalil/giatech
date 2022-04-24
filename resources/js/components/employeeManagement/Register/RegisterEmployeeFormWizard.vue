<template>
    <div class="card" data-app>
        <form-wizard
            @on-complete="onComplete"
            title="Employee Registration"
            color="#007bff"
        >
            <tab-content
                title="Personal details"
                icon="fas fa-user"
                :before-change="() => validateStep()"
            >
                <employee-form ref="employeeForm" />
            </tab-content>
            <tab-content title="Achievements" icon="fas fa-medal">
                <achievements />
            </tab-content>
            <tab-content title="Skills" icon="fas fa-users-cog">
                <skills />
            </tab-content>
            <tab-content title="Attachments" icon="fas fa-link">
                <attachments />
            </tab-content>
        </form-wizard>
    </div>
</template>

<script>
import { FormWizard, TabContent } from "vue-form-wizard";
import "vue-form-wizard/dist/vue-form-wizard.min.css";
import Achievements from "./RegisterAchievements/RegisterAchievements";
import Attachments from "./RegisterAttachments/RegisterAttachments";
import EmployeeForm from "./RegisterEmployeeForm";
import Skills from "./RegisterSkills/RegisterSkills";

export default {
    components: {
        FormWizard,
        TabContent,
        EmployeeForm,
        Achievements,
        Skills,
        Attachments,
    },
    methods: {
        onComplete() {
            return this.$refs["employeeForm"].submitForm();
        },
        validateStep() {
            return this.$refs["employeeForm"].validateForm();
        },
    },
    created() {
        setTimeout(() => this.$PageLoad.stop(), 3000);
    }
};
</script>

<style></style>

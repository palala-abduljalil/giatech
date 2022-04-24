/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import moment from 'moment';

// Vee-Validate v2 2.2.15
import VeeValidate from 'vee-validate';
Vue.use(VeeValidate);

// Vuetify Library
import vuetify from './plugins/vuetify';
Vue.use(vuetify);

import PageLoad from "./onLoad";
Vue.prototype.$PageLoad = new PageLoad();

import Gate from "./Gate";
Vue.prototype.$gate = new Gate(window.user);

import Swal from 'sweetalert2';

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    onOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});

window.Swal = Swal;
window.Toast = Toast;

import VueProgressBar from 'vue-progressbar'
Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '3px'
});


/**
 * Routes imports and assigning
 */
import VueRouter from 'vue-router';
Vue.use(VueRouter);
import routes from './routes';
import Vue from 'vue';

const router = new VueRouter({
    mode: 'history',
    linkActiveClass: 'active',
    linkExactActiveClass: "active",
    routes
});
// Routes End


// Components
Vue.component('login-form', require('./components/LoginForm.vue').default);
Vue.component('pagination', require('laravel-vue-pagination'));
Vue.component('dashboard', require('./components/Dashboard.vue'));

// Content Management
Vue.component('company-information', require('./components/contentManagement/ContactDetails/ContactDetails.vue').default);
Vue.component('business-overview', require('./components/contentManagement/BusinessOverview/BusinessOverview.vue').default);
Vue.component('company-team', require('./components/contentManagement/Team/Team.vue').default);
Vue.component('services', require('./components/contentManagement/Services/Services.vue').default);
Vue.component('freebies', require('./components/contentManagement/Freebies/Freebies.vue').default);

// System Setup
Vue.component('security-questions', require('./components/systemSetup/SecurityQuestions/SecurityQuestions.vue').default);
Vue.component('positions', require('./components/systemSetup/Positions/Positions.vue').default);
Vue.component('departments', require('./components/systemSetup/Departments/Departments.vue').default);
Vue.component('expenses-category', require('./components/systemSetup/ExpensesCategory/ExpensesCategory.vue').default);
Vue.component('incomes-category', require('./components/systemSetup/IncomesCategory/IncomesCategory.vue').default);
Vue.component('employee-status', require('./components/systemSetup/EmployeeStatus/EmployeeStatus.vue').default);
Vue.component('academic-degrees', require('./components/systemSetup/AcademicDegrees/AcademicDegrees.vue').default);
Vue.component('schools', require('./components/systemSetup/Schools/Schools.vue').default);
Vue.component('project-status', require('./components/systemSetup/ProjectStatus/ProjectStatus.vue').default);
Vue.component('project-category', require('./components/systemSetup/ProjectCategory/ProjectCategory.vue').default);

// Employee Management
Vue.component('register-employee-form-wizard', require('./components/employeeManagement/Register/RegisterEmployeeFormWizard.vue').default);
Vue.component('employee-list', require('./components/employeeManagement/EmployeeList.vue').default);
Vue.component('view-employee', require('./components/employeeManagement/View/ViewEmployee.vue').default);
Vue.component('edit-employee', require('./components/employeeManagement/Edit/EditEmployee.vue').default);

// Layout
Vue.component('user-panel', require('./components/layout/SidebarUserPanel.vue').default);
Vue.component('navbar-user-dropdown', require('./components/layout/NavbarUserDropdown.vue').default);
Vue.component('sidebar-company-logo', require('./components/layout/SidebarCompanyLogo.vue').default);


// Client Management
Vue.component('register-client', require('./components/clientManagement/Register/RegisterClientForm.vue').default);
Vue.component('edit-client', require('./components/clientManagement/Edit/EditClient.vue').default);
Vue.component('view-client', require('./components/clientManagement/View/ViewClient.vue').default);
Vue.component('client-list', require('./components/clientManagement/ClientList.vue').default);

// Project Management
Vue.component('create-project', require('./components/projectManagement/Create/CreateProject.vue').default);
Vue.component('project-list', require('./components/projectManagement/ProjectList.vue').default);
Vue.component('edit-project', require('./components/projectManagement/Edit/EditProject.vue').default);
Vue.component('view-project', require('./components/projectManagement/View/ViewProject.vue').default);

// Finance Management | Expense
Vue.component('expense-list', require('./components/financeManagement/Expense/ExpenseList.vue').default);
Vue.component('create-expense', require('./components/financeManagement/Expense/Create/CreateExpense.vue').default);
Vue.component('edit-expense', require('./components/financeManagement/Expense/Edit/EditExpense.vue').default);
Vue.component('view-expense', require('./components/financeManagement/Expense/View/ViewExpense.vue').default);

// Finance Management | Expense Transportation
Vue.component('expense-list-transportation', require('./components/financeManagement/ExpenseTransportation/ExpenseTransportationList.vue').default);
Vue.component('create-expense-transportation', require('./components/financeManagement/ExpenseTransportation/Create/CreateExpenseTransportation.vue').default);
Vue.component('edit-expense-transportation', require('./components/financeManagement/ExpenseTransportation/Edit/EditExpenseTransportation.vue').default);
Vue.component('view-expense-transportation', require('./components/financeManagement/ExpenseTransportation/View/ViewExpenseTransportation.vue').default);

// Finance Management | Income
Vue.component('income-list', require('./components/financeManagement/Income/IncomeList.vue').default);
Vue.component('create-income', require('./components/financeManagement/Income/Create/CreateIncome.vue').default);
Vue.component('edit-income', require('./components/financeManagement/Income/Edit/EditIncome.vue').default);
Vue.component('view-income', require('./components/financeManagement/Income/View/ViewIncome.vue').default);

// Report
Vue.component('employee-report-list', require('./components/report/Employee/EmployeeReportList.vue').default);
Vue.component('client-report-list', require('./components/report/Client/ClientReportList.vue').default);
Vue.component('project-report-list', require('./components/report/Project/ProjectReportList.vue').default);
Vue.component('expense-report-list', require('./components/report/Expense/ExpenseReportList.vue').default);
Vue.component('income-report-list', require('./components/report/Income/IncomeReportList.vue').default);

// User
Vue.component('user-list', require('./components/userManagement/UserList.vue').default);
Vue.component('create-user', require('./components/userManagement/Create/CreateUser.vue').default);
Vue.component('edit-user', require('./components/userManagement/Edit/EditUser.vue').default);
Vue.component('view-user', require('./components/userManagement/View/ViewUser.vue').default);
Vue.component('view-user', require('./components/userManagement/View/ViewUser.vue').default);

// Profile
Vue.component('user-profile', require('./components/profile/UserProfile.vue').default);

// Activity Logs
Vue.component('activity-logs', require('./components/activityLogs/ActivityLog.vue').default);

// User Reniew
Vue.component('user-reniew', require('./components/UserRenew/SecurityQuestions/UserRenew.vue').default);
Vue.component('user-reset-password', require('./components/UserRenew/ResetPassword/UserResetPassword.vue').default);

// Landing Page
Vue.component('landing-page', require('./components/landingPage/LandingPage.vue').default);


Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue').default
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue').default
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue').default
);

Vue.component(
    'not-found',
    require('./components/NotFound.vue').default
);

// Filter Section

Vue.filter('myDate',function(created){
    return moment(created).format('MMMM Do YYYY');
});

Vue.filter('yesno', value => (value ? '<i class="fas fa-check green"></i>' : '<i class="fas fa-times red"></i>'));

// end Filter

const app = new Vue({
    el: '#app',
    // router,
    vuetify,
});

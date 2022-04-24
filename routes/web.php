<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\ClientPrintController;
use App\Http\Controllers\IncomePrintController;
use App\Http\Controllers\ManageUsersController;
use App\Http\Controllers\ExpensePrintController;
use App\Http\Controllers\ManageClientController;
use App\Http\Controllers\ManageIncomeController;
use App\Http\Controllers\ProjectPrintController;
use App\Http\Controllers\EmployeePrintController;
use App\Http\Controllers\ManageExpenseController;
use App\Http\Controllers\ManageProjectsController;
use App\Http\Controllers\ManageEmployeesController;
use App\Http\Controllers\ClientProjectPrintController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\ManageClientReportController;
use App\Http\Controllers\ManageIncomeReportController;
use App\Http\Controllers\ManageExpenseReportController;
use App\Http\Controllers\ManageProjectReportController;
use App\Http\Controllers\ManageEmployeeReportController;
use App\Http\Controllers\ManageExpenseTransportationController;
use App\Http\Controllers\UserResetPasswordController;
use App\Http\Controllers\UserSecurityQuestionController;

Route::get('/', [LandingPageController::class, 'index'])->name('landing-page.index');
Route::post('/contact', [LandingPageController::class, 'store'])->name('landing-page.store');
Auth::routes();

Route::get('/test', function () {
});

Route::group(['middleware' => ['auth', 'activated']], function () {
    // User Security Questions
    Route::get('/user-security-questions', [UserSecurityQuestionController::class, 'index'])
        ->name('user.security-questions.index');
    Route::post('/user-security-questions', [UserSecurityQuestionController::class, 'store'])
        ->name('user.security-questions.store');

    // User Reset Password
    Route::get('/user-reset-password', [UserResetPasswordController::class, 'index'])
        ->name('user.reset.password.index');
    Route::put('/user-reset-password', [UserResetPasswordController::class, 'update'])
        ->name('user.reset.password.update');

    Route::group(['middleware' => ['renewed']], function () {
        // Dashboard
        Route::get('/home', [HomeController::class, 'index'])->name('home');

        // User Profile
        Route::view('/user-profile', 'pages.profile.index')->name('user-profile');

        // Content Management
        Route::group([
            'prefix' => 'content',
            'as' => 'content.',
            'middleware' => ['canManage:content', 'password.confirm']
        ], function () {
            Route::view('/contact-details', 'pages.content.contact-details')->name('contact-details');
            Route::view('/business-overview', 'pages.content.business-overview')->name('business-overview');
            Route::view('/team', 'pages.content.team')->name('team');
            Route::view('/services', 'pages.content.services')->name('services');
            Route::view('/freebies', 'pages.content.freebies')->name('freebies');
        });

        // Employee
        Route::group(['middleware' => 'canManage:employees'], function () {
            Route::resource('employees', ManageEmployeesController::class)->except(['store', 'update', 'destroy']);
        });

        // User
        Route::group(['middleware' => 'canManage:users'], function () {
            Route::resource('users', ManageUsersController::class)->except(['store', 'update', 'destroy']);
        });

        // Client
        Route::group(['middleware' => 'canManage:clients'], function () {
            Route::resource('clients', ManageClientController::class)->except(['store', 'update', 'destroy']);
        });

        // Projects
        Route::group(['middleware' => 'canManage:projects'], function () {
            Route::resource('projects', ManageProjectsController::class)->except(['store', 'update', 'destroy']);
        });

        // Finance
        Route::group(['middleware' => 'canManage:finance'], function () {
            // Finance | Expense
            Route::resource('expenses', ManageExpenseController::class)->except(['store', 'update', 'destroy']);
            // Finance | Expense Transportation
            Route::resource('expenses-transportation', ManageExpenseTransportationController::class)->except(['store', 'update', 'destroy']);
            // Finance | Income
            Route::resource('incomes', ManageIncomeController::class)->except(['store', 'update', 'destroy']);
        });

        // Report
        Route::group(['middleware' => 'canManage:report'], function () {
            // Report | Employee
            Route::get('employee-report', [ManageEmployeeReportController::class, 'index'])->name('employee-report.index');
            Route::resource('employee-report-print', EmployeePrintController::class)->only(['index', 'show']);

            // Report | Client
            Route::get('client-report', [ManageClientReportController::class, 'index'])->name('client-report.index');
            Route::get('client-project-report-print/{id}', [ClientProjectPrintController::class, 'show'])->name('client-project-report-print.show');
            Route::resource('client-report-print', ClientPrintController::class)->only(['index', 'show']);

            // Report | Project
            Route::get('project-report', [ManageProjectReportController::class, 'index'])->name('project-report.index');
            Route::resource('project-report-print', ProjectPrintController::class)->only(['index', 'show']);

            // Report | Expense
            Route::get('expense-report', [ManageExpenseReportController::class, 'index'])->name('expense-report.index');
            Route::get('expense-report-print', [ExpensePrintController::class, 'index'])->name('expense-report-print.index');

            // Report | Income
            Route::get('income-report', [ManageIncomeReportController::class, 'index'])->name('income-report.index');
            Route::get('income-report-print', [IncomePrintController::class, 'index'])->name('income-report-print.index');
        });

        Route::group(['middleware' => 'isAdmin'], function () {
            // Activity Log
            Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');

            // System Setup
            Route::view('/security-questions', 'pages.system-setup.security-questions')->name('system-setup.security-questions');
            Route::view('/positions', 'pages.system-setup.positions')->name('system-setup.positions');
            Route::view('/departments', 'pages.system-setup.departments')->name('system-setup.departments');
            Route::view('/expense-category', 'pages.system-setup.expenses')->name('system-setup.expenses.category');
            Route::view('/incomes-category', 'pages.system-setup.incomes')->name('system-setup.incomes.category');
            Route::view('/employee-status', 'pages.system-setup.employee-status')->name('system-setup.employee.status');
            Route::view('/academic-degrees', 'pages.system-setup.academic-degrees')->name('system-setup.academic.degrees');
            Route::view('/schools', 'pages.system-setup.schools')->name('system-setup.schools');
            Route::view('/project-status', 'pages.system-setup.project-status')->name('system-setup.project.status');
            Route::view('/project-category', 'pages.system-setup.project-category')->name('system-setup.project.category');
        });
    });
});

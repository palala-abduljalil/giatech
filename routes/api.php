<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UpdateClientAvatarController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

use App\Http\Controllers\API\V1\Client\ClientController;
use App\Http\Controllers\API\V1\Client\ClientProjectController;
use App\Http\Controllers\API\V1\Employee\SkillController;
use App\Http\Controllers\API\V1\Project\ProjectController;
use App\Http\Controllers\API\V1\SystemSetup\DegreeController;
use App\Http\Controllers\API\V1\SystemSetup\SchoolController;
use App\Http\Controllers\API\V1\Employee\AchievementController;
use App\Http\Controllers\API\V1\SystemSetup\PositionController;
use App\Http\Controllers\API\V1\SystemSetup\DepartmentController;
use App\Http\Controllers\API\V1\Finance\Expense\ExpenseController;
use App\Http\Controllers\API\V1\Project\ProjectActivityController;
use App\Http\Controllers\API\V1\Project\ProjectAttachmentController;
use App\Http\Controllers\API\V1\SystemSetup\ProjectStatusController;
use App\Http\Controllers\API\V1\SystemSetup\EmployeeStatusController;
use App\Http\Controllers\API\V1\SystemSetup\IncomeCategoryController;
use App\Http\Controllers\API\V1\Employee\EmployeeAttachmentController;
use App\Http\Controllers\API\V1\SystemSetup\ExpenseCategoryController;
use App\Http\Controllers\API\V1\SystemSetup\ProjectCategoryController;
use App\Http\Controllers\API\V1\SystemSetup\SecurityQuestionController;
use App\Http\Controllers\API\V1\Employee\UpdateEmployeeAvatarController;
use App\Http\Controllers\API\V1\Finance\Expense\ExpenseAttachmentController;
use App\Http\Controllers\API\V1\ContentManagementControllers\AboutController;
use App\Http\Controllers\API\V1\ContentManagementControllers\CompanyController;
use App\Http\Controllers\API\V1\ContentManagementControllers\FreebieController;
use App\Http\Controllers\API\V1\ContentManagementControllers\ServiceController;
use App\Http\Controllers\API\V1\ContentManagementControllers\EmployeeController;
use App\Http\Controllers\API\V1\ContentManagementControllers\StakeholderController;
use App\Http\Controllers\API\V1\ContentManagementControllers\FreebieDescriptionController;
use App\Http\Controllers\API\V1\ContentManagementControllers\ServiceDescriptionController;
use App\Http\Controllers\API\V1\Finance\ExpenseTransportation\ExpenseTransportationController;
use App\Http\Controllers\API\V1\Finance\Income\IncomeController;
use App\Http\Controllers\API\V1\Profile\ChangeUserSecurityQuestionController;
use App\Http\Controllers\API\V1\SystemModule\SystemModuleController;
use App\Http\Controllers\API\V1\SystemSetup\RoleController;
use App\Http\Controllers\API\V1\User\ChangeUserPasswordController;
use App\Http\Controllers\API\V1\User\ResetPasswordController;
use App\Http\Controllers\API\V1\User\UserActivationController;
use App\Http\Controllers\API\V1\User\UserActivityLogController;
use App\Http\Controllers\API\V1\User\UserController;
use App\Http\Controllers\API\V1\User\UserSecurityQuestionController;

Route::get('version', function () {
    return response()->json(['version' => config('app.version')]);
});

Route::group(['middleware' => 'auth:api'], function () {
    // Profile
    Route::put('user-profile/change-password', [ChangeUserPasswordController::class, 'update'])->name('user.change-password');
    Route::put('user-profile/change-security-question', [ChangeUserSecurityQuestionController::class, 'update'])->name('user.change-security-question');

    // Content 
    Route::group(['middleware' => 'canManage:content'], function () {
        Route::apiResource('company', CompanyController::class)->only(['index', 'update']);
        Route::group([
            'prefix' => 'company',
            'as' => 'company.'
        ], function () {
            Route::put('freebie/{company}/freebie-description', [FreebieDescriptionController::class, 'update'])->name('freebie.description.update');
            Route::put('service/{company}/service-description', [ServiceDescriptionController::class, 'update'])->name('service.description.update');

            Route::apiResource('stakeholder',  StakeholderController::class)->except(['show']);
            Route::apiResource('about',        AboutController::class)->only(['show', 'update']);
            Route::apiResource('freebie',      FreebieController::class)->except(['show']);
            Route::apiResource('service',      ServiceController::class)->except(['show']);
        });
    });

    // Employee
    Route::group(['middelware' => 'canManage:employees'], function () {
        Route::put('employee/{employee}/update-avatar', [UpdateEmployeeAvatarController::class, 'update'])->name('employee.update.avatar');
        Route::apiResource('employee',              EmployeeController::class);
        Route::apiResource('employee.achievement',  AchievementController::class);
        Route::apiResource('employee.skill',        SkillController::class);
        Route::apiResource('employee.attachment',   EmployeeAttachmentController::class)->except(['update']);
    });

    // User
    Route::group(['middelware' => 'canManage:users'], function () {
        Route::put('user/{user}/reset-password', [ResetPasswordController::class, 'update'])->name('user.reset-password');
        Route::apiResource('user-activation', UserActivationController::class)->only(['store', 'update']);
        Route::apiResource('user', UserController::class);
        Route::apiResource('user.security-question', UserSecurityQuestionController::class)->only(['index', 'update']);
        Route::get('user/{user}/activity-log', [UserActivityLogController::class, 'index'])->name('user.index.activity-log');
        // Module
        Route::get('module', [SystemModuleController::class, 'index'])->name('module.index');
    });

    // Client
    Route::group(['middelware' => 'canManage:clients'], function () {
        Route::put('client/{client}/update-avatar', [UpdateClientAvatarController::class, 'update'])->name('client.update.avatar');
        Route::apiResource('client', ClientController::class);
        Route::get('client/{client}/project', [ClientProjectController::class, 'index'])->name('client.project.index');
    });

    // Project
    Route::group(['middelware' => 'canManage:projects'], function () {
        Route::apiResource('project',               ProjectController::class);
        Route::apiResource('project.activity',      ProjectActivityController::class);
        Route::apiResource('project.attachment',    ProjectAttachmentController::class);
    });

    // Finance
    Route::group(['middelware' => 'canManage:finance'], function () {
        // Finance | Expense
        Route::apiResource('expense.attachment', ExpenseAttachmentController::class);
        Route::apiResource('expense',            ExpenseController::class);

        // Finance | Expense Transportation
        Route::apiResource('expense-transportation', ExpenseTransportationController::class);

        // Finance | Income
        Route::apiResource('income', IncomeController::class);
    });

    // System setup
    Route::group(['middelware' => 'isAdmin'], function () {
        Route::apiResource('security-question',     SecurityQuestionController::class)->except(['show']);
        Route::apiResource('position',              PositionController::class)->except(['show']);
        Route::apiResource('department',            DepartmentController::class)->except(['show']);
        Route::apiResource('expense-category',      ExpenseCategoryController::class)->except(['show']);
        Route::apiResource('income-category',       IncomeCategoryController::class)->except(['show']);
        Route::apiResource('degree',                DegreeController::class)->except(['show']);
        Route::apiResource('school',                SchoolController::class)->except(['show']);
        Route::apiResource('project-category',      ProjectCategoryController::class);
        Route::apiResource('project-status',        ProjectStatusController::class);
        Route::apiResource('employee-status',       EmployeeStatusController::class)->except(['show']);
        Route::apiResource('role',                  RoleController::class)->except(['show']);
    });
});

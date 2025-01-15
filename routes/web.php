<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ForemanController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::prefix('auth')->group(function () {
    Route::get('login', [LoginController::class, 'login'])->name('login');
    Route::post('login', [LoginController::class, 'loginAction'])->name('login.action');
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});

// Authenticate
Route::middleware('auth')->group(function () {
    // Admin Only
    Route::group(['middleware' => ['auth', 'CekLevel:1']], function () {
        // Routing for Dashboard Admin

        // Routing for Project
        Route::prefix('project')->group(function () {
            Route::get('indexProject', [AdminController::class, 'indexProject'])->name('project.index');
            Route::get('getData', [AdminController::class, 'getData'])->name('project.getData');
            Route::post('storeProject', [AdminController::class, 'storeProject'])->name('project.store');
            Route::get('editProject/{id_project}', [AdminController::class, 'editProject'])->name('project.edit');
            Route::put('updateProject/{id_project}', [AdminController::class, 'updateProject'])->name('project.update');
            Route::delete('destroyProject/{id_project}', [AdminController::class, 'destroyProject'])->name('project.destroy');
            Route::post('importProject', [AdminController::class, 'importProject'])->name('project.importProject');
        });

        // Routing for LJKH
        Route::prefix('ljkh')->group(function () {
            Route::get('exportLJKH', [AdminController::class, 'exportLJKH'])->name('admin.exportLJKH');
            Route::post('importLJKH', [AdminController::class, 'importLJKH'])->name('importLJKH');
            Route::get('admin/index', [AdminController::class, 'index'])->name('admin.ljkh');
            Route::get('create', [AdminController::class, 'create'])->name('admin.addLJKH');
            Route::post('store', [AdminController::class, 'store'])->name('admin.storeLJKH');
            Route::get('edit/{id_ljkh}', [AdminController::class, 'edit'])->name('admin.editLJKH');
            Route::put('update/{id_ljkh}', [AdminController::class, 'update'])->name('admin.updateLJKH');
            Route::delete('destroy/{id_ljkh}', [AdminController::class, 'destroy'])->name('admin.deleteLJKH');
        });

        // Routing For Profile/User Setting
        Route::prefix('profile')->group(function () {
            Route::get('indexUser', [AdminController::class, 'indexUser'])->name('admin.indexUser');
            Route::get('createUser', [AdminController::class, 'createUser'])->name('admin.createUser');
            Route::get('editUser/{id}', [AdminController::class, 'editUser'])->name('admin.editUser');
            Route::put('updateUser/{id}', [AdminController::class, 'updateUser'])->name('admin.updateUser');
            Route::delete('destroyUser/{id}', [AdminController::class, 'destroyUser'])->name('admin.destroyUser');
            Route::post('storeUser', [AdminController::class, 'storeUser'])->name('admin.storeUser');
        });
    });

    // Foreman Only
    Route::group(['middleware' => ['auth', 'CekLevel:2']], function () {
        // Routing For Foreman Dashboard
        Route::prefix('foreman')->group(function() {
            Route::get('foreman', [ForemanController::class, 'currentProcess'])->name('foreman.DashboardForeman');
            Route::get('Dashboard/{param1?}/{param2?}/{param3?}', [AdminController::class, 'dashboard'])->name('admin.DashboardAdmin');
            Route::get('showTableDashboard', [AdminController::class, 'showTableDashboard'])->name('showTableDashboard');
            Route::get('download-pdf', [ForemanController::class, 'downloadPDF'])->name('download.pdf');

        });

        Route::prefix('validasi')->group(function () {
            Route::get('indexValidasi', [ForemanController::class, 'indexValidasi'])->name('foreman.ListValidasiJob');
            Route::get('validated', [ForemanController::class, 'validated'])->name('foreman.jobValidated');
            Route::get('showJob/{id_jobList}', [ForemanController::class, 'showJob'])->name('foreman.showValidasiJob');
            Route::put('validasiJob/{id_jobList}', [ForemanController::class, 'validasiJob'])->name('foreman.validasiJob');
            Route::post('priorityJob/{id_jobList}', [ForemanController::class, 'priorityJob'])->name('foreman.priorityJob');
        });
    });

    // Member Only
    Route::group(['middleware' => ['auth', 'CekLevel:3']], function () {
    // Route::group(['middleware' => ['auth', 'CekLevel:2,3']], function () {
        Route::get('index', [MemberController::class, 'index'])->name('member.index');
        Route::post('submit', [MemberController::class, 'submit'])->name('downtime.submit');
        Route::post('submitStop/{id_ljkh}', [MemberController::class, 'submitStop'])->name('downtime.submitStop');
        Route::get('showJobMember/{id_ljkh}', [MemberController::class, 'showJobMember'])->name('member.showJobMember');
        Route::post('jobStart/{id_ljkh}', [MemberController::class, 'jobStart'])->name('member.start');
        Route::post('jobEnd/{id_ljkh}', [MemberController::class, 'jobEnd'])->name('member.stop');
        Route::post('takeJob/{id_jobList}', [MemberController::class, 'takeJob'])->name('job.take');
        Route::post('holdJob/{id_ljkh}', [MemberController::class, 'holdJob'])->name('member.hold');
        Route::get('indexJob', [MemberController::class, 'indexJob'])->name('member.indexJob');
        Route::post('autoRunNPK/{id_ljkh}', [MemberController::class, 'autoRunNPK'])->name('member.autoRunNPK');
        Route::post('autoIdle', [MemberController::class, 'autoIdle'])->name('downtime.autoIdle');
        Route::post('setting', [MemberController::class, 'setting'])->name('member.setting');
        Route::post('settingDone', [MemberController::class, 'settingDone'])->name('member.settingDone');
        Route::post('changeTask/{id_ljkh}', [MemberController::class, 'changeTask'])->name('member.changeTask');
        Route::post('endTask/{id_ljkh}', [MemberController::class, 'endTask'])->name('member.endTask');
        Route::post('autoRunEnd/{id_ljkh}', [MemberController::class, 'autoRunEnd'])->name('member.autoRunEnd');
        Route::post('shift/{id_ljkh}', [MemberController::class, 'shift'])->name('member.shift');
        Route::post('break', [MemberController::class, 'break'])->name('member.break');
        Route::post('breakDone', [MemberController::class, 'breakDone'])->name('member.breakDone');
    });
});

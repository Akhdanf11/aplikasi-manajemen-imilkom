<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ExpenditureController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\LeaveRequestController;

// Resource route for projects
Route::resource('projects', ProjectController::class);

// Group routes related to projects with a common prefix
Route::prefix('projects/{project}')->group(function () {
    // Routes for tasks within a project
    Route::resource('tasks', TaskController::class)->except(['show']);
    
    // Routes for expenditures within a project
    Route::get('expenditures/create', [ExpenditureController::class, 'create'])->name('projects.expenditures.create');
    Route::post('expenditures', [ExpenditureController::class, 'store'])->name('projects.expenditures.store');
    Route::put('expenditures/{expenditure}', [ExpenditureController::class, 'update'])->name('projects.expenditures.update');
    Route::delete('expenditures/{expenditure}', [ExpenditureController::class, 'destroy'])->name('projects.expenditures.destroy');

    // Routes for income within a project
    Route::get('income/create', [IncomeController::class, 'create'])->name('projects.income.create');
    Route::post('income', [IncomeController::class, 'store'])->name('projects.income.store');
    Route::put('income/{income}', [IncomeController::class, 'update'])->name('projects.income.update');
    Route::delete('income/{income}', [IncomeController::class, 'destroy'])->name('projects.income.destroy');
});

// General dashboard route
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');

// Routes for specific roles
Route::middleware(['auth', 'role:Anggota Departemen'])->group(function () {
    Route::get('/dashboard/anggota-departemen', [DashboardController::class, 'anggotaDepartemen'])->name('dashboard.anggota-departemen');
});

Route::middleware(['auth', 'role:Kepala Departemen,Sekretaris Departemen'])->group(function () {
    Route::get('/dashboard/kepala-departemen', [DashboardController::class, 'kepalaDepartemen'])->name('dashboard.kepala-departemen');
});

Route::middleware(['auth', 'role:Ketua Umum,Sekretaris Umum,Bendahara Umum'])->group(function () {
    Route::get('/dashboard/bph', [DashboardController::class, 'bph'])->name('dashboard.bph');

    // BPH-specific routes
    Route::get('/bph/projects', [ProjectController::class, 'bphIndex'])->name('bph.projects');
    Route::get('/department/projects', [ProjectController::class, 'departmentIndex'])->name('department.projects');

    Route::get('/attendance/report', [AttendanceController::class, 'report'])->name('attendance.report');

    Route::post('/leave-requests/{id}/approve', [LeaveRequestController::class, 'approve'])->name('leave_requests.approve');
    Route::post('/leave-requests/{id}/reject', [LeaveRequestController::class, 'reject'])->name('leave_requests.reject');
});

// Routes accessible to all authenticated users
Route::middleware(['auth'])->group(function () {
    Route::resource('inventories', InventoryController::class);
    Route::get('/inventories/{id}/confirm-delete', [InventoryController::class, 'confirmDelete'])->name('inventories.confirmDelete');
    Route::delete('/inventories/{id}', [InventoryController::class, 'destroy'])->name('inventories.destroy');

    Route::get('/attendance/schedule', [AttendanceController::class, 'schedule'])->name('attendance.schedule');
    Route::post('/attendance/clock-in', [AttendanceController::class, 'clockIn'])->name('attendance.clockIn');
    Route::post('/attendance/clock-out', [AttendanceController::class, 'clockOut'])->name('attendance.clockOut');
    Route::get('/leave-requests', [LeaveRequestController::class, 'index'])->name('leave_requests.index');
    Route::get('/leave-requests/create', [LeaveRequestController::class, 'create'])->name('leave_requests.create');
    Route::post('/leave-requests', [LeaveRequestController::class, 'store'])->name('leave_requests.store');
});

// Welcome page
Route::get('/', function () {
    return view('welcome');
});

// User management routes for specific roles
Route::middleware(['auth', 'role:Ketua Umum,Sekretaris Umum,Bendahara Umum'])->group(function () {
    Route::resource('users', UserController::class);
});

// Authentication routes
Auth::routes();

// Home route
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

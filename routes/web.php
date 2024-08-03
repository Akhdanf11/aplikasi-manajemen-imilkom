<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ExpenditureController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InventoryController;

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

// Dashboard routes
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');

// Dashboard routes by role
Route::middleware(['auth', 'role:Anggota Departemen'])->group(function () {
    Route::get('/dashboard/anggota-departemen', [DashboardController::class, 'anggotaDepartemen'])->name('dashboard.anggota-departemen');
});
Route::middleware(['auth', 'role:Kepala Departemen, Sekretaris Departemen'])->group(function () {
    Route::get('/dashboard/kepala-departemen', [DashboardController::class, 'kepalaDepartemen'])->name('dashboard.kepala-departemen');
});
Route::middleware(['auth', 'role:Ketua Umum, Sekretaris Umum, Bendahara Umum'])->group(function () {
    Route::get('/dashboard/bph', [DashboardController::class, 'bph'])->name('dashboard.bph');
});

// For BPH to view projects and tasks by department
Route::get('/bph/projects', [ProjectController::class, 'bphIndex'])->name('bph.projects');

// For department heads and members to view their specific department projects and tasks
Route::get('/department/projects', [ProjectController::class, 'departmentIndex'])->name('department.projects');

Route::resource('inventories', InventoryController::class);

Route::middleware(['auth'])->group(function () {
    Route::get('/inventories/{id}/confirm-delete', [InventoryController::class, 'confirmDelete'])->name('inventories.confirmDelete');
    Route::delete('/inventories/{id}', [InventoryController::class, 'destroy'])->name('inventories.destroy');
});


// Welcome page
Route::get('/', function () {
    return view('welcome');
});
Route::group(['middleware' => ['role:Ketua Umum,Sekretaris Umum,Bendahara Umum']], function () {
    Route::resource('users', UserController::class);
});


// Authentication routes
Auth::routes();

// Home route
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\PeriodePaieController;
use App\Http\Controllers\TraitementPaieController;
use App\Http\Controllers\Admin\GestionnaireClientController;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    // Profile routes
    Route::post('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/settings', [ProfileController::class, 'settings'])->name('profile.settings');
    Route::post('/profile/update-account', [ProfileController::class, 'updateAccount'])->name('profile.update-account');
    Route::post('/logout', [ProfileController::class, 'logout'])->name('logout');

    // Search route
    Route::get('/search', [ProfileController::class, 'search'])->name('search');

    // Resource routes
    Route::resource('roles', RoleController::class)->except(['show']);
    Route::resource('users', UserController::class);
    Route::resource('clients', ClientController::class);
    Route::resource('clients.materials', MaterialController::class);

    Route::resource('materials', MaterialController::class);
    Route::resource('gestionnaire-client', GestionnaireClientController::class);
    Route::resource('periodes-paie', PeriodePaieController::class);
    Route::resource('traitements-paie', TraitementPaieController::class);
    Route::resource('tickets', TicketController::class);

    // Additional role and permission routes
    Route::get('/permissions/create', [RoleController::class, 'createPermission'])->name('permissions.create');
    Route::post('/permissions', [RoleController::class, 'storePermission'])->name('permissions.store');
    Route::get('/roles/assign', [RoleController::class, 'assignRole'])->name('roles.assign');
    Route::post('/roles/assign', [RoleController::class, 'storeAssignRole'])->name('roles.assign.store');
});

// Admin routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\HomeController::class, 'index'])->name('index');
});

require __DIR__ . '/auth.php';

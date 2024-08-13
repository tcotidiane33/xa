<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PeriodePaieController;
use App\Admin\Controllers\ClientController;
use App\Admin\Controllers\TraitementPaieController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::get('/admin', [App\Admin\Controllers\HomeController::class, 'index'])->name('admin');
    
    // Route::resource('roles', RoleController::class);
    Route::resource('roles', RoleController::class)->except(['show']);
    Route::get('/permissions/create', [RoleController::class, 'createPermission'])->name('permissions.create');
    Route::post('/permissions', [RoleController::class, 'storePermission'])->name('permissions.store');
    Route::get('/roles/assign', [RoleController::class, 'assignRole'])->name('roles.assign');
Route::post('/roles/assign', [RoleController::class, 'storeAssignRole'])->name('roles.assign.store');

Route::resource('clients', ClientController::class);
Route::resource('traitements-paie', TraitementPaieController::class);
    Route::resource('/periodes-paie', PeriodePaieController::class);
    Route::resource('/tickets', TicketController::class);
    Route::resource('/users', UserController::class);
});

// Route::group(['middleware' => ['role:admin']], function () {
//     Route::resource('roles', RoleController::class);
// });

// Route::group(['middleware' => ['permission:view clients']], function () {
//     Route::get('/clients', [ClientController::class, 'index']);
// });
require __DIR__.'/auth.php';

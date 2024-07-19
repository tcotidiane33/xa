<?php

use Illuminate\Support\Facades\Route;
use App\Admin\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
// use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PeriodePaieController;
use App\Http\Controllers\TraitementPaieController;

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

    Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/admin', [HomeController::class, 'index'])->name('admin');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('traitement-paie', TraitementPaieController::class);

Route::get('traitement-paie/{id}/edit', [TraitementPaieController::class, 'edit'])->name('traitements_paie.edit');
Route::delete('/traitements_paie/{traitementPaie}', 'TraitementPaieController@destroy')->name('traitements_paie.destroy');
Route::put('traitement-paie/{id}', [TraitementPaieController::class, 'update'])->name('traitements_paie.update');

Route::get('clients', [TraitementPaieController::class, 'clients'])->name('clients.index');
Route::get('periodes-paie', [TraitementPaieController::class, 'periodesPaie'])->name('traitement-paie.periodes-paie.index');
Route::get('periodes-paie/liste', [PeriodePaieController::class, 'periodesPaie'])->name('periodes-paie.index');
Route::post('periodes-paie/valider', [PeriodePaieController::class, 'valider'])->name('periodes_paie.valider');
Auth::routes();

require __DIR__.'/auth.php';






<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PeriodePaieController;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/periodes-paie', [PeriodePaieController::class, 'index'])->name('periodes_paie.index');
Route::post('/periodes-paie/valider', [PeriodePaieController::class, 'valider'])->name('periodes_paie.valider');
Route::post('/traitements-paie/{traitementPaie}/update-field', [PeriodePaieController::class, 'updateField'])->name('traitements_paie.update_field');
// Route::get('/periodes-paie', [PeriodePaieController::class, 'index'])->name('periodes_paie.index');
// Route::post('/periodes-paie/valider', [PeriodePaieController::class, 'valider'])->name('periodes_paie.valider');
require __DIR__.'/auth.php';






<?php

use App\Http\Controllers\TabFormController;
use Illuminate\Support\Facades\Route;

Route::get('/tab-form', [TabFormController::class, 'index'])->name('tab-form.index');
Route::post('/tab-form', [TabFormController::class, 'store'])->name('tab-form.store');
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MailController;
use App\Http\Controllers\PostController;
use App\Admin\Controllers\HomeController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PeriodePaieController;
use App\Http\Controllers\NotificationController;
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

    // Routes pour les tickets
    Route::resource('tickets', TicketController::class); // Define routes for index, create, store, edit, update, destroy

    // Posts Reply Comments
    // Posts Routes
    Route::resource('posts', PostController::class);

    // Comments Routes
    Route::post('/posts/{postId}/comments', [PostController::class, 'addComment'])->name('posts.comments.store');

    // Replies Routes
    Route::post('/comments/{commentId}/replies', [PostController::class, 'addReply'])->name('comments.replies.store');

    // Notifications Routes
    // Route::resource('notifications', NotificationController::class);
    Route::get('/notifications/create', [NotificationController::class, 'create'])->name('notifications.create');
    Route::post('/notifications', [NotificationController::class, 'store'])->name('notifications.store');
});

// Traitement Paie Routes
Route::get('clients', [TraitementPaieController::class, 'clients'])->name('clients.index');

Auth::routes();

// Send mails alert
Route::get('send-mail', [MailController::class, 'index']);

// Include authentication routes
require __DIR__ . '/auth.php';





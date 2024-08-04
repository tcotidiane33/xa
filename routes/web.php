<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MailController;
use App\Http\Controllers\PostController;
// use App\Http\Controllers\DashboardController;
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

    // Routes pour les notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/markAsRead', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');

    // Posts Reply Comments
     // Afficher un post spécifique
     Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{id}', [PostController::class, 'show'])->name('posts.show');
    Route::get('/posts/{id}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{id}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{id}', [PostController::class, 'destroy'])->name('posts.destroy');
    //  Route::get('/posts/{id}', [PostController::class, 'show'])->name('posts.show');

    //  // Créer un nouveau post (utilisation de POST)
    //  Route::post('/posts', [PostController::class, 'store'])->name('posts.store');

    //  // Ajouter un commentaire à un post spécifique (utilisation de POST)
    //  Route::post('/posts/{postId}/comments', [PostController::class, 'addComment'])->name('posts.comments.store');

     // Ajouter une réponse à un commentaire spécifique (utilisation de POST)
     Route::post('/comments/{commentId}/replies', [PostController::class, 'addReply'])->name('comments.replies.store');
});

// Route::resource('/traitement-paie', TraitementPaieController::class);

// Route::get('/traitement-paie/{id}/edit', [TraitementPaieController::class, 'edit'])->name('traitements_paie.edit');
// Route::delete('/traitements_paie/{traitementPaie}', 'TraitementPaieController@destroy')->name('traitements_paie.destroy');
// Route::put('/traitement-paie/{id}', [TraitementPaieController::class, 'update'])->name('traitements_paie.update');

Route::get('clients', [TraitementPaieController::class, 'clients'])->name('clients.index');
// Route::get('periodes-paie', [TraitementPaieController::class, 'periodesPaie'])->name('traitement-paie.periodes-paie.index');
// Route::get('periodes-paie/liste', [PeriodePaieController::class, 'periodesPaie'])->name('periodes-paie.index');
// Route::post('periodes-paie/valider', [PeriodePaieController::class, 'valider'])->name('periodes_paie.valider');
Auth::routes();


//send mails Alerte
Route::get('send-mail', [MailController::class, 'index']);


// routes/web.php

require __DIR__ . '/auth.php';






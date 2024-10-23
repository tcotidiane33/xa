<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\PeriodePaieController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\TraitementPaieController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ConventionCollectiveController;
use App\Http\Controllers\Admin\GestionnaireClientController;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::resource('posts', PostController::class);
    Route::delete('posts/attachments/{attachment}', [PostController::class, 'removeAttachment'])->name('posts.remove-attachment');

    // Profile routes
    Route::post('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Route::get('/profile/settings', [ProfileController::class, 'settings'])->name('profile.settings');
    

    Route::post('/profile/update-settings', [ProfileController::class, 'updateSettings'])->name('profile.update-settings');
    Route::post('/profile/update-account', [ProfileController::class, 'updateAccount'])->name('profile.update-account');
    Route::post('/logout', [ProfileController::class, 'logout'])->name('logout');

    // Search route
    Route::get('/search', [ProfileController::class, 'search'])->name('search');

    // Resource routes
    Route::resource('users', UserController::class);
    Route::get('/users/{user}/manage-clients', [UserController::class, 'manageClients'])->name('users.manage_clients');
    Route::post('/users/{user}/attach-client', [UserController::class, 'attachClient'])->name('users.attach_client');
    Route::delete('/users/{user}/detach-client', [UserController::class, 'detachClient'])->name('users.detach_client');
    Route::post('/users/{user}/transfer-clients', [UserController::class, 'transferClients'])->name('users.transfer_clients');
    Route::resource('clients', ClientController::class);
    Route::resource('clients.materials', MaterialController::class);
    Route::get('/clients/{client}/info', [ClientController::class, 'getInfo'])->name('clients.info');
    Route::resource('materials', MaterialController::class);

    // Route::resource('periodes-paie', PeriodePaieController::class);
    // Routes pour PeriodePaie
    Route::get('/periodes-paie', [PeriodePaieController::class, 'index'])->name('periodes-paie.index');
    Route::get('/periodes-paie/create', [PeriodePaieController::class, 'create'])->name('periodes-paie.create');
    Route::post('/periodes-paie', [PeriodePaieController::class, 'store'])->name('periodes-paie.store');
    Route::get('/periodes-paie/{periodePaie}', [PeriodePaieController::class, 'show'])->name('periodes-paie.show');
    Route::get('/periodes-paie/{periodePaie}/edit', [PeriodePaieController::class, 'edit'])->name('periodes-paie.edit');
    Route::put('/periodes-paie/{periodePaie}', [PeriodePaieController::class, 'update'])->name('periodes-paie.update');
    Route::delete('/periodes-paie/{periodePaie}', [PeriodePaieController::class, 'destroy'])->name('periodes-paie.destroy');


    // Route::resource('traitements-paie', TraitementPaieController::class);
    Route::get('/traitements-paie', [TraitementPaieController::class, 'index'])->name('traitements-paie.index');
    Route::get('/traitements-paie/create', [TraitementPaieController::class, 'create'])->name('traitements-paie.create');
    Route::post('/traitements-paie', [TraitementPaieController::class, 'store'])->name('traitements-paie.store');
    Route::get('/traitements-paie/{traitementPaie}', [TraitementPaieController::class, 'show'])->name('traitements-paie.show');
    Route::get('/traitements-paie/{traitementPaie}/edit', [TraitementPaieController::class, 'edit'])->name('traitements-paie.edit');
    Route::put('/traitements-paie/{traitementPaie}', [TraitementPaieController::class, 'update'])->name('traitements-paie.update');
    Route::delete('/traitements-paie/{traitementPaie}', [TraitementPaieController::class, 'destroy'])->name('traitements-paie.destroy');

    // Route::get('/traitements-paie/create', [TraitementPaieController::class, 'create'])->name('traitements-paie.create');
    Route::post('/traitements-paie/store', [TraitementPaieController::class, 'store'])->name('traitements-paie.store');
    Route::post('/traitements-paie/store-partial', [TraitementPaieController::class, 'storePartial'])->name('traitements-paie.storePartial');
    Route::post('/traitements-paie/cancel', [TraitementPaieController::class, 'cancel'])->name('traitements-paie.cancel');

    Route::resource('tickets', TicketController::class);
    Route::resource('convention-collectives', ConventionCollectiveController::class);

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');

    // Ajout de la route validateStep
    Route::get('/clients/{client}/info', [ClientController::class, 'getInfo'])->name('clients.info');
    Route::post('/clients/validate-step/{step}', [ClientController::class, 'validateStep'])->name('clients.validateStep');
    Route::post('/clients/store-partial', [ClientController::class, 'storePartial'])->name('clients.storePartial');
    Route::put('/clients/{client}/update-partial/{step}', [ClientController::class, 'updatePartial'])->name('clients.updatePartial');
    Route::get('/clients/{client}/get-partial/{step}', [ClientController::class, 'getPartial'])->name('clients.getPartial');
});

// Admin routes
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth', 'role:admin']], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.index'); // Tableau de bord admin
    
    // Autres routes pour l'admin
    Route::resource('gestionnaire-client', GestionnaireClientController::class);
    // Route::get('/client/{client}/info', [ClientController::class, 'getInfo'])->name('admin.client.info');
    Route::get('/gestionnaire-client', [GestionnaireClientController::class, 'index'])->name('admin.gestionnaire-client.index');
    Route::get('/gestionnaire-client/{gestionnaireClient}', [GestionnaireClientController::class, 'show'])->name('admin.gestionnaire-client.show');

    // Paramètres et gestion des rôles et permissions
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');
    
    Route::resource('roles', RoleController::class)->except(['show']);
    Route::get('/permissions/create', [RoleController::class, 'createPermission'])->name('permissions.create');
    Route::post('/permissions', [RoleController::class, 'storePermission'])->name('permissions.store');
    Route::get('/roles/assign', [RoleController::class, 'assignRoles'])->name('roles.assign');
    Route::post('/roles/assign', [RoleController::class, 'storeAssignRoles'])->name('roles.assign.store');
    Route::patch('/users/{user}/toggle-status', [RoleController::class, 'toggleUserStatus'])->name('users.toggle-status');
});


require __DIR__ . '/auth.php';
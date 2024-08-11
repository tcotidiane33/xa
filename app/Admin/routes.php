<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');
    $router->get('/infos', 'HomeController@info')->name('info');

    $router->resource('/clients', ClientController::class);
    $router->resource('/domaines', DomaineController::class);
    $router->resource('/fonctions', FonctionController::class);
    $router->resource('/gestionnaires', GestionnaireController::class);
    $router->resource('/gestionnaire-clients', GestionnaireClientController::class);
    $router->resource('/habilitations', HabilitationController::class);
    $router->resource('/periodes-paie', PeriodePaieController::class);
    $router->resource('/roles', RoleController::class);
    $router->resource('/traitements-paie', TraitementPaieController::class);
    $router->resource('/users', UserController::class);
    $router->resource('/convention-collectives', ConventionCollectiveController::class);
    //Posts
    $router->resource('/posts', PostController::class);

    // $router->resource('/dashboards', DashboardController::class);

    // Tickets
    $router->resource('tickets', TicketController::class);
});



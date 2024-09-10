<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\Ticket;
use App\Channels\LogChannel;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Notification;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Enregistre les services de l'application.
     */
    public function register(): void
    {
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('Debugbar', \Barryvdh\Debugbar\Facades\Debugbar::class);
    }

    /**
     * Initialise les services de l'application.
     */
    public function boot(): void
    {
        // Enregistrement des composants Blade
        Blade::component('input-label', 'components.input-label');
        Blade::component('text-input', 'components.text-input');
        Blade::component('primary-button', 'components.primary-button');
        Blade::component('danger-button', 'components.danger-button');
        Blade::component('secondary-button', 'components.secondary-button');
        Blade::component('modal', 'components.modal');
        Blade::component('input-error', 'components.input-error');

        // Utilisation de Bootstrap pour la pagination
        Paginator::useBootstrap();

        // Enregistrement du canal de notification personnalisé pour le logging
        Notification::extend('log', function ($app) {
            return new LogChannel();
        });

        // Partage de variables globales avec toutes les vues
        View::composer('*', function ($view) {
            $view->with([
                'tickets' => Ticket::with('creator')->latest()->take(5)->get(),
                'posts' => Post::latest()->take(5)->get(),
            ]);
        });
    }
}
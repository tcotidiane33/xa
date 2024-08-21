<?php

namespace App\Providers;

// use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        Blade::component('input-label', 'components.input-label');
        Blade::component('text-input', 'components.text-input');
        Blade::component('primary-button', 'components.primary-button');
        Blade::component('danger-button', 'components.danger-button');
        Blade::component('secondary-button', 'components.secondary-button');
        Blade::component('modal', 'components.modal');
        Blade::component('input-error', 'components.input-error');
    }
}

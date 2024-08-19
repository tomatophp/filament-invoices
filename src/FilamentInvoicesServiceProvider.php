<?php

namespace TomatoPHP\FilamentInvoices;

use Illuminate\Support\ServiceProvider;
use TomatoPHP\FilamentCms\Facades\FilamentCMS;
use TomatoPHP\FilamentCms\Services\Contracts\CmsType;


class FilamentInvoicesServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //Register generate command
        $this->commands([
           \TomatoPHP\FilamentInvoices\Console\FilamentInvoicesInstall::class,
        ]);

        //Register Config file
        $this->mergeConfigFrom(__DIR__.'/../config/filament-invoices.php', 'filament-invoices');

        //Publish Config
        $this->publishes([
           __DIR__.'/../config/filament-invoices.php' => config_path('filament-invoices.php'),
        ], 'filament-invoices-config');

        //Register Migrations
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        //Publish Migrations
        $this->publishes([
           __DIR__.'/../database/migrations' => database_path('migrations'),
        ], 'filament-invoices-migrations');
        //Register views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'filament-invoices');

        //Publish Views
        $this->publishes([
           __DIR__.'/../resources/views' => resource_path('views/vendor/filament-invoices'),
        ], 'filament-invoices-views');

        //Register Langs
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'filament-invoices');

        //Publish Lang
        $this->publishes([
           __DIR__.'/../resources/lang' => base_path('lang/vendor/filament-invoices'),
        ], 'filament-invoices-lang');

        //Register Routes
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

    }

    public function boot(): void
    {
        $this->app->bind('filament-invoices', function() {
            return new \TomatoPHP\FilamentInvoices\Services\InvoicesServices();
        });
    }
}

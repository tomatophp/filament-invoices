<?php

namespace TomatoPHP\FilamentInvoices;

use Illuminate\Support\ServiceProvider;
use TomatoPHP\FilamentInvoices\Pages\InvoiceSettingsPage;
use TomatoPHP\FilamentInvoices\Services\Templates\ClassicTemplate;
use TomatoPHP\FilamentInvoices\Services\Templates\CreativeTemplate;
use TomatoPHP\FilamentInvoices\Services\Templates\MinimalTemplate;
use TomatoPHP\FilamentInvoices\Services\Templates\ModernTemplate;
use TomatoPHP\FilamentInvoices\Services\Templates\ProfessionalTemplate;
use TomatoPHP\FilamentInvoices\Services\Templates\TemplateFactory;
use TomatoPHP\FilamentSettingsHub\Facades\FilamentSettingsHub;
use TomatoPHP\FilamentSettingsHub\Services\Contracts\SettingHold;

class FilamentInvoicesServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Register generate command
        $this->commands([
            \TomatoPHP\FilamentInvoices\Console\FilamentInvoicesInstall::class,
        ]);

        // Register Config file
        $this->mergeConfigFrom(__DIR__ . '/../config/filament-invoices.php', 'filament-invoices');

        // Publish Config
        $this->publishes([
            __DIR__ . '/../config/filament-invoices.php' => config_path('filament-invoices.php'),
        ], 'filament-invoices-config');

        // Register Migrations
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        // Publish Settings Migrations
        $this->publishes([
            __DIR__ . '/../database/settings' => database_path('settings'),
        ], 'filament-invoices-settings-migrations');

        // Publish Migrations
        $this->publishes([
            __DIR__ . '/../database/migrations' => database_path('migrations'),
        ], 'filament-invoices-migrations');
        // Register views
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'filament-invoices');

        // Publish Views
        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/filament-invoices'),
        ], 'filament-invoices-views');

        // Register Langs
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'filament-invoices');

        // Publish Lang
        $this->publishes([
            __DIR__ . '/../resources/lang' => base_path('lang/vendor/filament-invoices'),
        ], 'filament-invoices-lang');

        // Register Routes
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

    }

    public function boot(): void
    {
        $this->app->bind('filament-invoices', function () {
            return new \TomatoPHP\FilamentInvoices\Services\InvoicesServices;
        });

        // Register built-in invoice templates
        $this->registerTemplates();

        // Register Invoice Settings with Settings Hub (if enabled via plugin)
        $this->registerSettingsHub();
    }

    protected function registerTemplates(): void
    {
        TemplateFactory::register('classic', ClassicTemplate::class);
        TemplateFactory::register('modern', ModernTemplate::class);
        TemplateFactory::register('minimal', MinimalTemplate::class);
        TemplateFactory::register('professional', ProfessionalTemplate::class);
        TemplateFactory::register('creative', CreativeTemplate::class);
    }

    protected function registerSettingsHub(): void
    {
        if (! class_exists(FilamentSettingsHub::class)) {
            return;
        }

        // Check if any panel has the plugin with useSettingsHub enabled
        $shouldRegister = false;

        try {
            $panels = \Filament\Facades\Filament::getPanels();
            foreach ($panels as $panel) {
                if ($panel->hasPlugin('filament-invoices')) {
                    $plugin = $panel->getPlugin('filament-invoices');
                    if ($plugin instanceof FilamentInvoicesPlugin && $plugin->isSettingsHubEnabled()) {
                        $shouldRegister = true;

                        break;
                    }
                }
            }
        } catch (\Exception $e) {
            // Panels not yet available, skip registration
            return;
        }

        if ($shouldRegister) {
            FilamentSettingsHub::register([
                SettingHold::make()
                    ->label(trans('filament-invoices::messages.settings.title'))
                    ->description(trans('filament-invoices::messages.settings.description'))
                    ->icon('heroicon-o-document-text')
                    ->page(InvoiceSettingsPage::class)
                    ->group(trans('filament-invoices::messages.settings.group'))
                    ->order(10),
            ]);
        }
    }
}

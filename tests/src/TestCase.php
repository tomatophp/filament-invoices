<?php

namespace TomatoPHP\FilamentInvoices\Tests;

use Barryvdh\DomPDF\ServiceProvider as DomPDFServiceProvider;
use BladeUI\Heroicons\BladeHeroiconsServiceProvider;
use BladeUI\Icons\BladeIconsServiceProvider;
use Filament\Actions\ActionsServiceProvider;
use Filament\FilamentServiceProvider;
use Filament\Forms\FormsServiceProvider;
use Filament\Infolists\InfolistsServiceProvider;
use Filament\Notifications\NotificationsServiceProvider;
use Filament\Panel;
use Filament\Schemas\SchemasServiceProvider;
use Filament\Support\SupportServiceProvider;
use Filament\Tables\TablesServiceProvider;
use Filament\Widgets\WidgetsServiceProvider;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\Attributes\WithEnv;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\TestCase as BaseTestCase;
use RyanChandler\BladeCaptureDirective\BladeCaptureDirectiveServiceProvider;
use Spatie\LaravelSettings\LaravelSettingsServiceProvider;
use TomatoPHP\FilamentInvoices\FilamentInvoicesServiceProvider;
use TomatoPHP\FilamentInvoices\Settings\InvoiceSettings;
use TomatoPHP\FilamentSettingsHub\FilamentSettingsHubServiceProvider;

#[WithEnv('DB_CONNECTION', 'testing')]
abstract class TestCase extends BaseTestCase
{
    use LazilyRefreshDatabase;
    use WithWorkbench;

    public ?Panel $panel;

    protected function getPackageProviders($app): array
    {
        $providers = [
            ActionsServiceProvider::class,
            BladeCaptureDirectiveServiceProvider::class,
            BladeHeroiconsServiceProvider::class,
            BladeIconsServiceProvider::class,
            DomPDFServiceProvider::class,
            FilamentServiceProvider::class,
            FormsServiceProvider::class,
            SchemasServiceProvider::class,
            InfolistsServiceProvider::class,
            LivewireServiceProvider::class,
            NotificationsServiceProvider::class,
            SupportServiceProvider::class,
            TablesServiceProvider::class,
            WidgetsServiceProvider::class,
            LaravelSettingsServiceProvider::class,
            FilamentSettingsHubServiceProvider::class,
            FilamentInvoicesServiceProvider::class,
            AdminPanelProvider::class,
        ];

        sort($providers);

        return $providers;
    }

    protected function defineEnvironment($app)
    {
        tap($app['config'], function (Repository $config) {
            $config->set('database.default', 'testing');
            $config->set('database.connections.testing', [
                'driver' => 'sqlite',
                'database' => ':memory:',
                'prefix' => '',
            ]);

            $config->set('view.paths', [
                ...$config->get('view.paths'),
                __DIR__ . '/../resources/views',
            ]);

            // Configure Spatie Laravel Settings
            $config->set('settings.default_repository', 'database');
            $config->set('settings.repositories', [
                'database' => [
                    'type' => \Spatie\LaravelSettings\SettingsRepositories\DatabaseSettingsRepository::class,
                    'model' => null,
                    'table' => 'settings',
                    'connection' => null,
                ],
            ]);
            $config->set('settings.migrations_path', __DIR__ . '/../../database/settings');
            $config->set('settings.settings', [
                InvoiceSettings::class,
            ]);
            $config->set('settings.global_middleware', []);
        });
    }

    protected function setUp(): void
    {
        parent::setUp();

        // Run settings migration
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

        // Create settings table if not exists
        if (! \Illuminate\Support\Facades\Schema::hasTable('settings')) {
            \Illuminate\Support\Facades\Schema::create('settings', function ($table) {
                $table->id();
                $table->string('group');
                $table->string('name');
                $table->boolean('locked')->default(false);
                $table->json('payload');
                $table->timestamps();
                $table->unique(['group', 'name']);
            });
        }

        // Seed default settings
        $this->seedDefaultSettings();
    }

    protected function seedDefaultSettings(): void
    {
        $defaults = [
            'company_name' => 'Test Company',
            'company_logo' => null,
            'company_address' => '123 Test Street',
            'company_phone' => '1234567890',
            'company_email' => 'test@example.com',
            'company_tax_id' => 'TAX123',
            'default_currency' => 'USD',
            'default_tax_rate' => 0.0,
            'default_payment_terms' => 30,
            'email_subject_template' => 'Invoice #{uuid} from {company_name}',
            'email_body_template' => 'Please find your invoice attached.',
            'email_cc' => null,
            'email_bcc' => null,
            'email_from_name' => 'Test Company',
            'email_from_email' => 'invoices@example.com',
            'default_template' => 'classic',
            'paper_size' => 'a4',
            'include_terms' => false,
            'terms_text' => '',
        ];

        foreach ($defaults as $name => $value) {
            \Illuminate\Support\Facades\DB::table('settings')->updateOrInsert(
                ['group' => 'invoices', 'name' => $name],
                ['payload' => json_encode($value), 'locked' => false, 'created_at' => now(), 'updated_at' => now()]
            );
        }
    }
}

<?php

namespace TomatoPHP\FilamentInvoices;

use Filament\Contracts\Plugin;
use Filament\Panel;
use TomatoPHP\FilamentInvoices\Filament\Resources\InvoiceResource;
use TomatoPHP\FilamentInvoices\Pages\InvoiceSettingsPage;

class FilamentInvoicesPlugin implements Plugin
{
    private bool $isActive = false;

    private bool $useSettingsHub = false;

    public function getId(): string
    {
        return 'filament-invoices';
    }

    public function register(Panel $panel): void
    {
        $panel->resources([
            InvoiceResource::class,
        ])->pages([
            InvoiceResource\Pages\InvoiceStatus::class,
            InvoiceSettingsPage::class,
        ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return new static;
    }

    public function useSettingsHub(bool $condition = true): static
    {
        $this->useSettingsHub = $condition;

        return $this;
    }

    public function isSettingsHubEnabled(): bool
    {
        return $this->useSettingsHub;
    }
}

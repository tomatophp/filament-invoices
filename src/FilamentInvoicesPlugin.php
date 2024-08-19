<?php

namespace TomatoPHP\FilamentInvoices;

use Filament\Contracts\Plugin;
use Filament\Panel;
use TomatoPHP\FilamentInvoices\Filament\Resources\InvoiceResource;


class FilamentInvoicesPlugin implements Plugin
{
    public function getId(): string
    {
        return 'filament-invoices';
    }

    public function register(Panel $panel): void
    {
        $panel->resources([
            InvoiceResource::class
        ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return new static();
    }
}

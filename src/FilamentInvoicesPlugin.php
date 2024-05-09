<?php

namespace TomatoPHP\FilamentInvoices;

use Filament\Contracts\Plugin;
use Filament\Panel;


class FilamentInvoicesPlugin implements Plugin
{
    public function getId(): string
    {
        return 'filament-invoices';
    }

    public function register(Panel $panel): void
    {
        //
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

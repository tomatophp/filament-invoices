<?php

namespace TomatoPHP\FilamentInvoices;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Nwidart\Modules\Module;
use TomatoPHP\FilamentInvoices\Filament\Resources\InvoiceResource;


class FilamentInvoicesPlugin implements Plugin
{
    private bool $isActive = false;

    public function getId(): string
    {
        return 'filament-invoices';
    }

    public function register(Panel $panel): void
    {
        if(class_exists(Module::class) && \Nwidart\Modules\Facades\Module::find('FilamentInvoices')?->isEnabled()){
            $this->isActive = true;
        }
        else {
            $this->isActive = true;
        }

        if($this->isActive) {

            $panel->resources([
                InvoiceResource::class
            ])->pages([
                InvoiceResource\Pages\InvoiceStatus::class
            ]);
        }
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

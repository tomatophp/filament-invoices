<?php

use Filament\Facades\Filament;
use TomatoPHP\FilamentInvoices\FilamentInvoicesPlugin;

it('registers plugin', function () {
    $panel = Filament::getCurrentOrDefaultPanel();

    $panel->plugins([
        FilamentInvoicesPlugin::make(),
    ]);

    expect($panel->getPlugin('filament-invoices'))
        ->not()
        ->toThrow(Exception::class);
});

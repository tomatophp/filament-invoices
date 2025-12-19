<?php

use Filament\Facades\Filament;

it('registers plugin', function () {
    $panel = Filament::getCurrentOrDefaultPanel();

    $panel->plugins([
        \TomatoPHP\FilamentInvoices\FilamentInvoicesPlugin::make(),
    ]);

    expect($panel->getPlugin('filament-invoices'))
        ->not()
        ->toThrow(Exception::class);
});

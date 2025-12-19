<?php

namespace TomatoPHP\FilamentInvoices\Services\Templates;

class ClassicTemplate extends AbstractTemplate
{
    public function getName(): string
    {
        return 'classic';
    }

    public function getLabel(): string
    {
        return trans('filament-invoices::messages.templates.classic');
    }

    public function getDescription(): string
    {
        return 'A traditional, clean invoice layout with a formal appearance.';
    }

    public function getViewPath(): string
    {
        return 'filament-invoices::templates.classic';
    }
}

<?php

namespace TomatoPHP\FilamentInvoices\Services\Templates;

class ModernTemplate extends AbstractTemplate
{
    public function getName(): string
    {
        return 'modern';
    }

    public function getLabel(): string
    {
        return trans('filament-invoices::messages.templates.modern');
    }

    public function getDescription(): string
    {
        return 'A sleek, contemporary design with bold accents and modern typography.';
    }

    public function getViewPath(): string
    {
        return 'filament-invoices::templates.modern';
    }
}

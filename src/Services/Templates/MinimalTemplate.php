<?php

namespace TomatoPHP\FilamentInvoices\Services\Templates;

class MinimalTemplate extends AbstractTemplate
{
    public function getName(): string
    {
        return 'minimal';
    }

    public function getLabel(): string
    {
        return trans('filament-invoices::messages.templates.minimal');
    }

    public function getDescription(): string
    {
        return 'A clean, minimalist design focusing on essential information.';
    }

    public function getViewPath(): string
    {
        return 'filament-invoices::templates.minimal';
    }
}

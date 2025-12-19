<?php

namespace TomatoPHP\FilamentInvoices\Services\Templates;

class CreativeTemplate extends AbstractTemplate
{
    public function getName(): string
    {
        return 'creative';
    }

    public function getLabel(): string
    {
        return trans('filament-invoices::messages.templates.creative');
    }

    public function getDescription(): string
    {
        return 'A unique, artistic design perfect for creative agencies and freelancers.';
    }

    public function getViewPath(): string
    {
        return 'filament-invoices::templates.creative';
    }
}

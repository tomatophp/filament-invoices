<?php

namespace TomatoPHP\FilamentInvoices\Contracts;

use Illuminate\Contracts\View\View;
use TomatoPHP\FilamentInvoices\Models\Invoice;

interface InvoiceTemplateInterface
{
    /**
     * Get the unique identifier for this template.
     */
    public function getName(): string;

    /**
     * Get the display label for this template.
     */
    public function getLabel(): string;

    /**
     * Get the description of this template.
     */
    public function getDescription(): string;

    /**
     * Get a thumbnail/preview image path for this template.
     */
    public function getThumbnail(): ?string;

    /**
     * Render the invoice using this template.
     */
    public function render(Invoice $invoice, array $options = []): View;

    /**
     * Get the view path for this template.
     */
    public function getViewPath(): string;
}

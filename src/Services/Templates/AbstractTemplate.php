<?php

namespace TomatoPHP\FilamentInvoices\Services\Templates;

use Illuminate\Contracts\View\View;
use TomatoPHP\FilamentInvoices\Contracts\InvoiceTemplateInterface;
use TomatoPHP\FilamentInvoices\Models\Invoice;
use TomatoPHP\FilamentInvoices\Settings\InvoiceSettings;

abstract class AbstractTemplate implements InvoiceTemplateInterface
{
    protected InvoiceSettings $settings;

    public function __construct()
    {
        $this->settings = app(InvoiceSettings::class);
    }

    public function getThumbnail(): ?string
    {
        return null;
    }

    public function render(Invoice $invoice, array $options = []): View
    {
        return view($this->getViewPath(), [
            'invoice' => $invoice,
            'settings' => $this->settings,
            'options' => $options,
            'template' => $this,
        ]);
    }

    /**
     * Get the formatted company logo URL.
     */
    protected function getCompanyLogoUrl(): ?string
    {
        if (empty($this->settings->company_logo)) {
            return null;
        }

        return asset('storage/' . $this->settings->company_logo);
    }

    /**
     * Get the paper size CSS values.
     *
     * @return array{width: string, height: string}
     */
    protected function getPaperDimensions(): array
    {
        return match ($this->settings->paper_size) {
            'letter' => ['width' => '8.5in', 'height' => '11in'],
            'legal' => ['width' => '8.5in', 'height' => '14in'],
            default => ['width' => '210mm', 'height' => '297mm'], // A4
        };
    }
}

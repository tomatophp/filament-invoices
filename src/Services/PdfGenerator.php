<?php

namespace TomatoPHP\FilamentInvoices\Services;

use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use TomatoPHP\FilamentInvoices\Models\Invoice;
use TomatoPHP\FilamentInvoices\Services\Templates\TemplateFactory;
use TomatoPHP\FilamentInvoices\Settings\InvoiceSettings;

class PdfGenerator
{
    protected InvoiceSettings $settings;

    public function __construct()
    {
        $this->settings = app(InvoiceSettings::class);
    }

    /**
     * Generate PDF content for an invoice.
     */
    public function generate(Invoice $invoice, ?string $templateName = null, array $options = []): string
    {
        $template = $this->getTemplate($templateName);
        $html = $template->render($invoice, $options)->render();

        $pdf = Pdf::loadHTML($html);
        $this->configurePdf($pdf);

        return $pdf->output();
    }

    /**
     * Stream PDF to browser (inline display).
     */
    public function stream(Invoice $invoice, ?string $templateName = null, array $options = []): SymfonyResponse
    {
        $template = $this->getTemplate($templateName);
        $html = $template->render($invoice, $options)->render();

        $pdf = Pdf::loadHTML($html);
        $this->configurePdf($pdf);

        $filename = $this->getFilename($invoice);

        return $pdf->stream($filename);
    }

    /**
     * Download PDF file.
     */
    public function download(Invoice $invoice, ?string $templateName = null, array $options = []): SymfonyResponse
    {
        $template = $this->getTemplate($templateName);
        $html = $template->render($invoice, $options)->render();

        $pdf = Pdf::loadHTML($html);
        $this->configurePdf($pdf);

        $filename = $this->getFilename($invoice);

        return $pdf->download($filename);
    }

    /**
     * Save PDF to a file path.
     */
    public function save(Invoice $invoice, string $path, ?string $templateName = null, array $options = []): void
    {
        $template = $this->getTemplate($templateName);
        $html = $template->render($invoice, $options)->render();

        $pdf = Pdf::loadHTML($html);
        $this->configurePdf($pdf);

        $pdf->save($path);
    }

    /**
     * Get the template instance.
     */
    protected function getTemplate(?string $templateName = null): \TomatoPHP\FilamentInvoices\Contracts\InvoiceTemplateInterface
    {
        $templateName = $templateName ?? $this->settings->default_template ?? 'classic';

        return TemplateFactory::make($templateName);
    }

    /**
     * Configure PDF settings.
     *
     * @param  \Barryvdh\DomPDF\PDF  $pdf
     */
    protected function configurePdf($pdf): void
    {
        $paperSize = $this->settings->paper_size ?? 'a4';

        $pdf->setPaper($paperSize, 'portrait');
        $pdf->setOption('isHtml5ParserEnabled', true);
        $pdf->setOption('isRemoteEnabled', true);
        $pdf->setOption('defaultFont', 'DejaVu Sans');
    }

    /**
     * Generate filename for the PDF.
     */
    protected function getFilename(Invoice $invoice): string
    {
        $companyName = $this->settings->company_name ?: 'Invoice';
        $companyName = preg_replace('/[^a-zA-Z0-9]/', '-', $companyName);

        return sprintf(
            '%s-Invoice-%s.pdf',
            $companyName,
            $invoice->uuid
        );
    }
}

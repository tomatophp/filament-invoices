<?php

namespace TomatoPHP\FilamentInvoices\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use TomatoPHP\FilamentInvoices\Models\Invoice;
use TomatoPHP\FilamentInvoices\Services\PdfGenerator;
use TomatoPHP\FilamentInvoices\Settings\InvoiceSettings;

class InvoiceMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    protected InvoiceSettings $settings;

    protected ?string $template;

    protected ?string $customSubject;

    protected ?string $customBody;

    /**
     * @var array<string>
     */
    protected array $ccAddresses = [];

    /**
     * @var array<string>
     */
    protected array $bccAddresses = [];

    public function __construct(
        public Invoice $invoice,
        ?string $template = null,
        ?string $cc = null,
        ?string $bcc = null,
        ?string $subject = null,
        ?string $body = null
    ) {
        $this->settings = app(InvoiceSettings::class);
        $this->template = $template ?? $this->settings->default_template ?? 'classic';
        $this->customSubject = $subject;
        $this->customBody = $body;

        // Handle CC addresses
        if ($cc) {
            $this->ccAddresses = array_filter(array_map('trim', explode(',', $cc)));
        } elseif ($this->settings->email_cc) {
            $this->ccAddresses = array_filter(array_map('trim', explode(',', $this->settings->email_cc)));
        }

        // Handle BCC addresses
        if ($bcc) {
            $this->bccAddresses = array_filter(array_map('trim', explode(',', $bcc)));
        } elseif ($this->settings->email_bcc) {
            $this->bccAddresses = array_filter(array_map('trim', explode(',', $this->settings->email_bcc)));
        }
    }

    public function envelope(): Envelope
    {
        $subjectTemplate = $this->customSubject ?? $this->settings->email_subject_template ?: 'Invoice #{uuid} from {company_name}';
        $subject = $this->parseTemplate($subjectTemplate);

        $from = new Address(
            $this->settings->email_from_email ?: config('mail.from.address'),
            $this->settings->email_from_name ?: config('mail.from.name')
        );

        return new Envelope(
            from: $from,
            subject: $subject,
            cc: $this->ccAddresses,
            bcc: $this->bccAddresses,
        );
    }

    public function content(): Content
    {
        $bodyTemplate = $this->customBody ?? $this->settings->email_body_template ?: $this->getDefaultBody();

        return new Content(
            view: 'filament-invoices::emails.invoice',
            with: [
                'invoice' => $this->invoice,
                'settings' => $this->settings,
                'body' => $this->parseTemplate($bodyTemplate),
            ],
        );
    }

    /**
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        $pdfGenerator = app(PdfGenerator::class);
        $pdfContent = $pdfGenerator->generate($this->invoice, $this->template);

        $companyName = $this->settings->company_name ?: 'Invoice';
        $companyName = preg_replace('/[^a-zA-Z0-9]/', '-', $companyName);
        $filename = sprintf('%s-Invoice-%s.pdf', $companyName, $this->invoice->uuid);

        return [
            Attachment::fromData(fn () => $pdfContent, $filename)
                ->withMime('application/pdf'),
        ];
    }

    protected function parseTemplate(string $template): string
    {
        $replacements = [
            '{uuid}' => $this->invoice->uuid,
            '{company_name}' => $this->settings->company_name ?: 'Your Company',
            '{customer_name}' => $this->invoice->name,
            '{total}' => number_format($this->invoice->total, 2),
            '{currency}' => $this->invoice->currency?->iso ?? $this->settings->default_currency ?? 'USD',
            '{due_date}' => $this->invoice->due_date?->format('M d, Y') ?? 'N/A',
        ];

        return str_replace(array_keys($replacements), array_values($replacements), $template);
    }

    protected function getDefaultBody(): string
    {
        return "Dear {customer_name},\n\nPlease find attached invoice #{uuid} for your reference.\n\nTotal Amount: {total} {currency}\nDue Date: {due_date}\n\nThank you for your business.\n\nBest regards,\n{company_name}";
    }
}

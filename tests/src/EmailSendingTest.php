<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use TomatoPHP\FilamentInvoices\Mail\InvoiceMail;
use TomatoPHP\FilamentInvoices\Models\Invoice;
use TomatoPHP\FilamentInvoices\Services\Templates\ClassicTemplate;
use TomatoPHP\FilamentInvoices\Services\Templates\CreativeTemplate;
use TomatoPHP\FilamentInvoices\Services\Templates\MinimalTemplate;
use TomatoPHP\FilamentInvoices\Services\Templates\ModernTemplate;
use TomatoPHP\FilamentInvoices\Services\Templates\ProfessionalTemplate;
use TomatoPHP\FilamentInvoices\Services\Templates\TemplateFactory;

uses(RefreshDatabase::class);

beforeEach(function () {
    TemplateFactory::clear();
    TemplateFactory::register('classic', ClassicTemplate::class);
    TemplateFactory::register('modern', ModernTemplate::class);
    TemplateFactory::register('minimal', MinimalTemplate::class);
    TemplateFactory::register('professional', ProfessionalTemplate::class);
    TemplateFactory::register('creative', CreativeTemplate::class);
});

it('can create invoice mail instance', function () {
    $invoice = Invoice::factory()->create([
        'uuid' => 'TEST-001',
        'name' => 'Test Customer',
        'total' => 100.00,
    ]);

    $mail = new InvoiceMail($invoice);

    expect($mail)->toBeInstanceOf(InvoiceMail::class);
});

it('sends invoice email', function () {
    Mail::fake();

    $invoice = Invoice::factory()->create([
        'uuid' => 'TEST-001',
        'name' => 'Test Customer',
        'total' => 100.00,
    ]);

    Mail::to('test@example.com')->send(new InvoiceMail($invoice));

    Mail::assertSent(InvoiceMail::class, function ($mail) use ($invoice) {
        return $mail->invoice->id === $invoice->id;
    });
});

it('sends email to specified recipient', function () {
    Mail::fake();

    $invoice = Invoice::factory()->create([
        'uuid' => 'TEST-001',
        'name' => 'Test Customer',
    ]);

    Mail::to('recipient@example.com')->send(new InvoiceMail($invoice));

    Mail::assertSent(InvoiceMail::class, function ($mail) {
        return $mail->hasTo('recipient@example.com');
    });
});

it('includes pdf attachment', function () {
    $invoice = Invoice::factory()->create([
        'uuid' => 'TEST-001',
        'name' => 'Test Customer',
        'total' => 100.00,
    ]);

    $mail = new InvoiceMail($invoice);
    $attachments = $mail->attachments();

    expect($attachments)->toHaveCount(1);
});

it('uses custom subject when provided', function () {
    $invoice = Invoice::factory()->create([
        'uuid' => 'TEST-001',
        'name' => 'Test Customer',
    ]);

    $mail = new InvoiceMail(
        invoice: $invoice,
        subject: 'Custom Subject for {uuid}'
    );

    $envelope = $mail->envelope();

    expect($envelope->subject)->toContain('TEST-001');
});

it('uses custom body when provided', function () {
    $invoice = Invoice::factory()->create([
        'uuid' => 'TEST-001',
        'name' => 'Test Customer',
    ]);

    $mail = new InvoiceMail(
        invoice: $invoice,
        body: 'Custom body for {customer_name}'
    );

    $content = $mail->content();

    expect($content->with['body'])->toContain('Test Customer');
});

it('handles cc addresses', function () {
    Mail::fake();

    $invoice = Invoice::factory()->create([
        'uuid' => 'TEST-001',
        'name' => 'Test Customer',
    ]);

    Mail::to('recipient@example.com')
        ->send(new InvoiceMail(
            invoice: $invoice,
            cc: 'cc@example.com'
        ));

    Mail::assertSent(InvoiceMail::class);
});

it('handles bcc addresses', function () {
    Mail::fake();

    $invoice = Invoice::factory()->create([
        'uuid' => 'TEST-001',
        'name' => 'Test Customer',
    ]);

    Mail::to('recipient@example.com')
        ->send(new InvoiceMail(
            invoice: $invoice,
            bcc: 'bcc@example.com'
        ));

    Mail::assertSent(InvoiceMail::class);
});

it('sends email with different templates', function (string $template) {
    Mail::fake();

    $invoice = Invoice::factory()->create([
        'uuid' => 'TEST-001',
        'name' => 'Test Customer',
    ]);

    Mail::to('recipient@example.com')
        ->send(new InvoiceMail(
            invoice: $invoice,
            template: $template
        ));

    Mail::assertSent(InvoiceMail::class);
})->with(['classic', 'modern', 'minimal', 'professional', 'creative']);

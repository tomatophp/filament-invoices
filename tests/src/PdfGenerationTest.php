<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use TomatoPHP\FilamentInvoices\Models\Invoice;
use TomatoPHP\FilamentInvoices\Services\PdfGenerator;
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

it('can instantiate pdf generator', function () {
    $generator = app(PdfGenerator::class);

    expect($generator)->toBeInstanceOf(PdfGenerator::class);
});

it('can generate pdf content', function () {
    $invoice = Invoice::factory()->create([
        'uuid' => 'TEST-001',
        'name' => 'Test Customer',
        'total' => 100.00,
    ]);

    $generator = app(PdfGenerator::class);
    $content = $generator->generate($invoice);

    expect($content)->toBeString()
        ->and(strlen($content))->toBeGreaterThan(0);
});

it('generates pdf with different templates', function (string $template) {
    $invoice = Invoice::factory()->create([
        'uuid' => 'TEST-001',
        'name' => 'Test Customer',
        'total' => 100.00,
    ]);

    $generator = app(PdfGenerator::class);
    $content = $generator->generate($invoice, $template);

    expect($content)->toBeString()
        ->and(strlen($content))->toBeGreaterThan(0);
})->with(['classic', 'modern', 'minimal', 'professional', 'creative']);

it('returns stream response', function () {
    $invoice = Invoice::factory()->create([
        'uuid' => 'TEST-001',
        'name' => 'Test Customer',
        'total' => 100.00,
    ]);

    $generator = app(PdfGenerator::class);
    $response = $generator->stream($invoice);

    expect($response->headers->get('Content-Type'))->toContain('application/pdf');
});

it('returns download response', function () {
    $invoice = Invoice::factory()->create([
        'uuid' => 'TEST-001',
        'name' => 'Test Customer',
        'total' => 100.00,
    ]);

    $generator = app(PdfGenerator::class);
    $response = $generator->download($invoice);

    expect($response->headers->get('Content-Disposition'))->toContain('attachment');
});

it('generates valid pdf header', function () {
    $invoice = Invoice::factory()->create([
        'uuid' => 'TEST-001',
        'name' => 'Test Customer',
        'total' => 100.00,
    ]);

    $generator = app(PdfGenerator::class);
    $content = $generator->generate($invoice);

    // PDF files start with %PDF
    expect(substr($content, 0, 4))->toBe('%PDF');
});

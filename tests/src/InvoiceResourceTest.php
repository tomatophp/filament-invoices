<?php

use Illuminate\Support\Facades\Mail;
use TomatoPHP\FilamentInvoices\Facades\FilamentInvoices;
use TomatoPHP\FilamentInvoices\Filament\Resources\InvoiceResource;
use TomatoPHP\FilamentInvoices\Filament\Resources\InvoiceResource\Pages\CreateInvoice;
use TomatoPHP\FilamentInvoices\Filament\Resources\InvoiceResource\Pages\InvoiceStatus;
use TomatoPHP\FilamentInvoices\Filament\Resources\InvoiceResource\Pages\ListInvoices;
use TomatoPHP\FilamentInvoices\Filament\Resources\InvoiceResource\Pages\ViewInvoice;
use TomatoPHP\FilamentInvoices\Filament\Resources\InvoiceResource\Widgets\InvoiceStatsWidget;
use TomatoPHP\FilamentInvoices\Mail\InvoiceMail;
use TomatoPHP\FilamentInvoices\Models\Invoice;
use TomatoPHP\FilamentInvoices\Pages\InvoiceSettingsPage;
use TomatoPHP\FilamentInvoices\Services\Contracts\InvoiceFor;
use TomatoPHP\FilamentInvoices\Services\Contracts\InvoiceFrom;
use TomatoPHP\FilamentInvoices\Settings\InvoiceSettings;
use TomatoPHP\FilamentInvoices\Tests\Models\User;
use TomatoPHP\FilamentLocations\Models\Currency;
use TomatoPHP\FilamentTypes\Models\Type;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\artisan;
use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

beforeEach(function () {
    actingAs($this->user = User::factory()->create());

    FilamentInvoices::registerFrom([InvoiceFrom::make(User::class)->label('Users')]);
    FilamentInvoices::registerFor([InvoiceFor::make(User::class)->label('Users')]);
    FilamentInvoices::loadTypes();

    $this->usd = Currency::query()->where('iso', 'USD')->value('id');

    $this->invoice = Invoice::factory()->create([
        'user_id' => $this->user->id,
        'for_type' => User::class,
        'for_id' => $this->user->id,
        'from_type' => User::class,
        'from_id' => $this->user->id,
        'currency_id' => $this->usd,
        'status' => 'draft',
        'total' => 500,
        'paid' => 0,
    ]);
});

it('renders every invoice page', function () {
    get(InvoiceResource::getUrl('index'))->assertSuccessful();
    get(InvoiceResource::getUrl('create'))->assertSuccessful();
    get(InvoiceResource::getUrl('edit', ['record' => $this->invoice]))->assertSuccessful();
    get(InvoiceResource::getUrl('view', ['record' => $this->invoice]))->assertSuccessful();
    get(InvoiceStatus::getUrl())->assertSuccessful();
    get(InvoiceSettingsPage::getUrl())->assertSuccessful();
});

it('lists the invoices with the stats widget', function () {
    livewire(ListInvoices::class)
        ->assertSuccessful()
        ->assertCanSeeTableRecords([$this->invoice]);

    livewire(InvoiceStatsWidget::class)->assertSuccessful();
});

it('creates an invoice with its items and totals', function () {
    livewire(CreateInvoice::class)
        ->fillForm([
            'uuid' => 'INV-TEST-1',
            'from_type' => User::class,
            'from_id' => $this->user->id,
            'for_type' => User::class,
            'for_id' => $this->user->id,
            'type' => 'sale',
            'status' => 'draft',
            'currency_id' => $this->usd,
            'items' => [
                ['item' => 'Design', 'description' => 'Logo', 'qty' => 2, 'price' => 100, 'discount' => 0, 'vat' => 0, 'total' => 200],
                ['item' => 'Hosting', 'description' => 'One year', 'qty' => 1, 'price' => 50, 'discount' => 0, 'vat' => 0, 'total' => 50],
            ],
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $invoice = Invoice::query()->where('uuid', 'INV-TEST-1')->firstOrFail();

    expect($invoice->invoicesItems)->toHaveCount(2)
        ->and((float) $invoice->total)->toBe(250.0)
        ->and($invoice->user_id)->toBe($this->user->id)
        ->and($invoice->invoiceLogs()->where('type', 'created')->exists())->toBeTrue();
});

it('records a payment', function () {
    livewire(ListInvoices::class)
        ->callTableAction('pay', $this->invoice, data: ['amount' => 200])
        ->assertHasNoTableActionErrors();

    $invoice = $this->invoice->refresh();

    expect((float) $invoice->paid)->toBe(200.0)
        ->and($invoice->invoiceMetas()->where('key', 'payments')->count())->toBe(1)
        ->and($invoice->invoiceLogs()->where('type', 'payment')->exists())->toBeTrue();
});

it('records a payment on an invoice without a currency', function () {
    $this->invoice->update(['currency_id' => null]);

    livewire(ListInvoices::class)
        ->callTableAction('pay', $this->invoice, data: ['amount' => 100])
        ->assertHasNoTableActionErrors();

    expect((float) $this->invoice->refresh()->paid)->toBe(100.0);
});

it('emails the invoice from the view page', function () {
    Mail::fake();

    livewire(ViewInvoice::class, ['record' => $this->invoice->getRouteKey()])
        ->callAction('send_email', data: [
            'recipient_email' => 'client@example.com',
            'template' => 'classic',
        ])
        ->assertHasNoActionErrors();

    Mail::assertSent(InvoiceMail::class, fn (InvoiceMail $mail): bool => $mail->hasTo('client@example.com'));
});

it('lists the invoice statuses and types', function () {
    livewire(InvoiceStatus::class)
        ->assertSuccessful()
        ->assertCanSeeTableRecords(Type::query()->where('for', 'invoices')->get());
});

it('saves the invoice settings', function () {
    livewire(InvoiceSettingsPage::class)
        ->fillForm(['company_name' => 'Tomato Inc'])
        ->call('save')
        ->assertHasNoFormErrors();

    $settings = app(InvoiceSettings::class);
    $settings->refresh();

    expect($settings->company_name)->toBe('Tomato Inc');
});

it('installs the invoice types', function () {
    Type::query()->where('for', 'invoices')->delete();

    artisan('filament-invoices:install')
        ->expectsOutputToContain('Filament Invoices installed successfully.')
        ->assertSuccessful();

    expect(Type::query()->where('for', 'invoices')->count())->toBe(8);
});

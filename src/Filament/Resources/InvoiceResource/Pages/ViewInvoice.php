<?php

namespace TomatoPHP\FilamentInvoices\Filament\Resources\InvoiceResource\Pages;

use Filament\Actions;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Mail;
use TomatoPHP\FilamentInvoices\Filament\Resources\InvoiceResource;
use TomatoPHP\FilamentInvoices\Mail\InvoiceMail;
use TomatoPHP\FilamentInvoices\Models\InvoiceLog;
use TomatoPHP\FilamentInvoices\Services\PdfGenerator;
use TomatoPHP\FilamentInvoices\Services\Templates\TemplateFactory;
use TomatoPHP\FilamentInvoices\Settings\InvoiceSettings;

class ViewInvoice extends ViewRecord
{
    protected static string $resource = InvoiceResource::class;

    protected string $view = 'filament-invoices::pages.view-invoice';

    protected function getHeaderActions(): array
    {
        $settings = app(InvoiceSettings::class);

        return [
            Actions\EditAction::make()->icon('heroicon-o-pencil'),
            Actions\DeleteAction::make()->icon('heroicon-o-trash'),
            Actions\Action::make('print')
                ->label(trans('filament-invoices::messages.invoices.actions.print'))
                ->icon('heroicon-o-printer')
                ->color('info')
                ->action(function () {
                    $this->js('window.print()');
                }),
            Actions\Action::make('export_pdf')
                ->label(trans('filament-invoices::messages.invoices.actions.export_pdf.label'))
                ->icon('heroicon-o-document-arrow-down')
                ->color('success')
                ->form([
                    Select::make('template')
                        ->label(trans('filament-invoices::messages.invoices.actions.export_pdf.template'))
                        ->options(TemplateFactory::getOptions())
                        ->default($settings->default_template ?? 'classic')
                        ->required(),
                ])
                ->action(function (array $data) use ($settings) {
                    $pdfGenerator = app(PdfGenerator::class);
                    $invoice = $this->getRecord();
                    $pdfContent = $pdfGenerator->generate($invoice, $data['template']);

                    $companyName = $settings->company_name ?: 'Invoice';
                    $companyName = preg_replace('/[^a-zA-Z0-9]/', '-', $companyName);
                    $filename = sprintf('%s-Invoice-%s.pdf', $companyName, $invoice->uuid);

                    return response()->streamDownload(
                        fn () => print ($pdfContent),
                        $filename,
                        ['Content-Type' => 'application/pdf']
                    );
                }),
            Actions\Action::make('send_email')
                ->label(trans('filament-invoices::messages.invoices.actions.send_email.label'))
                ->icon('heroicon-o-envelope')
                ->color('warning')
                ->form([
                    TextInput::make('recipient_email')
                        ->label(trans('filament-invoices::messages.invoices.actions.send_email.to'))
                        ->email()
                        ->required()
                        ->default(fn () => $this->getRecord()->for?->email ?? ''),
                    TextInput::make('subject')
                        ->label(trans('filament-invoices::messages.invoices.actions.send_email.subject'))
                        ->default($settings->email_subject_template ?? 'Invoice #{uuid} from {company_name}')
                        ->helperText(trans('filament-invoices::messages.settings.fields.email_placeholders')),
                    \Filament\Forms\Components\Textarea::make('body')
                        ->label(trans('filament-invoices::messages.invoices.actions.send_email.body'))
                        ->default($settings->email_body_template ?? '')
                        ->rows(5)
                        ->helperText(trans('filament-invoices::messages.settings.fields.email_placeholders')),
                    Select::make('template')
                        ->label(trans('filament-invoices::messages.invoices.actions.send_email.template'))
                        ->options(TemplateFactory::getOptions())
                        ->default($settings->default_template ?? 'classic')
                        ->required(),
                    TextInput::make('cc_email')
                        ->label(trans('filament-invoices::messages.invoices.actions.send_email.cc'))
                        ->email()
                        ->default($settings->email_cc ?? ''),
                    TextInput::make('bcc_email')
                        ->label(trans('filament-invoices::messages.invoices.actions.send_email.bcc'))
                        ->email()
                        ->default($settings->email_bcc ?? ''),
                ])
                ->action(function (array $data) {
                    try {
                        $invoice = $this->getRecord();

                        Mail::to($data['recipient_email'])
                            ->send(new InvoiceMail(
                                invoice: $invoice,
                                template: $data['template'],
                                cc: $data['cc_email'] ?? null,
                                bcc: $data['bcc_email'] ?? null,
                                subject: $data['subject'] ?? null,
                                body: $data['body'] ?? null
                            ));

                        // Log the email send
                        if (class_exists(InvoiceLog::class)) {
                            InvoiceLog::create([
                                'invoice_id' => $invoice->id,
                                'log' => "Invoice emailed to {$data['recipient_email']}",
                                'type' => 'email',
                            ]);
                        }

                        Notification::make()
                            ->title(trans('filament-invoices::messages.invoices.actions.email_sent.title'))
                            ->body(trans('filament-invoices::messages.invoices.actions.email_sent.body'))
                            ->success()
                            ->send();
                    } catch (\Exception $e) {
                        Notification::make()
                            ->title(trans('filament-invoices::messages.invoices.actions.email_failed.title'))
                            ->body($e->getMessage())
                            ->danger()
                            ->send();
                    }
                }),
        ];
    }
}

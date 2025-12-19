<?php

namespace TomatoPHP\FilamentInvoices\Filament\Resources\InvoiceResource\RelationManagers;

use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use TomatoPHP\FilamentInvoices\Settings\InvoiceSettings;

class InvoicePaymentsManager extends RelationManager
{
    protected static string $relationship = 'invoiceMetas';

    protected static ?string $title = 'Payments';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return trans('filament-invoices::messages.invoices.payments.title');
    }

    public static function getLabel(): ?string
    {
        return trans('filament-invoices::messages.invoices.payments.title');
    }

    public static function getModelLabel(): ?string
    {
        return trans('filament-invoices::messages.invoices.payments.single');
    }

    public function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->modifyQueryUsing(function (Builder $query) {
                $query->where('key', 'payments');
            })
            ->columns([
                Tables\Columns\TextColumn::make('value')
                    ->label(trans('filament-invoices::messages.invoices.payments.columns.amount'))
                    ->money(locale: 'en')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(trans('filament-invoices::messages.invoices.payments.columns.created_at'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                Actions\Action::make('print_pay_slip')
                    ->iconButton()
                    ->icon('heroicon-o-printer')
                    ->color('success')
                    ->label(trans('filament-invoices::messages.invoices.actions.print_pay_slip.label'))
                    ->tooltip(trans('filament-invoices::messages.invoices.actions.print_pay_slip.label'))
                    ->action(function ($record) {
                        $invoice = $this->getOwnerRecord();
                        $settings = app(InvoiceSettings::class);

                        $html = view('filament-invoices::templates.pay-slip', [
                            'invoice' => $invoice,
                            'payment' => $record,
                            'settings' => $settings,
                        ])->render();

                        $pdf = Pdf::loadHTML($html);
                        $pdf->setPaper('a5', 'portrait');

                        $filename = sprintf('PaySlip-%s-%s.pdf', $invoice->uuid, $record->id);

                        return response()->streamDownload(
                            fn () => print ($pdf->output()),
                            $filename,
                            ['Content-Type' => 'application/pdf']
                        );
                    }),
                Actions\EditAction::make(),
            ])
            ->toolbarActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }
}

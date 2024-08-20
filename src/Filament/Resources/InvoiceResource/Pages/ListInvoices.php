<?php

namespace TomatoPHP\FilamentInvoices\Filament\Resources\InvoiceResource\Pages;

use TomatoPHP\FilamentInvoices\Facades\FilamentInvoices;
use TomatoPHP\FilamentInvoices\Filament\Resources\InvoiceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use TomatoPHP\FilamentTypes\Models\Type;

class ListInvoices extends ListRecords
{
    protected static string $resource = InvoiceResource::class;


    public function mount(): void
    {
        parent::mount();

        FilamentInvoices::loadTypes();
    }

    protected function getHeaderWidgets(): array
    {
        return [
            InvoiceResource\Widgets\InvoiceStatsWidget::class
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('setting')
                ->hiddenLabel()
                ->tooltip(trans('filament-invoices::messages.invoices.actions.invoices_status'))
                ->icon('heroicon-o-cog')
                ->color('info')
                ->action(function (){
                    return redirect()->to(InvoiceStatus::getUrl());
                })
                ->label(trans('filament-invoices::messages.invoices.actions.invoices_status')),
        ];
    }
}

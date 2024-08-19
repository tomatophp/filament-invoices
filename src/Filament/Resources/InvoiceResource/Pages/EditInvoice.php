<?php

namespace TomatoPHP\FilamentInvoices\Filament\Resources\InvoiceResource\Pages;

use TomatoPHP\FilamentInvoices\Filament\Resources\InvoiceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInvoice extends EditRecord
{
    protected static string $resource = InvoiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()->icon('heroicon-o-trash'),
            Actions\ViewAction::make()->icon('heroicon-o-eye'),
        ];
    }

    public function afterSave()
    {
        $data = [];
        $data['discount'] = collect($this->getRecord()->invoicesItems)->sum(function ($item) {
            return $item->discount * $item->qty;
        });
        $data['vat'] = collect($this->getRecord()->invoicesItems)->sum(function ($item) {
            return $item->vat * $item->qty;
        });
        $data['total'] = collect($this->getRecord()->invoicesItems)->sum('total');

        $this->getRecord()->update($data);

        $this->getRecord()->invoiceLogs()->create([
            'log' => "Invoice Updated By: " . auth()->user()->name,
            'type' => 'updated'
        ]);
    }
}

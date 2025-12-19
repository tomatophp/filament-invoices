<?php

namespace TomatoPHP\FilamentInvoices\Filament\Resources\InvoiceResource\RelationManagers;

use Filament\Actions;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class InvoiceLogManager extends RelationManager
{
    protected static string $relationship = 'invoiceLogs';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return trans('filament-invoices::messages.invoices.logs.title');
    }

    public static function getLabel(): ?string
    {
        return trans('filament-invoices::messages.invoices.logs.title');
    }

    public static function getModelLabel(): ?string
    {
        return trans('filament-invoices::messages.invoices.logs.single');
    }

    public static function getPluralLabel(): ?string
    {
        return trans('filament-invoices::messages.invoices.logs.title');
    }

    public function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('log')
                    ->label(trans('filament-invoices::messages.invoices.logs.columns.log'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->label(trans('filament-invoices::messages.invoices.logs.columns.type'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(trans('filament-invoices::messages.invoices.logs.columns.created_at'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
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

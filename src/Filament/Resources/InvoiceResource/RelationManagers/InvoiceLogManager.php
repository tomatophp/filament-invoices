<?php

namespace TomatoPHP\FilamentInvoices\Filament\Resources\InvoiceResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InvoiceLogManager extends RelationManager
{
    protected static string $relationship = 'invoiceLogs';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return trans('filament-invoices::messages.invoices.logs.title');
    }

    /**
     * @return string|null
     */
    public static function getLabel(): ?string
    {
        return trans('filament-invoices::messages.invoices.logs.title');
    }

    /**
     * @return string|null
     */
    public static function getModelLabel(): ?string
    {
        return trans('filament-invoices::messages.invoices.logs.single');
    }

    /**
     * @return string|null
     */
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
                    ->sortable()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInvoiceLogs::route('/'),
            'create' => Pages\CreateInvoiceLog::route('/create'),
            'edit' => Pages\EditInvoiceLog::route('/{record}/edit'),
        ];
    }
}

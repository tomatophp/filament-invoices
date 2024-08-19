<?php

namespace TomatoPHP\FilamentInvoices\Filament\Resources;

use TomatoPHP\FilamentInvoices\Filament\Resources\InvoiceResource\Pages;
use TomatoPHP\FilamentInvoices\Filament\Resources\InvoiceResource\RelationManagers;
use TomatoPHP\FilamentInvoices\Models\Invoice;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('uuid')
                    ->label('UUID')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('for_type')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('for_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('from_type')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('from_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('branch_id')
                    ->numeric(),
                Forms\Components\TextInput::make('category_id')
                    ->numeric(),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->maxLength(255),
                Forms\Components\TextInput::make('address')
                    ->maxLength(255),
                Forms\Components\TextInput::make('type')
                    ->maxLength(255)
                    ->default('push'),
                Forms\Components\TextInput::make('status')
                    ->maxLength(255)
                    ->default('pending'),
                Forms\Components\TextInput::make('total')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('discount')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('shipping')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('vat')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('paid')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\DatePicker::make('date'),
                Forms\Components\DatePicker::make('due_date'),
                Forms\Components\Toggle::make('is_activated'),
                Forms\Components\Toggle::make('is_offer'),
                Forms\Components\Toggle::make('insert_in_to_inventory'),
                Forms\Components\Toggle::make('send_email'),
                Forms\Components\TextInput::make('currency_id')
                    ->numeric(),
                Forms\Components\Toggle::make('is_bank_transfer'),
                Forms\Components\TextInput::make('bank_account')
                    ->maxLength(255),
                Forms\Components\TextInput::make('bank_account_owner')
                    ->maxLength(255),
                Forms\Components\TextInput::make('bank_iban')
                    ->maxLength(255),
                Forms\Components\TextInput::make('bank_swift')
                    ->maxLength(255),
                Forms\Components\TextInput::make('bank_address')
                    ->maxLength(255),
                Forms\Components\TextInput::make('bank_branch')
                    ->maxLength(255),
                Forms\Components\TextInput::make('bank_name')
                    ->maxLength(255),
                Forms\Components\TextInput::make('bank_city')
                    ->maxLength(255),
                Forms\Components\TextInput::make('bank_country')
                    ->maxLength(255),
                Forms\Components\Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('uuid')
                    ->label('UUID')
                    ->searchable(),
                Tables\Columns\TextColumn::make('for_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('for_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('from_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('from_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('branch_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('total')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('discount')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('shipping')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('vat')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('paid')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('due_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_activated')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_offer')
                    ->boolean(),
                Tables\Columns\IconColumn::make('insert_in_to_inventory')
                    ->boolean(),
                Tables\Columns\IconColumn::make('send_email')
                    ->boolean(),
                Tables\Columns\TextColumn::make('currency_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_bank_transfer')
                    ->boolean(),
                Tables\Columns\TextColumn::make('bank_account')
                    ->searchable(),
                Tables\Columns\TextColumn::make('bank_account_owner')
                    ->searchable(),
                Tables\Columns\TextColumn::make('bank_iban')
                    ->searchable(),
                Tables\Columns\TextColumn::make('bank_swift')
                    ->searchable(),
                Tables\Columns\TextColumn::make('bank_address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('bank_branch')
                    ->searchable(),
                Tables\Columns\TextColumn::make('bank_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('bank_city')
                    ->searchable(),
                Tables\Columns\TextColumn::make('bank_country')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
}

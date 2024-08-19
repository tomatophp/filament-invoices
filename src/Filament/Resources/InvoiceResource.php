<?php

namespace TomatoPHP\FilamentInvoices\Filament\Resources;

use App\Models\User;
use Carbon\Carbon;
use Filament\Notifications\Notification;
use Filament\Tables\Enums\ActionsPosition;
use Illuminate\Support\Collection;
use TomatoPHP\FilamentAccounts\Components\AccountColumn;
use TomatoPHP\FilamentAccounts\Models\Account;
use TomatoPHP\FilamentEcommerce\Facades\FilamentEcommerce;
use TomatoPHP\FilamentEcommerce\Models\Branch;
use TomatoPHP\FilamentEcommerce\Models\Company;
use TomatoPHP\FilamentEcommerce\Models\Coupon;
use TomatoPHP\FilamentEcommerce\Models\Product;
use TomatoPHP\FilamentInvoices\Facades\FilamentInvoices;
use TomatoPHP\FilamentInvoices\Filament\Resources\InvoiceResource\Pages;
use TomatoPHP\FilamentInvoices\Filament\Resources\InvoiceResource\RelationManagers;
use TomatoPHP\FilamentInvoices\Filament\Resources\InvoiceResource\Widgets\InvoiceStatsWidget;
use TomatoPHP\FilamentInvoices\Models\Invoice;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use TomatoPHP\FilamentLocations\Models\City;
use TomatoPHP\FilamentLocations\Models\Country;
use TomatoPHP\FilamentLocations\Models\Currency;
use TomatoPHP\FilamentTypes\Components\TypeColumn;
use TomatoPHP\FilamentTypes\Models\Type;

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';


    public static function getWidgets(): array
    {
        return [
            InvoiceStatsWidget::class
        ];
    }

    public static function form(Form $form): Form
    {
        $types = Type::query()
            ->where('for', 'invoices')
            ->where('type', 'type');

        $statues = Type::query()
            ->where('for', 'invoices')
            ->where('type', 'status');

        return $form
            ->schema([
                Forms\Components\TextInput::make('uuid')
                    ->unique(ignoreRecord: true)
                    ->disabled(fn(Invoice $invoice)=> $invoice->exists)
                    ->label(trans('filament-ecommerce::messages.orders.columns.uuid'))
                    ->default(fn () => 'INV-'. \Illuminate\Support\Str::random(8))
                    ->required()
                    ->columnSpanFull()
                    ->maxLength(255),

                Forms\Components\Grid::make([
                    'sm' => 1,
                    'lg' => 12,
                ])->schema([
                    Forms\Components\Section::make("Billed From")
                        ->schema([
                            Forms\Components\Select::make('from_type')
                                ->required()
                                ->searchable()
                                ->live()
                                ->options(FilamentInvoices::getFrom()->pluck('label', 'model')->toArray())
                                ->columnSpanFull(),
                            Forms\Components\Select::make('from_id')
                                ->required()
                                ->searchable()
                                ->disabled(fn(Forms\Get $get) => !$get('from_type'))
                                ->options(fn(Forms\Get $get) => $get('from_type')? $get('from_type')::query()->pluck(FilamentInvoices::getFrom()->where('model', $get('from_type'))->first()?->column??'name', 'id')->toArray() : [])
                                ->columnSpanFull(),
                        ])
                        ->columns(2)
                        ->columnSpan(6)
                        ->collapsible()
                        ->collapsed(fn($record) => $record),
                    Forms\Components\Section::make("Billed To")
                        ->schema([
                            Forms\Components\Select::make('for_type')
                                ->searchable()
                                ->required()
                                ->live()
                                ->options(FilamentInvoices::getFor()->pluck('label', 'model')->toArray())
                                ->columnSpanFull(),
                            Forms\Components\Select::make('for_id')
                                ->required()
                                ->searchable()
                                ->live()
                                ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set){
                                    $forType = $get('for_type');
                                    $forId = $get('for_id');
                                    if($forType && $forId){
                                        $for = $forType::find($forId);
                                        $set('name', $for->name);
                                        $set('phone', $for->phone);
                                        $set('address', $for->address);
                                    }
                                })
                                ->disabled(fn(Forms\Get $get) => !$get('for_type'))
                                ->options(fn(Forms\Get $get) => $get('for_type') ? $get('for_type')::query()->pluck(FilamentInvoices::getFor()->where('model', $get('for_type'))->first()?->column??'name', 'id')->toArray() : [])
                                ->columnSpanFull(),
                        ])
                        ->columns(2)
                        ->columnSpan(6)
                        ->collapsible()
                        ->collapsed(fn($record) => $record),
                    Forms\Components\Section::make("Customer Data")
                        ->schema([
                            Forms\Components\TextInput::make('name'),
                            Forms\Components\TextInput::make('phone'),
                            Forms\Components\Textarea::make('address'),
                        ])
                        ->columns(1)
                        ->columnSpan(6)
                        ->collapsible()
                        ->collapsed(fn($record) => $record),
                    Forms\Components\Section::make("Invoice Data")
                        ->schema([
                            Forms\Components\DatePicker::make('date')
                                ->required()
                                ->default(Carbon::now()),
                            Forms\Components\DatePicker::make('due_date')
                                ->required()
                                ->default(Carbon::now()),
                            Forms\Components\Select::make('type')
                                ->required()
                                ->default('push')
                                ->searchable()
                                ->options($types->pluck('name', 'key')->toArray()),
                            Forms\Components\Select::make('status')
                                ->required()
                                ->default('draft')
                                ->searchable()
                                ->options($statues->pluck('name', 'key')->toArray()),
                            Forms\Components\Select::make('currency_id')
                                ->required()
                                ->columnSpanFull()
                                ->default(Currency::query()->where('iso', 'USD')->first()?->id)
                                ->searchable()
                                ->options(Currency::query()->pluck('name', 'id')->toArray()),
                        ])
                        ->columns(2)
                        ->columnSpan(6)
                        ->collapsible()
                        ->collapsed(fn($record) => $record),
                ]),
                Forms\Components\Repeater::make('items')
                    ->hiddenLabel()
                    ->collapsible()
                    ->collapsed(fn($record) => $record)
                    ->cloneable()
                    ->relationship('invoicesItems')
                    ->label(trans('filament-ecommerce::messages.orders.columns.items'))
                    ->itemLabel("Item")
                    ->schema([
                        Forms\Components\TextInput::make('item')
                            ->columnSpan(4),
                        Forms\Components\TextInput::make('description')
                            ->columnSpan(8),
                        Forms\Components\TextInput::make('qty')
                            ->live()
                            ->columnSpan(2)
                            ->label(trans('filament-ecommerce::messages.orders.columns.qty'))
                            ->default(1)
                            ->numeric(),
                        Forms\Components\TextInput::make('price')
                            ->label(trans('filament-ecommerce::messages.orders.columns.price'))
                            ->columnSpan(3)
                            ->default(0)
                            ->numeric(),
                        Forms\Components\TextInput::make('discount')
                            ->label(trans('filament-ecommerce::messages.orders.columns.discount'))
                            ->columnSpan(2)
                            ->default(0)
                            ->numeric(),
                        Forms\Components\TextInput::make('vat')
                            ->label(trans('filament-ecommerce::messages.orders.columns.vat'))
                            ->columnSpan(2)
                            ->default(0)
                            ->numeric(),
                        Forms\Components\TextInput::make('total')
                            ->label(trans('filament-ecommerce::messages.orders.columns.total'))
                            ->columnSpan(3)
                            ->default(0)
                            ->numeric(),
                    ])
                    ->lazy()
                    ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set) {
                        $items = $get('items');
                        $total = 0;
                        $discount = 0;
                        $vat = 0;
                        $collectItems = [];
                        foreach ($items as $invoiceItem){
                            $getTotal = ((($invoiceItem['price']+$invoiceItem['vat'])-$invoiceItem['discount'])*$invoiceItem['qty']);
                            $total += $getTotal;
                            $invoiceItem['total'] = $getTotal;
                            $discount += ($invoiceItem['discount']*$invoiceItem['qty']);
                            $vat +=  ($invoiceItem['vat']*$invoiceItem['qty']);

                            $collectItems[] = $invoiceItem;

                        }
                        $set('total', $total);
                        $set('discount', $discount);
                        $set('vat', $vat);

                        $set('items', $collectItems);
                    })
                    ->columns(12)
                    ->columnSpanFull(),
                Forms\Components\Section::make(trans('filament-ecommerce::messages.orders.sections.totals'))
                    ->schema([
                        Forms\Components\TextInput::make('shipping')
                            ->lazy()
                            ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set) {
                                $items = $get('items');
                                $total = 0;
                                foreach ($items as $invoiceItem){
                                    $total += ((($invoiceItem['price']+$invoiceItem['vat'])-$invoiceItem['discount'])*$invoiceItem['qty']);
                                }

                                $set('total', $total+(int)$get('shipping'));
                            })
                            ->label(trans('filament-ecommerce::messages.orders.columns.shipping'))
                            ->numeric()
                            ->default(0),
                        Forms\Components\TextInput::make('vat')
                            ->disabled()
                            ->label(trans('filament-ecommerce::messages.orders.columns.vat'))
                            ->numeric()
                            ->default(0),
                        Forms\Components\TextInput::make('discount')
                            ->disabled()
                            ->label(trans('filament-ecommerce::messages.orders.columns.discount'))
                            ->numeric()
                            ->default(0),
                        Forms\Components\TextInput::make('total')
                            ->disabled()
                            ->label(trans('filament-ecommerce::messages.orders.columns.total'))
                            ->numeric()
                            ->default(0),
                        Forms\Components\Textarea::make('notes')
                            ->label(trans('filament-ecommerce::messages.orders.columns.notes'))
                            ->columnSpanFull(),
                    ])->collapsible()->collapsed(fn($record) => $record),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('uuid')
                    ->label(trans('filament-ecommerce::messages.orders.columns.uuid'))
                    ->description(fn($record) => $record->type . ' by ' . $record->user?->name)
                    ->label('UUID')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('for_id')
                    ->state(fn($record) => $record->for_type::find($record->for_id)?->name)
                    ->description(fn($record) => 'From: '.$record->from_type::find($record->from_id)?->name)
                    ->label(trans('filament-ecommerce::messages.orders.columns.account_id'))
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('date')
                    ->label('Date')
                    ->date('Y-m-d')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('due_date')
                    ->label('Due Date')
                    ->tooltip(fn($record) => $record->due_date->isFuture() ? $record->due_date->diffForHumans() : ($record->due_date->isToday() ? 'Due Today!' : 'Over Due!'))
                    ->color(fn($record) => $record->due_date->isFuture() ? 'success' : ($record->due_date->isToday() ? 'warning' : 'danger'))
                    ->icon(fn($record) => $record->due_date->isFuture() ? 'heroicon-s-check-circle' : ($record->due_date->isToday() ? 'heroicon-s-exclamation-circle' : 'heroicon-s-x-circle'))
                    ->date('Y-m-d')
                    ->sortable()
                    ->toggleable(),
                TypeColumn::make('status')
                    ->label(trans('filament-ecommerce::messages.orders.columns.status'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label(trans('filament-ecommerce::messages.orders.columns.name'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->description(fn($record) => $record->phone)
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label(trans('filament-ecommerce::messages.orders.columns.phone'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->label(trans('filament-ecommerce::messages.orders.columns.address'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('shipping')
                    ->label(trans('filament-ecommerce::messages.orders.columns.shipping'))
                    ->money(locale: 'en', currency: (fn($record) => $record->currency?->iso))
                    ->color('warning')
                    ->sortable(),
                Tables\Columns\TextColumn::make('vat')
                    ->label(trans('filament-ecommerce::messages.orders.columns.vat'))
                    ->money(locale: 'en', currency:(fn($record) => $record->currency?->iso))
                    ->color('warning')
                    ->sortable(),
                Tables\Columns\TextColumn::make('discount')
                    ->label(trans('filament-ecommerce::messages.orders.columns.discount'))
                    ->money(locale: 'en', currency: (fn($record) => $record->currency?->iso))
                    ->color('danger')
                    ->sortable(),
                Tables\Columns\TextColumn::make('total')
                    ->label(trans('filament-ecommerce::messages.orders.columns.total'))
                    ->money(locale: 'en', currency: (fn($record) => $record->currency?->iso))
                    ->color('success')
                    ->sortable(),
                Tables\Columns\TextColumn::make('paid')
                    ->label("Paid")
                    ->money(locale: 'en', currency: (fn($record) => $record->currency?->iso))
                    ->color('info')
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(trans('filament-ecommerce::messages.orders.columns.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                Tables\Filters\SelectFilter::make('status')
                    ->options(Type::query()->where('for', 'invoices')->where('type', 'status')->pluck('name', 'key')->toArray())
                    ->label('Status')
                    ->searchable(),
                Tables\Filters\SelectFilter::make('type')
                    ->options(Type::query()->where('for', 'invoices')->where('type', 'type')->pluck('name', 'key')->toArray())
                    ->label('Type')
                    ->searchable(),
                Tables\Filters\Filter::make('due')
                    ->form([
                        Forms\Components\Toggle::make('overdue')
                            ->label('Over Due'),
                        Forms\Components\Toggle::make('today')
                            ->label('Today'),
                    ])
                    ->label('Due Date')
                    ->query(function (Builder $query, array $data) {
                        return $query->when($data['overdue'], function (Builder $query, $value) {
                            if($value){
                                $query->whereDate('due_date', '<', Carbon::now());
                            }

                        })->when($data['today'], function (Builder $query, $value) {
                            if($value){
                                $query->whereDate('due_date', Carbon::today());
                            }
                        });
                    }),
                Tables\Filters\Filter::make('for_id')
                    ->form([
                        Forms\Components\Select::make('for_type')
                            ->searchable()
                            ->live()
                            ->options(FilamentInvoices::getFor()->pluck('label', 'model')->toArray())
                            ->label('For Type'),
                        Forms\Components\Select::make('for_id')
                            ->searchable()
                            ->options(fn(Forms\Get $get) => $get('for_type') ? $get('for_type')::query()->pluck(FilamentInvoices::getFor()->where('model', $get('for_type'))->first()?->column??'name', 'id')->toArray() : [])
                            ->label('For Name'),
                    ])
                    ->label('Filter By For')
                    ->query(function (Builder $query, array $data) {
                        return $query->when($data['for_type'], function (Builder $query, $value) {
                            if($value){
                                $query->where('for_type', $value);
                            }

                        })->when($data['for_id'], function (Builder $query, $value) {
                            if($value){
                                $query->where('for_id', $value);
                            }
                        });
                    }),
                Tables\Filters\Filter::make('from_id')
                    ->form([
                        Forms\Components\Select::make('from_type')
                            ->searchable()
                            ->live()
                            ->options(FilamentInvoices::getFor()->pluck('label', 'model')->toArray())
                            ->label('From Type'),
                        Forms\Components\Select::make('from_id')
                            ->searchable()
                            ->options(fn(Forms\Get $get) => $get('from_type') ? $get('from_type')::query()->pluck(FilamentInvoices::getFrom()->where('model', $get('from_type'))->first()?->column??'name', 'id')->toArray() : [])
                            ->label('From Name'),
                    ])
                    ->label('Filter By From')
                    ->query(function (Builder $query, array $data) {
                        return $query->when($data['from_type'], function (Builder $query, $value) {
                            if($value){
                                $query->where('from_type', $value);
                            }
                        })->when($data['from_id'], function (Builder $query, $value) {
                            if($value){
                                $query->where('from_id', $value);
                            }
                        });
                    }),
            ])
            ->actionsPosition(ActionsPosition::BeforeColumns)
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\Action::make('pay')
                    ->hidden(fn($record) => ($record->total === $record->paid) || $record->status === 'paid' || $record->status === 'estimate')
                    ->requiresConfirmation()
                    ->iconButton()
                    ->color('info')
                    ->fillForm(fn($record) => [
                        'total' => $record->total,
                        'paid' => $record->paid,
                        'amount' => $record->total - $record->paid,
                    ])
                    ->form([
                        Forms\Components\TextInput::make('total')
                            ->label('Total')
                            ->numeric()
                            ->disabled(),
                        Forms\Components\TextInput::make('paid')
                            ->label('Paid')
                            ->numeric()
                            ->disabled(),
                        Forms\Components\TextInput::make('amount')
                            ->label('Amount')
                            ->required()
                            ->numeric(),
                    ])
                    ->action(function (array $data, Invoice $record) {
                        $record->update([
                            'paid' => $record->paid + $data['amount']
                        ]);

                        $record->invoiceMetas()->create([
                            'key' => 'payments',
                            'value' => $data['amount']
                        ]);

                        $record->invoiceLogs()->create([
                            'log' => 'Paid '.number_format($data['amount'], 2).' '.$record->currency->iso . ' By: ' . auth()->user()->name,
                            'type' => 'payment',
                        ]);

                        if($record->total === $record->paid){
                            $record->update([
                                'status' => 'paid'
                            ]);
                        }

                        Notification::make()
                            ->title('Invoice Paid')
                            ->body('Invoice Paid Successfully')
                            ->success()
                            ->send();
                    })
                    ->icon('heroicon-s-credit-card')
                    ->label('Pay For Invoice')
                    ->modalHeading('Pay For Invoice')
                    ->tooltip('Pay For Invoice'),
                Tables\Actions\ViewAction::make()->iconButton()->tooltip('View Invoice'),
                Tables\Actions\EditAction::make()->iconButton()->tooltip('Edit Invoice'),
                Tables\Actions\DeleteAction::make()
                    ->iconButton()
                    ->icon('heroicon-s-archive-box')
                    ->label('Archive Invoice')
                    ->modalHeading('Archive Invoice')
                    ->tooltip('Archive Invoice'),
                Tables\Actions\ForceDeleteAction::make()->iconButton()->tooltip('Delete Invoice Forever'),
                Tables\Actions\RestoreAction::make()->iconButton()->tooltip('Restore Invoice'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('status')
                        ->label('Change Status')
                        ->tooltip('Change Status of Selected Invoices')
                        ->icon('heroicon-s-cursor-arrow-rays')
                        ->deselectRecordsAfterCompletion()
                        ->form([
                            Forms\Components\Select::make('status')
                                ->searchable()
                                ->options(Type::query()->where('for', 'invoices')->where('type', 'status')->pluck('name', 'key')->toArray())
                                ->label('Status')
                                ->default('draft')
                                ->required(),
                        ])
                        ->action(function (array $data, Collection $records) {
                            $records->each(fn($record) => $record->update(['status' => $data['status']]));

                            Notification::make()
                                ->title('Status Changed')
                                ->body('Status Changed Successfully')
                                ->success()
                                ->send();
                        })
                    ,
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make()
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
           RelationManagers\InvoiceLogManager::make(),
           RelationManagers\InvoicePaymentsManager::make(),
        ];
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInvoices::route('/'),
            'create' => Pages\CreateInvoice::route('/create'),
            'edit' => Pages\EditInvoice::route('/{record}/edit'),
            'view' => Pages\ViewInvoice::route('/{record}/show'),
        ];
    }
}

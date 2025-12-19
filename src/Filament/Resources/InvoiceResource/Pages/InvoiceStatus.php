<?php

namespace TomatoPHP\FilamentInvoices\Filament\Resources\InvoiceResource\Pages;

use Filament\Actions\Action;
use Filament\Forms\Components\ColorPicker;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use TomatoPHP\FilamentIcons\Components\IconPicker;
use TomatoPHP\FilamentInvoices\Facades\FilamentInvoices;
use TomatoPHP\FilamentInvoices\Filament\Resources\InvoiceResource;
use TomatoPHP\FilamentTranslationComponent\Components\Translation;
use TomatoPHP\FilamentTypes\Components\TypeColumn;
use TomatoPHP\FilamentTypes\Models\Type;

class InvoiceStatus extends Page implements HasTable
{
    use InteractsWithTable;

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    protected ?string $status = null;

    protected static string | null | \BackedEnum $navigationIcon = 'heroicon-o-cog';

    protected string $view = 'filament-invoices::settings.status';

    public array $data = [];

    public function mount(): void
    {
        FilamentInvoices::loadTypes();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->action(fn () => redirect()->to(InvoiceResource::getUrl('index')))
                ->color('danger')
                ->label(trans('filament-settings-hub::messages.back')),
        ];
    }

    public function getTitle(): string
    {
        return trans('filament-invoices::messages.settings.status.title');
    }

    public function table(Table $table): Table
    {

        return $table->query(Type::query()->where('for', 'invoices'))
            ->paginated(false)
            ->columns([
                TypeColumn::make('key')
                    ->label(trans('filament-invoices::messages.settings.status.columns.status')),
            ])
            ->recordActions([
                \Filament\Actions\Action::make('edit')
                    ->label(trans('filament-invoices::messages.settings.status.action.edit'))
                    ->tooltip(trans('filament-invoices::messages.settings.status.action.edit'))
                    ->form([
                        Translation::make('name')
                            ->label(trans('filament-invoices::messages.settings.status.columns.value')),
                        IconPicker::make('icon')->label(trans('filament-invoices::messages.settings.status.columns.icon')),
                        ColorPicker::make('color')->label(trans('filament-invoices::messages.settings.status.columns.color')),
                    ])
                    ->fillForm(fn (Type $record) => $record->toArray())
                    ->icon('heroicon-s-pencil-square')
                    ->iconButton()
                    ->action(function (array $data, Type $type) {
                        $type->update($data);
                        Notification::make()
                            ->title(trans('filament-invoices::messages.settings.status.action.notification'))
                            ->success()
                            ->send();
                    }),
            ]);
    }
}

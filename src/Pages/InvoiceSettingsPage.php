<?php

namespace TomatoPHP\FilamentInvoices\Pages;

use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use TomatoPHP\FilamentInvoices\Settings\InvoiceSettings;
use TomatoPHP\FilamentSettingsHub\Traits\UseShield;

class InvoiceSettingsPage extends SettingsPage
{
    use UseShield;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-document-text';

    protected static string $settings = InvoiceSettings::class;

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public function getTitle(): string
    {
        return trans('filament-invoices::messages.settings.title');
    }

    protected function getActions(): array
    {
        $tenant = \Filament\Facades\Filament::getTenant();
        if ($tenant) {
            return [
                Action::make('back')
                    ->action(fn () => redirect()->route('filament.' . filament()->getCurrentPanel()->getId() . '.pages.settings-hub', $tenant))
                    ->color('danger')
                    ->label(trans('filament-settings-hub::messages.back')),
            ];
        }

        return [
            Action::make('back')
                ->action(fn () => redirect()->route('filament.' . filament()->getCurrentPanel()->getId() . '.pages.settings-hub'))
                ->color('danger')
                ->label(trans('filament-settings-hub::messages.back')),
        ];
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make(trans('filament-invoices::messages.settings.sections.company'))
                    ->description(trans('filament-invoices::messages.settings.sections.company_description'))
                    ->schema([
                        TextInput::make('company_name')
                            ->label(trans('filament-invoices::messages.settings.fields.company_name'))
                            ->required()
                            ->columnSpan(2),
                        FileUpload::make('company_logo')
                            ->label(trans('filament-invoices::messages.settings.fields.company_logo'))
                            ->image()
                            ->directory('invoices/logos')
                            ->columnSpan(2),
                        Textarea::make('company_address')
                            ->label(trans('filament-invoices::messages.settings.fields.company_address'))
                            ->rows(3)
                            ->columnSpan(2),
                        TextInput::make('company_phone')
                            ->label(trans('filament-invoices::messages.settings.fields.company_phone'))
                            ->tel(),
                        TextInput::make('company_email')
                            ->label(trans('filament-invoices::messages.settings.fields.company_email'))
                            ->email(),
                        TextInput::make('company_tax_id')
                            ->label(trans('filament-invoices::messages.settings.fields.company_tax_id'))
                            ->columnSpan(2),
                    ])->columns(2),

                Section::make(trans('filament-invoices::messages.settings.sections.defaults'))
                    ->description(trans('filament-invoices::messages.settings.sections.defaults_description'))
                    ->schema([
                        Select::make('default_currency')
                            ->label(trans('filament-invoices::messages.settings.fields.default_currency'))
                            ->options([
                                'USD' => 'USD - US Dollar',
                                'EUR' => 'EUR - Euro',
                                'GBP' => 'GBP - British Pound',
                                'EGP' => 'EGP - Egyptian Pound',
                                'SAR' => 'SAR - Saudi Riyal',
                                'AED' => 'AED - UAE Dirham',
                            ])
                            ->searchable()
                            ->required(),
                        TextInput::make('default_tax_rate')
                            ->label(trans('filament-invoices::messages.settings.fields.default_tax_rate'))
                            ->numeric()
                            ->suffix('%')
                            ->minValue(0)
                            ->maxValue(100),
                        TextInput::make('default_payment_terms')
                            ->label(trans('filament-invoices::messages.settings.fields.default_payment_terms'))
                            ->numeric()
                            ->suffix(trans('filament-invoices::messages.settings.fields.days'))
                            ->minValue(0)
                            ->required(),
                    ])->columns(3),

                Section::make(trans('filament-invoices::messages.settings.sections.email'))
                    ->description(trans('filament-invoices::messages.settings.sections.email_description'))
                    ->schema([
                        TextInput::make('email_from_name')
                            ->label(trans('filament-invoices::messages.settings.fields.email_from_name')),
                        TextInput::make('email_from_email')
                            ->label(trans('filament-invoices::messages.settings.fields.email_from_email'))
                            ->email(),
                        TextInput::make('email_subject_template')
                            ->label(trans('filament-invoices::messages.settings.fields.email_subject_template'))
                            ->helperText(trans('filament-invoices::messages.settings.fields.email_placeholders'))
                            ->columnSpan(2),
                        Textarea::make('email_body_template')
                            ->label(trans('filament-invoices::messages.settings.fields.email_body_template'))
                            ->helperText(trans('filament-invoices::messages.settings.fields.email_placeholders'))
                            ->rows(6)
                            ->columnSpan(2),
                        TextInput::make('email_cc')
                            ->label(trans('filament-invoices::messages.settings.fields.email_cc'))
                            ->email()
                            ->helperText(trans('filament-invoices::messages.settings.fields.email_cc_help')),
                        TextInput::make('email_bcc')
                            ->label(trans('filament-invoices::messages.settings.fields.email_bcc'))
                            ->email()
                            ->helperText(trans('filament-invoices::messages.settings.fields.email_bcc_help')),
                    ])->columns(2),

                Section::make(trans('filament-invoices::messages.settings.sections.pdf'))
                    ->description(trans('filament-invoices::messages.settings.sections.pdf_description'))
                    ->schema([
                        Select::make('default_template')
                            ->label(trans('filament-invoices::messages.settings.fields.default_template'))
                            ->options([
                                'classic' => trans('filament-invoices::messages.templates.classic'),
                                'modern' => trans('filament-invoices::messages.templates.modern'),
                                'minimal' => trans('filament-invoices::messages.templates.minimal'),
                                'professional' => trans('filament-invoices::messages.templates.professional'),
                                'creative' => trans('filament-invoices::messages.templates.creative'),
                            ])
                            ->required(),
                        Select::make('paper_size')
                            ->label(trans('filament-invoices::messages.settings.fields.paper_size'))
                            ->options([
                                'a4' => 'A4',
                                'letter' => 'Letter',
                                'legal' => 'Legal',
                            ])
                            ->required(),
                        Toggle::make('include_terms')
                            ->label(trans('filament-invoices::messages.settings.fields.include_terms'))
                            ->columnSpan(2),
                        Textarea::make('terms_text')
                            ->label(trans('filament-invoices::messages.settings.fields.terms_text'))
                            ->rows(4)
                            ->columnSpan(2),
                    ])->columns(2),
            ])->columns(1);
    }
}

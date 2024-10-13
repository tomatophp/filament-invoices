![Screenshot](https://raw.githubusercontent.com/tomatophp/filament-invoices/master/arts/3x1io-tomato-invoices.jpg)

# Filament Invoices Manager

[![Latest Stable Version](https://poser.pugx.org/tomatophp/filament-invoices/version.svg)](https://packagist.org/packages/tomatophp/filament-invoices)
[![License](https://poser.pugx.org/tomatophp/filament-invoices/license.svg)](https://packagist.org/packages/tomatophp/filament-invoices)
[![Downloads](https://poser.pugx.org/tomatophp/filament-invoices/d/total.svg)](https://packagist.org/packages/tomatophp/filament-invoices)

Generate and manage your invoices / payments using multi currencies and multi types in FilamentPHP

## Features

- [x] Generate Invoices
- [x] Manage Invoices
- [x] Print Invoices
- [x] Invoices Facade Class
- [x] Invoices Morph From/For
- [x] Invoices Payments
- [x] Support Multi Type
- [x] Support Multi Currency
- [x] Support Multi Status
- [x] Status Manager
- [x] Invoices Widgets
- [ ] Send Invoice using Email
- [ ] Export Invoice as PDF
- [ ] Invoices Templates
- [ ] Invoices Settings

## Screenshots

![Home](https://raw.githubusercontent.com/tomatophp/filament-invoices/master/arts/home.png)
![Create](https://raw.githubusercontent.com/tomatophp/filament-invoices/master/arts/create.png)
![Edit](https://raw.githubusercontent.com/tomatophp/filament-invoices/master/arts/edit.png)
![View](https://raw.githubusercontent.com/tomatophp/filament-invoices/master/arts/view.png)
![Print](https://raw.githubusercontent.com/tomatophp/filament-invoices/master/arts/print.png)
![Logs](https://raw.githubusercontent.com/tomatophp/filament-invoices/master/arts/logs.png)
![Status](https://raw.githubusercontent.com/tomatophp/filament-invoices/master/arts/status.png)
![Payments](https://raw.githubusercontent.com/tomatophp/filament-invoices/master/arts/payments.png)
![Payment Amount](https://raw.githubusercontent.com/tomatophp/filament-invoices/master/arts/payment-amount.png)

## Installation

```bash
composer require tomatophp/filament-invoices
```
after install your package please run this command

```bash
php artisan filament-invoices:install
```

finally register the plugin on `/app/Providers/Filament/AdminPanelProvider.php`

```php
->plugin(\TomatoPHP\FilamentInvoices\FilamentInvoicesPlugin::make())
```

## Using

to start use this plugin you need to allow 2 types of users or table to fill the invoices from / for after you prepare your models use this Facade class like this on your `AppServiceProvider` or any other service provider

```php
use TomatoPHP\FilamentInvoices\Facades\FilamentInvoices;
use TomatoPHP\FilamentInvoices\Services\Contracts\InvoiceFor;
use TomatoPHP\FilamentInvoices\Services\Contracts\InvoiceFrom;

public function boot()
{
    FilamentInvoices::registerFor([
        InvoiceFor::make(Account::class)
            ->label('Account')
    ]);
    FilamentInvoices::registerFrom([
        InvoiceFrom::make(Company::class)
            ->label('Company')
    ]);
}
```

after that you can use the plugin on your filament admin panel

## Use Facade Class To Create Invoice

you can use this Facade class to create invoice like this

```php
\TomatoPHP\FilamentInvoices\Facades\FilamentInvoices::create()
    ->for(\App\Models\Account::find(1))
    ->from(\App\Models\Account::find(2))
    ->dueDate(now()->addDays(7))
    ->date(now())
    ->items([
        \TomatoPHP\FilamentInvoices\Services\Contracts\InvoiceItem::make('Item 1')
            ->description('Description 1')
            ->qty(2)
            ->price(100),
        \TomatoPHP\FilamentInvoices\Services\Contracts\InvoiceItem::make('Item 2')
            ->description('Description 2')
            ->qty(1)
            ->discount(10)
            ->vat(10)
            ->price(200),
    ])->save();            
```

## Publish Assets

you can publish config file by use this command

```bash
php artisan vendor:publish --tag="filament-invoices-config"
```

you can publish views file by use this command

```bash
php artisan vendor:publish --tag="filament-invoices-views"
```

you can publish languages file by use this command

```bash
php artisan vendor:publish --tag="filament-invoices-lang"
```

you can publish migrations file by use this command

```bash
php artisan vendor:publish --tag="filament-invoices-migrations"
```

## Other Filament Packages

Checkout our [Awesome TomatoPHP](https://github.com/tomatophp/awesome)


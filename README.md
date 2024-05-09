![Screenshot](https://github.com/tomatophp/filament-invoices/blob/master/arts/3x1io-tomato-invoices.jpg)

# Filament Invoices Generator

[![Latest Stable Version](https://poser.pugx.org/tomatophp/filament-invoices/version.svg)](https://packagist.org/packages/tomatophp/filament-invoices)
[![PHP Version Require](http://poser.pugx.org/tomatophp/filament-invoices/require/php)](https://packagist.org/packages/tomatophp/filament-invoices)
[![License](https://poser.pugx.org/tomatophp/filament-invoices/license.svg)](https://packagist.org/packages/tomatophp/filament-invoices)
[![Downloads](https://poser.pugx.org/tomatophp/filament-invoices/d/total.svg)](https://packagist.org/packages/tomatophp/filament-invoices)

Generate and manage yours invoices in Filament

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

## Support

you can join our discord server to get support [TomatoPHP](https://discord.gg/Xqmt35Uh)

## Docs

you can check docs of this package on [Docs](https://docs.tomatophp.com/plugins/laravel-package-generator)

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Security

Please see [SECURITY](SECURITY.md) for more information about security.

## Credits

- [Fady Mondy](mailto:info@3x1.io)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

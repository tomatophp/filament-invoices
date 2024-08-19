<?php

namespace TomatoPHP\FilamentInvoices\Facades;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use TomatoPHP\FilamentInvoices\Services\Contracts\InvoiceFor;
use TomatoPHP\FilamentInvoices\Services\Contracts\InvoiceFrom;

/**
 * @method static \TomatoPHP\FilamentInvoices\Services\Contracts\InvoiceFrom registerFrom(array|InvoiceFrom $from)
 * @method static \TomatoPHP\FilamentInvoices\Services\Contracts\InvoiceFor registerFor(array|InvoiceFor $for)
 * @method static Collection getFrom()
 * @method static Collection getFor()
 * @method static \TomatoPHP\FilamentInvoices\Services\CreateInvoice create()
 * @method static void loadTypes()
 */
class FilamentInvoices extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'filament-invoices';
    }
}

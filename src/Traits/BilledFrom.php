<?php

namespace TomatoPHP\FilamentInvoices\Traits;

use TomatoPHP\FilamentInvoices\Facades\FilamentInvoices;

trait BilledFrom
{
    public function invoices()
    {
        return $this->morph('from');
    }
}

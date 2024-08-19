<?php

namespace TomatoPHP\FilamentInvoices\Traits;

use TomatoPHP\FilamentInvoices\Facades\FilamentInvoices;

trait BilledFor
{
    public function invoices()
    {
        return $this->morph('for');
    }
}

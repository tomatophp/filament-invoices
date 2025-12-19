<?php

namespace TomatoPHP\FilamentInvoices\Traits;

trait BilledFor
{
    public function invoices()
    {
        return $this->morph('for');
    }
}

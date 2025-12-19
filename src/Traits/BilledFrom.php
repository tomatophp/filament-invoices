<?php

namespace TomatoPHP\FilamentInvoices\Traits;

trait BilledFrom
{
    public function invoices()
    {
        return $this->morph('from');
    }
}

<?php

namespace TomatoPHP\FilamentInvoices\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use TomatoPHP\FilamentInvoices\Models\Invoice;
use TomatoPHP\FilamentLocations\Models\Location;

trait InteractsWithInvoices
{
    public function invoicesFor(): MorphMany
    {
        return $this->morphMany(Invoice::class, 'for');
    }

    public function invoicesFrom(): MorphMany
    {
        return $this->morphMany(Invoice::class, 'from');
    }

    public function locations(): MorphMany
    {
        return $this->morphMany(Location::class, 'model');
    }
}

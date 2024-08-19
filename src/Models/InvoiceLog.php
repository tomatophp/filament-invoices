<?php

namespace TomatoPHP\FilamentInvoices\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $invoice_id
 * @property json $log
 * @property string $type
 * @property string $created_at
 * @property string $updated_at
 * @property Invoice $invoice
 */
class InvoiceLog extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'invoice_id',
        'log',
        'type',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'log' => 'json',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}

<?php

namespace TomatoPHP\FilamentInvoices\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $invoice_id
 * @property string $key
 * @property mixed $value
 * @property string $type
 * @property string $group
 * @property string $created_at
 * @property string $updated_at
 * @property Invoice $invoice
 */
class InvoiceMeta extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'invoice_id',
        'key',
        'value',
        'type',
        'group',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'value' => 'json',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}

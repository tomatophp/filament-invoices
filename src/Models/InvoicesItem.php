<?php

namespace TomatoPHP\FilamentInvoices\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $invoice_id
 * @property string $type
 * @property string $item_type
 * @property integer $item_id
 * @property string $item
 * @property string $description
 * @property string $note
 * @property float $qty
 * @property float $price
 * @property float $discount
 * @property float $vat
 * @property float $total
 * @property float $returned_qty
 * @property float $returned
 * @property boolean $is_free
 * @property boolean $is_returned
 * @property mixed $options
 * @property string $created_at
 * @property string $updated_at
 * @property Invoice $invoice
 */
class InvoicesItem extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'invoice_id',
        'type',
        'item_type',
        'item_id',
        'item',
        'description',
        'note',
        'qty',
        'price',
        'discount',
        'vat',
        'total',
        'returned_qty',
        'returned',
        'is_free',
        'is_returned',
        'options',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'is_free' => 'bool',
        'is_returned' => 'bool',
        'options' => 'json'
    ];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}

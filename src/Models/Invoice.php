<?php

namespace TomatoPHP\FilamentInvoices\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use TomatoPHP\FilamentLocations\Models\Currency;
use TomatoPHP\FilamentTypes\Models\Type;

/**
 * @property integer $id
 * @property integer $from_id
 * @property string $bank_account
 * @property string $bank_account_owner
 * @property string $bank_iban
 * @property string $bank_swift
 * @property string $bank_address
 * @property string $bank_branch
 * @property string $bank_name
 * @property string $shipping
 * @property string $bank_city
 * @property string $bank_country
 * @property boolean $is_bank_transfer
 * @property string $from_type
 * @property integer $currency_id
 * @property integer $for_id
 * @property string $for_type
 * @property integer $order_id
 * @property integer $user_id
 * @property integer $category_id
 * @property string $uuid
 * @property string $name
 * @property string $phone
 * @property string $address
 * @property string $type
 * @property string $status
 * @property float $total
 * @property float $discount
 * @property float $vat
 * @property float $paid
 * @property string $date
 * @property string $due_date
 * @property boolean $is_activated
 * @property boolean $is_offer
 * @property boolean $send_email
 * @property string $notes
 * @property string $created_at
 * @property string $updated_at
 * @property InvoiceMeta[] $invoiceMetas
 * @property Account $account
 * @property Branch $branch
 * @property Category $category
 * @property Order $order
 * @property User $user
 * @property Currency $currency
 * @property InvoicesItem[] $invoicesItems
 */
class Invoice extends Model
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = [
        'bank_account',
        'bank_account_owner',
        'bank_iban',
        'bank_swift',
        'bank_address',
        'bank_branch',
        'bank_name',
        'bank_city',
        'bank_country',
        'is_bank_transfer',
        'currency_id',
        'from_id',
        'from_type',
        'for_id',
        'for_type',
        'order_id',
        'user_id',
        'category_id',
        'uuid',
        'name',
        'phone',
        'address',
        'type',
        'status',
        'total',
        'discount',
        'vat',
        'paid',
        'date',
        'due_date',
        'is_activated',
        'is_offer',
        'send_email',
        'shipping',
        'notes',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'date' => 'datetime',
        'is_offer' => 'bool',
        'is_activated' => 'bool',
        'send_email' => 'bool',
        'is_bank_transfer' => 'bool',
    ];

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id', 'id');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invoiceMetas()
    {
        return $this->hasMany(InvoiceMeta::class);
    }

    /**
     * @param string $key
     * @param string|array|object|null $value
     * @return Model|string|array|null
     */
    public function meta(string $key, string|array|object|null $value=null): Model|string|null|array
    {
        if($value!==null){
            if($value === 'null'){
                return $this->invoiceMetas()->updateOrCreate(['key' => $key], ['value' => null]);
            }
            else {
                return $this->invoiceMetas()->updateOrCreate(['key' => $key], ['value' => $value]);
            }
        }
        else {
            $meta = $this->invoiceMetas()->where('key', $key)->first();
            if($meta){
                return $meta->value;
            }
            else {
                return $this->invoiceMetas()->updateOrCreate(['key' => $key], ['value' => null]);
            }
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Type::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invoicesItems()
    {
        return $this->hasMany(InvoicesItem::class);
    }

    public function billedFor()
    {
        return $this->morphTo('for', 'for_type', 'for_id');
    }

    public function billedFrom()
    {
        return $this->morphTo('from', 'from_type', 'from_id');
    }

    public function invoiceLogs()
    {
        return $this->hasMany(InvoiceLog::class);
    }
}

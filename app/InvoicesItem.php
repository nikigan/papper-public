<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Model;

/**
 * Vanguard\InvoicesItem
 *
 * @property int $id
 * @property int $invoice_id
 * @property string $name
 * @property float $quantity
 * @property float $price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\InvoicesItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\InvoicesItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\InvoicesItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\InvoicesItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\InvoicesItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\InvoicesItem whereInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\InvoicesItem whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\InvoicesItem wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\InvoicesItem whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\InvoicesItem whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class InvoicesItem extends Model
{

    protected $fillable = ['invoice_id', 'product_id', 'name', 'quantity', 'price'];

    public function invoice()
    {
        $this->hasOne(Invoice::class);
    }

}

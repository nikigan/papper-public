<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Model;

/**
 * Vanguard\VatRate
 *
 * @property int $id
 * @property float $vat_rate
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\VatRate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\VatRate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\VatRate query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\VatRate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\VatRate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\VatRate whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\VatRate whereVatRate($value)
 * @mixin \Eloquent
 */
class VatRate extends Model
{
    protected $guarded = [];
}

<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Model;

/**
 * Vanguard\PaymentType
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\PaymentType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\PaymentType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\PaymentType query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\PaymentType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\PaymentType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\PaymentType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\PaymentType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PaymentType extends Model
{
    protected $guarded = [];
}

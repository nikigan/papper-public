<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Model;

/**
 * Vanguard\Currency
 *
 * @property int $id
 * @property string $name
 * @property string $ISO_code
 * @property string $sign
 * @property float $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\Currency newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\Currency newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\Currency query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\Currency whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\Currency whereISOCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\Currency whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\Currency whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\Currency whereSign($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\Currency whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\Currency whereValue($value)
 * @mixin \Eloquent
 */
class Currency extends Model
{
    protected $guarded = [];
}

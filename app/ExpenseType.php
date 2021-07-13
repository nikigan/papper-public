<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Model;

/**
 * Vanguard\ExpenseType
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $expense_group_id
 * @property-read \Vanguard\ExpenseGroup|null $expense_group
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\ExpenseType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\ExpenseType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\ExpenseType query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\ExpenseType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\ExpenseType whereExpenseGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\ExpenseType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\ExpenseType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\ExpenseType whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $vat_rate_id
 * @property-read \Vanguard\VatRate $vat_rate
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\ExpenseType whereVatRateId($value)
 */
class ExpenseType extends Model
{
    protected $guarded = [];

    public function expense_group()
    {
        return $this->belongsTo(ExpenseGroup::class);
    }

    public function vat_rate()
    {
        return $this->belongsTo(VatRate::class);
    }
}

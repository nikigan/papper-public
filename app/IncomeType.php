<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Model;

/**
 * Vanguard\IncomeType
 *
 * @property int $id
 * @property string $name
 * @property int|null $income_group_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Vanguard\IncomeGroup|null $income_group
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\IncomeType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\IncomeType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\IncomeType query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\IncomeType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\IncomeType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\IncomeType whereIncomeGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\IncomeType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\IncomeType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class IncomeType extends Model
{
    protected $guarded = [];

    public function income_group() {
        return $this->belongsTo(IncomeGroup::class);
    }
}

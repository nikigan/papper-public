<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Model;

/**
 * Vanguard\IncomeGroup
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Vanguard\IncomeType[] $income_types
 * @property-read int|null $income_types_count
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\IncomeGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\IncomeGroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\IncomeGroup query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\IncomeGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\IncomeGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\IncomeGroup whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\IncomeGroup whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class IncomeGroup extends Model
{
    protected $guarded = [];

    public function income_types() {
        return $this->hasMany(IncomeType::class);
    }
}

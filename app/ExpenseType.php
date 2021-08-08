<?php

namespace Vanguard;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Vanguard\ExpenseType
 *
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $expense_group_id
 * @property-read ExpenseGroup|null $expense_group
 * @method static Builder|ExpenseType newModelQuery()
 * @method static Builder|ExpenseType newQuery()
 * @method static Builder|ExpenseType query()
 * @method static Builder|ExpenseType whereCreatedAt( $value )
 * @method static Builder|ExpenseType whereExpenseGroupId( $value )
 * @method static Builder|ExpenseType whereId( $value )
 * @method static Builder|ExpenseType whereName( $value )
 * @method static Builder|ExpenseType whereUpdatedAt( $value )
 * @mixin Eloquent
 * @property int $vat_rate_id
 * @property-read VatRate $vat_rate
 * @method static Builder|ExpenseType whereVatRateId( $value )
 * @property-read Collection|Document[] $documents
 * @property-read int|null $documents_count
 */
class ExpenseType extends Model
{
    protected $guarded = [];

    public function expense_group() {
        return $this->belongsTo( ExpenseGroup::class );
    }

    public function vat_rate() {
        return $this->belongsTo( VatRate::class );
    }

    public function documents() {
        return $this->hasMany( Document::class );
    }
}

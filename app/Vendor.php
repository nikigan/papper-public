<?php

namespace Vanguard;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Vanguard\Vendor
 *
 * @property int $id
 * @property string $vat_number
 * @property string $name
 * @property string $email
 * @property string|null $phone
 * @property string|null $address
 * @property int $creator_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Document[] $documents
 * @property-read int|null $documents_count
 * @method static Builder|Vendor newModelQuery()
 * @method static Builder|Vendor newQuery()
 * @method static Builder|Vendor query()
 * @method static Builder|Vendor whereAddress( $value )
 * @method static Builder|Vendor whereCreatedAt( $value )
 * @method static Builder|Vendor whereCreatorId( $value )
 * @method static Builder|Vendor whereEmail( $value )
 * @method static Builder|Vendor whereId( $value )
 * @method static Builder|Vendor whereName( $value )
 * @method static Builder|Vendor wherePhone( $value )
 * @method static Builder|Vendor whereUpdatedAt( $value )
 * @method static Builder|Vendor whereVatNumber( $value )
 * @mixin Eloquent
 * @property int|null $default_expense_type_id
 * @method static Builder|Vendor whereDefaultExpenseTypeId( $value )
 * @property-read ExpenseType|null $default_expense_type
 */
class Vendor extends Model
{
    protected $guarded = [];

    public function documents() {
        return $this->hasMany( Document::class );
    }

    public function default_expense_type() {
        return $this->belongsTo(ExpenseType::class, 'default_expense_type_id');
    }
}

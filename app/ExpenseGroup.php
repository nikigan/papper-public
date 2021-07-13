<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Model;

/**
 * Vanguard\ExpenseGroup
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Vanguard\Document[] $documents
 * @property-read int|null $documents_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Vanguard\ExpenseType[] $expense_types
 * @property-read int|null $expense_types_count
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\ExpenseGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\ExpenseGroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\ExpenseGroup query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\ExpenseGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\ExpenseGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\ExpenseGroup whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\ExpenseGroup whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ExpenseGroup extends Model
{
    protected $guarded = [];

    public function expense_types()
    {
        return $this->hasMany(ExpenseType::class);
    }

    public function documents()
    {
        return $this->hasManyThrough(Document::class, ExpenseType::class);
    }
}

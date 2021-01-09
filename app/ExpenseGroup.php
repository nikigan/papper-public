<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Model;

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

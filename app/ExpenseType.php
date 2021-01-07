<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Model;

class ExpenseType extends Model
{
    protected $guarded = [];

    public function expense_group()
    {
        return $this->belongsTo(ExpenseGroup::class);
    }
}

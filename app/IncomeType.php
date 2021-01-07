<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Model;

class IncomeType extends Model
{
    protected $guarded = [];

    public function income_group() {
        return $this->belongsTo(IncomeGroup::class);
    }
}

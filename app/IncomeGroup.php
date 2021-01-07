<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Model;

class IncomeGroup extends Model
{
    protected $guarded = [];

    public function income_types() {
        return $this->hasMany(IncomeType::class);
    }
}

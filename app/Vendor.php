<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $guarded = [];

    public function documents() {
        return $this->belongsToMany(Document::class);
    }
}

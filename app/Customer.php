<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';

    protected $fillable = ['name', 'email', 'phone', 'address', 'creator_id', 'vat_number'];


    public function creator()
    {
        $this->belongsTo(User::class, 'creator_id');
    }
}

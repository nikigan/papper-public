<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Model;

/**
 * Vanguard\Customer
 *
 * @property int $id
 * @property string $vat_number
 * @property string $name
 * @property string $email
 * @property string|null $phone
 * @property string|null $address
 * @property int $creator_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\Customer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\Customer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\Customer query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\Customer whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\Customer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\Customer whereCreatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\Customer whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\Customer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\Customer whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\Customer wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\Customer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\Customer whereVatNumber($value)
 * @mixin \Eloquent
 */
class Customer extends Model
{
    protected $table = 'customers';

    protected $fillable = ['name', 'email', 'phone', 'address', 'creator_id', 'vat_number'];


    public function creator()
    {
        $this->belongsTo(User::class, 'creator_id');
    }
}

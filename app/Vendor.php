<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Model;

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
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Vanguard\Document[] $documents
 * @property-read int|null $documents_count
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\Vendor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\Vendor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\Vendor query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\Vendor whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\Vendor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\Vendor whereCreatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\Vendor whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\Vendor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\Vendor whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\Vendor wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\Vendor whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\Vendor whereVatNumber($value)
 * @mixin \Eloquent
 */
class Vendor extends Model
{
    protected $guarded = [];

    public function documents() {
        return $this->belongsToMany(Document::class);
    }
}

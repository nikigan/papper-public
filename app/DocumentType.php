<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Model;

/**
 * Vanguard\DocumentType
 *
 * @property int $id
 * @property string $name
 * @property string $prefix
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Vanguard\OrganizationType[] $organization_types
 * @property-read int|null $organization_types_count
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\DocumentType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\DocumentType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\DocumentType query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\DocumentType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\DocumentType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\DocumentType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\DocumentType wherePrefix($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\DocumentType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class DocumentType extends Model
{
    protected $guarded = [];

    public function organization_types()
    {
        return $this->belongsToMany(OrganizationType::class, 'document_type_organization_type', 'organization_type', 'document_type');
    }
}

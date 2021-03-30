<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Model;

/**
 * Vanguard\OrganizationType
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $have_tax
 * @property-read \Illuminate\Database\Eloquent\Collection|\Vanguard\DocumentType[] $document_types
 * @property-read int|null $document_types_count
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\OrganizationType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\OrganizationType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\OrganizationType query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\OrganizationType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\OrganizationType whereHaveTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\OrganizationType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\OrganizationType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Vanguard\OrganizationType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class OrganizationType extends Model
{
    protected $guarded = [];

    public function document_types()
    {
        return $this->belongsToMany(DocumentType::class, 'document_type_organization_type', 'organization_type', 'document_type');
    }
}

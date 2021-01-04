<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Model;

class DocumentType extends Model
{
    protected $guarded = [];

    public function organization_types()
    {
        return $this->belongsToMany(OrganizationType::class, 'document_type_organization_type', 'organization_type', 'document_type');
    }
}

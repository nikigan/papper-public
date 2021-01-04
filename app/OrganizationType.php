<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Model;

class OrganizationType extends Model
{
    protected $guarded = [];

    public function document_types()
    {
        return $this->belongsToMany(DocumentType::class, 'document_type_organization_type', 'organization_type', 'document_type');
    }
}

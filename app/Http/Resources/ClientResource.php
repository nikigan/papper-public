<?php

namespace Vanguard\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Vanguard\User;

/**
 * Class ClientResource
 * @package Vanguard\Http\Resources
 * @mixin User
 */
class ClientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "email" => $this->email,
            "username" => $this->username,
            "first_name" => $this->first_name,
            "last_name" => $this->last_name,
            "documents_count" => $this->documents->count(),
            "phone" => $this->phone,
            "avatar" => $this->avatar,
            "address" => $this->address,
            "role_id" => $this->role->name,
            "auditor_id" => $this->auditor_id,
            "accountant_id" => $this->accountant_id,
            "organization_type_id" => $this->organization_type_id,
            "vat_number" => $this->vat_number,
            "passport" => $this->passport,
            "tax_percent" => $this->tax_percent,
            "social_security" => $this->social_security,
            "report_period" => $this->report_period,
            "social_security_number" => $this->social_security_number,
            "default_income_type_id" => $this->default_income_type_id,
            "mh_advances" => $this->mh_advances,
            "mh_deductions" => $this->mh_deductions,
            "portfolio" => $this->portfolio,
            "notify" => $this->notify,
            "notification_rate" => $this->notification_rate
        ];
    }
}

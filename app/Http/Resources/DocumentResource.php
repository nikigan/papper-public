<?php

namespace Vanguard\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;
use Vanguard\Document;

/**
 * Class DocumentResource
 * @package Vanguard\Http\Resources
 * @mixin Document
 */
class DocumentResource extends JsonResource
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
            "document_number" => $this->document_number,
            "file" => $this->file,
            "user_id" => $this->user_id,
            "creator" => $this->user->present()->name,
            "document_text" => $this->document_text,
            "status" => $this->status,
            "document_date" => Carbon::parseFromLocale($this->document_date, "en"),
            "document_type" => __($this->document_type === 0 ? "Expense" : "Income"),
            "currency_sign" => $this->currency->sign,
            "sum_without_vat" => $this->sum_without_vat,
            "vat" => $this->vat,
            "sum" => $this->sum
        ];
    }
}

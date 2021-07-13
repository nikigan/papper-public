<?php

namespace Vanguard\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Vanguard\Invoice;

/**
 * Class InvoiceResource
 * @package Vanguard\Http\Resources
 * @mixin Invoice
 */
class InvoiceResource extends JsonResource
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
            "invoice_number" => $this->invoice_number,
            "invoice_date" => $this->invoice_date,
            "customer" => $this->customer,
            "creator" => $this->creator,
            "tax_percent" => $this->tax_percent,
            "document_type" => $this->dt,
            "currency" => $this->currency,
            "payment_type" => $this->payment_type,
            "include_tax" => !!$this->include_tax,
            "note" => $this->note,
            "income_type" => $this->income_type,
            "invoice_items" => $this->invoice_items,
            "total" => $this->total_amount,
            "vat_sum" => $this->total_amount * ($this->tax_percent / 100),
            "grand_total" => $this->grand_total
        ];
    }
}

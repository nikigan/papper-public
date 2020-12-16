<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{

    protected $fillable = ['invoice_number', 'invoice_date', 'user_id', 'tax_percent', 'customer_id', 'creator_id'];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class);
    }

    public function invoice_items()
    {
        return $this->hasMany(InvoicesItem::class);
    }

    public function document_type()
    {
        return $this->belongsTo(DocumentType::class, 'document_type');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    public function payment_type()
    {
        return $this->belongsTo(PaymentType::class, 'payment_type');
    }

    public function getTotalAmountAttribute()
    {
        $total_amount = 0;
        foreach ($this->invoice_items as $item) {
            $total_amount += $item->price * $item->quantity;
        }
        return $total_amount;
    }

}

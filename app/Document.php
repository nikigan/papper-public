<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Vanguard\Presenters\DocumentPresenter;
use Vanguard\Presenters\Traits\Presentable;

class Document extends Model
{
    use Presentable;

    protected $presenter = DocumentPresenter::class;
    protected $fillable = ['file', 'user_id', 'document_number', 'sum', 'sum_without_vat', 'vat', 'document_type', 'status', 'document_date', 'vendor_id', 'currency_id', 'expense_type_id', 'note', 'document_type_id'];

    public function user()
    {
        return $this->belongsTo('Vanguard\User');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function expense_type()
    {
        return $this->belongsTo(ExpenseType::class, 'expense_type_id');
    }

    public function expense_group()
    {
        return $this->belongsTo(ExpenseGroup::class);
    }

    public function income_type()
    {
        return $this->belongsTo(IncomeType::class, 'income_type_id');
    }

    public function dt()
    {
        return $this->belongsTo(DocumentType::class, 'document_type_id');
    }

    public function getDate()
    {
        return Carbon::parse($this->created_at)->format('H:i d.m.Y');
    }

    public function getDocumentDate()
    {
        return Carbon::parse($this->document_date)->format(config('app.date_format'));
    }

    public function getDocumentDateAttribute($value)
    {
        return Carbon::parse($value)->format(config('app.date_format'));
    }
}

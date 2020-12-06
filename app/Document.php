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
    protected $fillable = ['file', 'user_id', 'document_number', 'sum', 'sum_without_vat', 'vat', 'document_type', 'status', 'document_date'];

    public function user()
    {
        return $this->belongsTo('Vanguard\User');
    }

    public function getDate() {
        return Carbon::parse($this->created_at)->format('H:i d.m.Y');
    }

    public function getDocumentDate() {
        return Carbon::parse($this->document_date)->format(config('app.date_format'));
    }
}

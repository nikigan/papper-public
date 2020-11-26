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
    protected $fillable = ['file', 'user_id'];

    public function user()
    {
        return $this->belongsTo('Vanguard\User');
    }

    public function getDate() {
        return Carbon::parse($this->created_at)->format('H:i d.m.Y');
    }
}

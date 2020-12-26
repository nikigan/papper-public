<?php

namespace Vanguard\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class InvoiceSearch implements Filter
{
    public function __invoke(Builder $query, $search, string $property = '')
    {
        $query->where(function ($q) use ($search) {
            $q->where('invoice_number', "like", "%{$search}%");
        });

        /*$query->orWhereHas('creator', function ($q) use ($search) {
            $q->where('email', "like", "%{$search}%");
        });

        $query->orWhereHas('customer', function ($q) use ($search) {
            $q->where('email', "like", "%{$search}%");
        });*/
    }
}

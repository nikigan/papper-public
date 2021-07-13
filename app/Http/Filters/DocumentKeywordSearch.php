<?php

namespace Vanguard\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class DocumentKeywordSearch implements Filter
{
    public function __invoke(Builder $query, $search, string $property = '')
    {
        $query->where(function ($q) use ($search) {
            $q->where('document_number', "like", "%{$search}%");
            $q->orWhere('document_text', 'like', "%{$search}%");
            $q->orWhereHas('User');
        });
    }
}

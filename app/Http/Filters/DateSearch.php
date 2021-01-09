<?php

namespace Vanguard\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class DateSearch implements Filter
{
    public function __invoke(Builder $query, $date, $property = '')
    {
        $end_date = $date['end_date'];
        $start_date = $date['start_date'];

        if ($end_date) {
            $query->where(function ($q) use ($end_date, $property) {
                $q->where($property, "<=", $end_date);
            });
        }

        if ($start_date) {
            $query->where(function ($q) use ($start_date, $property) {
                $q->where($property, ">=", $start_date);
            });
        }

    }
}

<?php

namespace Vanguard\Scopes;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class TableSortScope implements Scope {

    public function apply( Builder $builder, Model $model ) {

        if ($model->sort_table_name()) {
            $table_name = $model->sort_table_name() . "_";
        } else {
            $table_name = "";
        }

        if (request()->has("sort_prop")) {
            $builder->getQuery()->orders = null;
            $builder->orderBy(request()->get("sort_prop"), request()->get("sort_order") ?? 'desc');
        }

        if (request()->has("{$table_name}sort_prop")) {
            $builder->getQuery()->orders = null;
            $builder->orderBy(request()->get("{$table_name}sort_prop"), request()->get("{$table_name}sort_order") ?? 'desc');
        }


    }
}

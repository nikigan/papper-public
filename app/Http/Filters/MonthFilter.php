<?php


namespace Vanguard\Http\Filters;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class MonthFilter implements Filter {

    public function __invoke( Builder $query, $value, string $property ) {
        if ( $value['start_date'] && $value['end_date'] ) {
            $end_date   = Carbon::createFromFormat( "m-Y", $value['end_date'] );
            $start_date = Carbon::createFromFormat( "m-Y", $value['start_date'] );

            if ( $end_date ) {
                $query->where( function ( $q ) use ( $end_date, $property ) {
                    $q->whereMonth( $property, "<=", $end_date->month )->whereYear( $property, "<=", $end_date->year );
                } );
            }

            if ( $start_date ) {
                $query->where( function ( $q ) use ( $start_date, $property ) {
                    $q->whereMonth( $property, ">=", $start_date->month )->whereYear( $property, ">=", $start_date->year );
                } );
            }
        }

        return $query;
    }
}

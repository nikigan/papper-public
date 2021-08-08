<?php

namespace Vanguard\Http\Filters;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class DateSearch implements Filter
{
    public function __invoke(Builder $query, $date, $property = '') {
        if ( $date['start_date'] || $date['end_date'] ) {

            if ( isset( $date['end_date'] ) ) {
                $end_date = Carbon::createFromFormat( config( 'app.date_format' ), $date['end_date'] );

                $query->where( function ( $q ) use ( $end_date, $property ) {
                    $q->whereDate( $property, "<=", $end_date );
                } );
            }

            if ( isset( $date['start_date'] ) ) {
                $start_date = Carbon::createFromFormat( config( 'app.date_format' ), $date['start_date'] );

                $query->where( function ( $q ) use ( $start_date, $property ) {
                    $q->whereDate( $property, ">=", $start_date );
                } );
            }
        }

        return $query;

    }
}
